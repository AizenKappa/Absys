
<template>
<section class="h-[45rem] relative">

    <!-- Dropdowns - FIliere - Groupes -->
    <div id class=" px-10 flex justify-between">
        <div class="w-[100%] h-[2rem] flex justify-between">
                <!-- Filieres_Select -->
            <select id="filieres_select" v-model="selected" class="w-[34rem] font-medium " v-on:change="getcontents()">
                <option class="hidden">choose your class</option>
                <option :value="fil.id" v-for="fil in filieres" :key="fil.id">{{fil.nom_fil}}</option>
            </select>
                <!-- Groupes_select -->
            <select v-if="selected != 'choose your class'" class="w-[23rem] font-medium"
            v-model="selected_gp"
            v-on:change="getstContents()">
                <option class="hidden">choose your groupe</option>
                <option :value="gp.id" v-for="gp in groupes" :key="gp.id">{{gp.nom_gp}}</option>
            </select>
        </div>
    </div>

    <!-- Stagiaire table -->
    <div v-if="nom_gp != null" class="antialiased text-gray-600 md:pr-[12rem] md:px-[8rem] py-[3rem]">
            <div class="flex flex-col justify-center">
            <div class="w-full mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                <header class="px-5 py-4 border-b border-gray-200 w-full">
                    <h2 class="font-semibold text-gray-800">{{nom_gp}}</h2>
                </header>
                <div class=" w-full">
                <div class="overflow-y-scroll h-[23rem]">
                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Name</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Prenom</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nombre d'heures d'absences NJ</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            <tr class=" hover:bg-slate-200 cursor-pointer" v-for="st in stagiaires" :key="st.id"  @click="getJustifTable(st.id)" >
                                <td class="p-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="font-medium text-gray-800">{{st.nom_st}}</div>
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{st.prenom_st}}</div>
                                </td>
                                    <td class="p-2 whitespace-nowrap">
                                    <div>
                                       {{ getNbAbsences(st.etat)}}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            </div>
    </div>

    <!-- Justif Table -->
    <div v-if="list_etats != false" class="antialiased text-gray-600 px-[6rem] py-[3rem]">
            <div class="flex flex-col justify-center">
            <div class="w-full mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                <header class="px-5 py-4 border-b border-gray-200 w-full">
                    <h2 class="font-semibold text-gray-800">{{nom_gp}}</h2>
                </header>
                <div class="p-3 w-full">
                <div class="overflow-y-scroll h-[23rem]">
                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nom</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Prenom</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">date_absence</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Heure debut</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Heure fin</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Formateur</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Seance</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Justifier</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            <tr v-for="(item, index) in list_etats" :key="index">

                                <td class="p-2 whitespace-nowrap">
                                    <div class="font-medium text-gray-800">{{getStName(item.stagiaire_id,true)}}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{getStName(item.stagiaire_id,false)}}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{item.date_abs}}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{item.h_debut}}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{item.h_fin}}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{ getProfName(item.prof_id) }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{item.seance}}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div><input type="checkbox" class="h-4 w-4"></div>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            </div>
    </div>

    <!-- Motif -->
    <div v-if="list_etats != false" class="px-8 flex justify-between md:pr-14">
        <div class="w-[26rem]">
        <select v-model="selected_motif" class="w-[10rem] p-1 m-5 font-medium shadow-lg shadow-gray-300" v-on:change="selected_motif_autre = null">
            <option class="hidden">Motif</option>
            <option>A.....</option>
            <option>B.....</option>
            <option>C.....</option>
            <option value="autre">Autre</option>
        </select>
        <input class="h-7 px-2 shadow-lg shadow-gray-300" v-if="selected_motif == 'autre'" type="text" v-model="selected_motif_autre" >
        </div>
        <button class="text-2xl text-white rounded-full w-[3rem] h-[3rem] "><fas icon="arrow-right" /></button>
    </div>
    
    <!-- Not found -->
    <div v-if="show_error" class=" h-screen grid place-content-center top-0 w-full">
        <img class="w-[10rem]" src="./cards/page.png">
    </div>
     
</section>
</template>

<script setup>

    import { ref } from 'vue';
    import useFilieres from '../services/filieres.js'
    import { onMounted } from 'vue';

    /* Variables Help-us */
    const selected = ref("choose your class")

    const selected_motif = ref("Motif")
    const selected_motif_autre = ref(null)

    const selected_gp = ref("choose your groupe")
    const list_etats = ref(false)
    const show_error = ref(false)
    /* Call Api Groupes */
    const getcontents = () =>  { selected_gp.value = "choose your groupe" , getgroupes(selected.value)}
    /* Return all our functuons and variables from { services/filieres.js } to use here */
    const { getFilieres , filieres , profs , getgroupes , groupes , stagiaires, getstagiaires , nom_gp } = useFilieres();
    /* On Mounted call Aoi Flieres */
    onMounted(getFilieres())
    const getstContents = () => { getstagiaires(selected_gp.value) , list_etats.value = false ,show_error.value = false }
    /* This function hide stagiaires table and show Justif table */
    const getJustifTable = (id) => {
        var list = []
        stagiaires.value.forEach(st => {
            if(st.id == id) {
                list_etats.value = st.etat
                return true
            }});nom_gp.value = null

        if(list_etats.value[0] == undefined ){
            show_error.value = true
        }
    }

    /* Calcule total Absences NJ */
    const getNbAbsences = (array) => {
        var total = array.reduce(( sum , currentOject )=> sum + getabsence(currentOject) ,0 )
        return total
    }
    
    /* My own timeDiff function */
    const getabsence = (e) => {
        var hour1 , hour2 , minute1 , minute2
        
        e.h_debut[0] == "0"  ? hour1 = e.h_debut[1] : hour1 = e.h_debut[0] + e.h_debut[1]
        hour2 = e.h_fin[0] + e.h_fin[1]

        var date1 = new Date(2000, 0, 1,  hour1 , e.h_debut[3] + e.h_debut[4]);
        var date2 = new Date(2000, 0, 1, hour2, e.h_fin[3] + e.h_fin[4] );

        return ((date2 - date1)/36e5)
    }
    
    /* Return name of teacher by id */
    const getProfName = (id) => {
        var name = null
        profs.value.forEach(e => {
            if(e.id == id) name = e.nom_prof })  
        return name
    }
    /* Return firstname or lastname of trainee by id */
    const getStName= (id,nom) => {
        var result = null
        stagiaires.value.forEach(e => {
            if(e.id == id){
                nom ? result = e.nom_st : result = e.prenom_st
                return true}
        })  
        return result
    }
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