<?php
namespace  App\Http\Services\Implementations;

use App\Http\Services\AuthServices;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthImplementation implements AuthServices
{

    public function register($request)
    {
        $validated = $request->validate([
            "name"     => "required|string",
            "email"    => "required|string|email|unique:users",
            "password" => "required|confirmed",
            "default_billing_address_id"  => "nullable",
            "default_shipping_address_id" => "nullable"
        ]);

        $user = User::create($validated);
        Mail::to($user->email)->send(new WelcomeMail($user));
        return response()->json([
                "data"         => $user,
                "status"       => true,
                "token_type"   => "Bearer",
                "access_token" => $user->createToken('api_token')->plainTextToken
            ], 201); 
    }

    public function login($request)
    {
        $validated = $request->validate([
            "email"    => "required|email|string",
            "password" => "required|string"
        ]);
    
        if(!Auth::attempt($validated)){
            return response()->json([
                'message' => 'user credential invalid'
            ],401);
        }
        $userData = auth()->user();
        $user = User::where('email', $validated['email'])->first();
        
        return response()->json([
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
            'data' => $userData
        ]);
    }

    public function profile()
    {
        $userData = auth()->user()->load('addresses');

        return response()->json([
            'data' => $userData
        ],200);
    }

    public function updateProfile($request)
    {
        $user = auth()->user();
        $addresses = $user->addresses()
                         ->get();

        if ($addresses->isEmpty()) {
            return response()->json([
                'message' => 'You don\'t have any address. Please add an address first.'
            ], 400);
        }

        $defaultBillingAddressId = $addresses->first()->id;

        $validated = $request->validate([
                "name" => "string",
                "email" => "string|email|unique:users",
                "password" => "confirmed",
        ]);

        if ($user->id === $request->user()->id) {
            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }
            $validated['default_billing_address_id'] = $defaultBillingAddressId;
            $validated['default_shipping_address_id'] = $defaultBillingAddressId;
            $user->update($validated);

            return response()->json([
                    'message' => 'User information updated successfully!',
                    'data' => $user
                ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthorized to update this user.'
            ], 403);
        }
    }

    public function logout()
    {
        request()->user()
                 ->tokens()
                 ->delete();

        return response()->json([
            'message' => 'UserLogout!'
        ],200);
    }
}