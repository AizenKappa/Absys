

<template>
<section class="h-auto relative">

    <div id="helper">
            <!-- -- Dashboard-header -- -->
        <div class="md:h-screen md:w-[16rem] w-[96%] md:mx-0 mt-3 md:mt-0 bg-white md:overflow-y-scroll md:fixed absolute z-20">
            <div id="dashboard-header" class="flex justify-between mt-8 mb-10 mx-6">
                <h1 class=" text-sm uppercase font-bold">Hello User</h1>
            </div>
            <!-- -- Caeds -- -->
            <cards />

        </div>
    </div>
    <div id="home" class="md:pl-[16rem] bg-blue-50 h-full">
        <!-- --home page -- -->
        <div class="relative h-full">
            <div class="md:h-[20rem] h-[30rem] bg-sky-600">
            <div id="contents" class="absolute top-0 w-full h-full z-10">
                <!-- -- Navbar  -- -->
                <div class="w-full h-20 md:px-14 md:pt-4 bg-blue-50 md:bg-sky-600 flex justify-between px-6 pt-5 ">
                    <span class="hidden md:block mt-3 font-bold text-white uppercase text-sm">Dashboard</span>
                        <img
                        @click="show=!show" 
                        class="rounded-full h-12 w-12 cursor-pointer" 
                        ><!-- src="https://source.unsplash.com/random/500x500/?face" -->
                </div>
                <div id="page-contents" class="w-full h-auto">
                <!-- --  contents -- -->
                <router-view />
                </div>
            </div>
            </div>
            <!-- -- Profile -- -->
            <div v-show="show" class="w-44 h-28 bg-white rounded z-30 absolute top-16 md:right-20 right-10">
            <ul>
                <li class="px-4 py-3">View profile</li>
                <li><hr></li>
                <li class="px-4 p-3"><a href="/logout">Logout</a></li>
            </ul>
            </div>
        </div>
    </div>

</section>
</template>

<script setup>

    import { ref } from 'vue';

    const show = ref(false)

</script>