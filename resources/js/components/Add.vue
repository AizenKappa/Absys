

<template>
<form target="content" action="api/addAbsence" method="POST" class="h-[45rem]">

    <!-- Dropdowns-Fileres- -->
        <div id class=" px-10 flex justify-between">
            <div class="w-[100%] h-[2rem] flex justify-between">
                <!-- Filieres_Select -->
                <select name="filiere" id="filieres_select" v-model="selected" class="w-[34rem] font-medium " v-on:change="getcontents()">
                    <option class="hidden">choose your class</option>
                    <option  :value="fil.id" v-for="fil in filieres" :key="fil.id">{{fil.nom_fil}}</option>
                </select>
                <!-- Groupes_select -->
                <select name="groupe" v-if="selected != 'choose your class'" class="w-[23rem] font-medium"
                v-model="selected_gp"
                v-on:change="getstagiaires(selected_gp)">
                    <option class="hidden">choose your groupe</option>
                    <option :value="gp.id" v-for="gp in groupes" :key="gp.id">{{gp.nom_gp}}</option>
                </select>
            </div>
        </div>

    <!-- Table -->
        <div v-if="nom_gp != null" class="antialiased text-gray-600 px-[6rem] py-[3rem]">
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
                                    <div class="font-semibold text-left">Name</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Prenom</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Absence</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            <tr v-for="st in stagiaires" :key="st.id" >
                                <td class="p-2 whitespace-nowrap">
                                    <div class="font-medium text-gray-800">{{st.nom_st}}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{st.prenom_st}}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div><input :name="'st-'+st.id" value='absent' type="checkbox" class="h-4 w-4"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            </div>
        </div>          

    <!-- Aboute absence -->
        <div v-if="nom_gp != null" class="w-full flex justify-between px-[3rem]">
            <select name="prof" class="w-[15rem] font-medium h-[2rem] shadow-lg shadow-gray-300">
                <option class="hidden" selected >Le formateur</option>
                <option :value="prof.id" v-for="prof in profs" :key="prof.id">{{prof.nom_prof}}</option>
            </select>

            <label><input name="seance-1" type="checkbox" value='true' ><span class="ml-[1rem]">Seance 1</span></label>
            <label><input name="seance-2" type="checkbox" value='true' ><span class="ml-[1rem]">Seance 2</span></label>
            <label><input name="seance-3" type="checkbox" value='true' ><span class="ml-[1rem]">Seance 3</span></label>
            <label><input name="seance-4" type="checkbox" value='true' ><span class="ml-[1rem]">Seance 4</span></label>

            <select name="seanceType" class="w-[10rem] font-medium h-[2rem] shadow-lg shadow-gray-300">
                <option class="hidden" selected >La seance</option>
                <option value='Presentiel' >Presentiel</option>
                <option value="distanciel" >A distance</option>
            </select>
        </div>
        <input v-if="nom_gp != null" type="date" default="today" name="date_abs" />
    <!-- Button -->
        <div v-if="nom_gp != null" class="w-full pl-[90%] mt-[2rem]">
            
            <button type="submit" 
            class="text-2xl text-white rounded-full
                w-[3rem] h-[3rem]" name="subBtn"><fas icon="arrow-right" /></button>
       
            
        </div>
        
</form>
<!-- <iframe name="content" class="w-full">
</iframe> -->
</template>


<script setup>
    import { ref } from 'vue';
    import useFilieres from '../services/filieres.js'
    import { onMounted } from 'vue';

    /* Variables Help-us */
    const selected = ref("choose your class")
    const selected_gp = ref("choose your groupe")

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
