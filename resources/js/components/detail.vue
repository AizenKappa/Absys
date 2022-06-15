

<template>
<section>

    <div class="w-[100%] h-[2.5rem] flex justify-center">
        <!-- Filieres_Select -->
        <select id="filieres_select" v-model="selected" class="font-medium w-[80%] h-full">
            <option class="hidden">choose your class</option>
            <option>Tous Filieres</option>
            <option :value="fil.id" v-for="fil in filieres" :key="fil.id">{{fil.nom_fil}}</option>
        </select>
    </div>

    <div class="w-full px-12 mt-[5rem] flex justify-between">
        <select class="w-[30%] py-1" v-model="selected_p">
            <option class="hidden" selected>Periode</option>
            <option>Cette semaine</option>
            <option>La semain precedent</option>
            <option>Ce mois</option>
            <option>Le mois precedent</option>
            <option>L'annee entiere</option>
            <option value="show_date">Limitation</option>
        </select>
        <div v-if="selected_p == 'show_date'" class="w-[50%] flex justify-around items-center">
            <input class="w-[40%] px-2" type="date"><fas icon="angles-right" />
            <input class="w-[40%] px-2" type="date">
        </div>
    </div>
    <div class="w-full pl-[90%] mt-[2rem]">
        <button class="text-2xl text-white rounded-full w-[3rem] h-[3rem] shadow-md shadow-bleu-500"><fas icon="magnifying-glass" /></button>
    </div>
</section>
</template>

<script setup>
    import { ref } from 'vue';
    import useFilieres from '../services/filieres.js'
    import { onMounted } from 'vue';

    /* Variables Help-us */
    const selected = ref("choose your class")
    const selected_p = ref("Periode")

    /* Call Api Groupes */
    const getcontents = () =>  { selected_gp.value = "choose your groupe" , getgroupes(selected.value)}
    /* Return all our functuons and variables from { services/filieres.js } to use here */
    const { getFilieres , filieres , profs , getgroupes , groupes , stagiaires, getstagiaires , nom_gp } = useFilieres();
    /* On Mounted call Aoi Flieres */
    onMounted(getFilieres())
    
</script>
<style scoped>
    button{
        background-color: rgb(0, 143, 255);
        border: 1px solid rgb(0, 143, 255);
    }
    button:hover{
        background-color: rgb(0, 120, 255);
        border: 1px solid rgb(0, 120, 255);
    }
    button:active{
        background-color: rgb(0, 100, 255);
        border: 1px solid rgb(0, 100, 255);
    }
</style>