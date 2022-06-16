

<template>
<section>

    <div class="w-[100%] h-[2.5rem] flex justify-center">
        <!-- Filieres_Select -->
        <select id="filieres_select" v-model="selected_fil" class="font-medium w-[80%] h-full">
            <option value="Tous" selected>Tous Filieres</option>
            <option v-for="fil in filieres" :value="fil.id" :key="fil.id">{{fil.nom_fil}}</option>
        </select>
    </div>

    <div class="w-full px-12 mt-[5rem] flex justify-between">
        <select v-on:change="period_debut = null , period_fin = null" class="w-[30%] py-1" v-model="selected_period">
            <option value="year" selected>L'annee entiere</option>
            <option value="week">Cette semaine</option>
            <option value="subweek">La semain precedent</option>
            <option value="month">Ce mois</option>
            <option value="submonth">Le mois precedent</option>
            <option value="limit">Limitation</option>
        </select>
        <div v-if="selected_period == 'limit'" class="w-[50%] flex justify-around items-center">
            <input v-model="period_debut" class="w-[40%] px-2" type="date"><fas icon="angles-right" required=""/>
            <input v-model="period_fin" class="w-[40%] px-2" type="date">
        </div>
    </div>
    <div class="w-full pl-[90%] mt-[2rem]">
        <button v-on:click="getetats(selected_fil,selected_period,period_debut,period_fin)"
        class="text-2xl text-white rounded-full w-[3rem] h-[3rem] shadow-md shadow-bleu-500"><fas icon="magnifying-glass" /></button>
    </div>
</section>
</template>

<script setup>
    import { ref } from 'vue';
    import useFilieres from '../services/filieres.js'
    import { onMounted } from 'vue';

    /* Variables Help-us */
    const selected_fil = ref("Tous")
    const selected_period = ref("year")
    const period_debut = ref(null)
    const period_fin = ref(null)

    /* Call Api Groupes */
    const getcontents = () =>  { selected_gp.value = "choose your groupe" , getgroupes(selected.value)}
    /* Return all our functuons and variables from { services/filieres.js } to use here */
    const { getFilieres , filieres , profs , getgroupes , groupes , stagiaires, getstagiaires , nom_gp , getetats } = useFilieres();
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