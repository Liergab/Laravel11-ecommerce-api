<template>
    <PublicLayout>
        <section class="flex items-center justify-center">
            <div class="flex-1 w-full min-h-[400px] flex flex-col gap-1 ">
                <h1 class="text-8xl font-bold max-w-[600px] bg-gradient-to-br from-slate-800 to-violet-400 bg-clip-text text-transparent">
                SHOPPING 
                </h1>
                <h1 class="text-5xl font-semibold text-slate-600">
                    ONLINE
                </h1>
                <h2 class="text-lg font-semibold mt-10 text-slate-600  max-w-[500px] text-justify">
                    Lorem ipsum dolor sit amet, 
                    consectetur adipiscing elit. 
                    Sed do eiusmod tempor incididunt
                    ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud
                    exercitation ullamco laboris nisi ut 
                    aliquip ex ea commodo consequat.
                </h2>

                <div class="mt-7">
                    <router-link to="/login">
                        <Button class="bg-violet-300 py-2 px-20 text-lg font-bold text-slate-600">SIGN IN</Button>
                    </router-link>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center ">
                <img :src="bg" alt="bg"  class="w-12/12" />
            </div>
        </section>
    </PublicLayout>
   <ProductSection/>
   <WhyChoiceUsSection/>
   <Footer/>
</template>

<script setup>
import PublicLayout from '../../components/layout/PublicLayout.vue';
import ProductSection from '../../components/Home/ProductSection.vue'
import WhyChoiceUsSection from '../../components/Home/WhyChoiceUsSection.vue';
import Footer from '../../components/Home/Footer.vue';
import bg from '../../assets/image/bg.gif'
import Button from 'primevue/button'

</script>

