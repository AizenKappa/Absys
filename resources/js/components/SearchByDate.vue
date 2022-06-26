

<template>
<section>

    <!-- Filieres_Select -->
    <div class=" px-10">
            <div class="w-[100%] lg:flex lg:justify-between">
                <div class="w-full lg:w-[45%] my-12">
                    <select name="filiere" id="filieres_select" v-model="selected_fil" class="w-full font-medium h-[2rem]" v-on:change="getcontents()">
                        <option value="Tous" selected>Tous Filieres</option>
                        <option  :value="fil.id" v-for="fil in filieres" :key="fil.id">{{fil.nom_fil}}</option>
                    </select>            
                </div>
            </div>
    </div>

    <div class="w-full px-12 grid grid-cols-1 gap-6 lg:flex md:justify-between">
        <select v-on:change="period_debut = null , period_fin = null" class="w-[50%] md:w-[15rem] h-7" v-model="selected_period">
            <option value="year" selected>L'annee entiere</option>
            <option value="week">Cette semaine</option>
            <option value="subweek">La semain precedent</option>
            <option value="month">Ce mois</option>
            <option value="submonth">Le mois precedent</option>
            <option value="limit">Limitation</option>
        </select>
        <div v-if="selected_period == 'limit'" class="sm:w-[28rem] w-[100%] place-items-center gap-4 grid grid-cols-1 sm:flex justify-between items-center">
            <input v-model="period_debut" class="sm:w-[12rem] w-[60%] px-2" type="date" required>
            <fas class="hidden sm:block" icon="angles-right"/><fas class="block sm:hidden" icon="angles-down"/>
            <input v-model="period_fin" class="sm:w-[12rem] w-[60%] px-2" type="date" required>
        </div>
    </div>


    <div class="grid place-content-end px-5 py-6">
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