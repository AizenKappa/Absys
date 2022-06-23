<template>
    <div>
        this is happening  {{ studentId }}
    </div>
        <StagPie  :studentId="studentId" />
</template>


<script setup>
    import {ref,computed,onMounted,reactive, onBeforeMount} from "vue";
    import axios from "axios";
    import { useRouter, useRoute } from 'vue-router';
  
    import StagPie from './StagPie.vue';
    const router = useRouter();
    const route = useRoute();

    const  studentId= ref(route.params.id)
    
    /* Pie Chart Configuration */
    onMounted(()=>{
            window.addEventListener("unload",function(event){
            alert("hello")
           
        })
    })
    
</script>

