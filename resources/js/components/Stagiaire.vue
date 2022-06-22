<template>
    <div>
        this is happening  {{ studentId }}
        
    </div>
    <StagPie  />
</template>


<script setup>
    import {ref,computed,onMounted} from "vue";
    import axios from "axios";
    import { useRouter, useRoute } from 'vue-router';
    import StagPie from './StagPie.vue';
    const router = useRouter();
    const route = useRoute();

    const  studentId= ref(route.params.id)
    const studentInfo = ref({})
    const st_total_abs = ref(0)
    onMounted( ()=>{
        axios.get(`/api/stagiaire/${studentId.value}`).then((response) =>{
             console.log(response.data)
            //  studentInfo.value = response.data[0];
            //  st_total_abs.value = studentInfo.value['heure_absence_st']
            //  console.log(st_total_abs.value)
        })
         
    })

</script>

