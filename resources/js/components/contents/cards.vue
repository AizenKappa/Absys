

<template>
<section id="dashboard-cards" class="font-bold text-sm ">
    <!-- --first card -->


        <div class="card">
            <hr class="px-16 my-5 mt-6">
            <h2 class="px-6 mb-4 text-xs uppercase font-bold text-gray-500 ">Admin section</h2>
            <div class="grid gap-5 px-6 text-gray-400">

                <router-link to="/home" @click="$emit('update:modelValue',check())">
                    <fas icon="user" />
                    <span>Dashboard</span>
                </router-link>

                <router-link to="/add" @click="$emit('update:modelValue',check())">
                    <fas icon="user-graduate" />
                    <span>Ajouter l'absence</span>
                </router-link>

                <router-link to="/just" @click="$emit('update:modelValue',check())">
                    <fas icon="user-graduate" />
                    <span>Justifier l'absence</span>
                </router-link>

                <router-link to="/detail" @click="$emit('update:modelValue',check())">
                    <fas icon="user-graduate" />
                    <span>Deatil Class</span>
                </router-link>
                
            </div>
        </div>


    <!-- --second card -->


        <div class="card">
            <hr class="px-16 my-5 mt-7">
            <h2 class="px-6 mb-4 text-gray-500 text-xs uppercase font-bold ">Admin section</h2>
            <div class="grid gap-5 px-6 text-gray-400">

                <router-link to="/User" @click="$emit('update:modelValue',check())">
                    <fas icon="user-graduate" />
                    <span>Update Users</span>
                </router-link>
                
                <a href="#">ABORT EDU</a>

                <a href="#">ABORT EDU</a>

                <a href="#">ABORT EDU</a>
  

            </div>
        </div>


        
</section>
</template>

<script setup>
    defineProps(['modelValue'])
    defineEmits(['update:modelValue'])

    const check = () => {
        var stmt = null
        window.innerWidth > 767 ? stmt = true : stmt =false
        return stmt
    }
</script>


<style scoped>
    .router-link-active{
        color: rgb(2 132 199);
    }
    span{
        margin-left: 7px;
    }
</style>