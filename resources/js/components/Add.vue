

<template>


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
                                    <div><input @change="checkStd()" ref="st_inputs"  :name="st.id" value='absent' type="checkbox" class="h-4 w-4"></div>
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
            <select v-model="prof_id" name="prof" class="w-[15rem] font-medium h-[2rem] shadow-lg shadow-gray-300">
                <option class="hidden" :value="null" selected >Le formateur</option>
                <option :value="prof.id" v-for="prof in profs" :key="prof.id">{{prof.nom_prof}}</option>
            </select>
            <select   v-model="absenceDuration" name="absenceDuration" class="w-[12rem] font-medium h-[2rem] shadow-lg shadow-gray-300">
                <!-- <option class="hidden" :value='null'  >La période d'absence</option> -->
                <option value='allDay'  >Toute La Journée</option>
                <option value='matin' :selected="hourMinute < 13.5" >La Matinée</option>
                <option value='midi' :selected="hourMinute > 13.5" >L'après-midi</option>
                <option value='seance-1' >La Première Séance</option>
                <option value='seance-2' >La Deuxième Séance</option>
                <option value='seance-3' >La Troisième Séance</option>
                <option value='seance-4' >La Quatrième Séance</option>
                
            </select>
            <select  v-model="seance" name="seanceType" class="w-[10rem] font-medium h-[2rem] shadow-lg shadow-gray-300">
                <option class="hidden" selected :value="null" >La seance</option>
                <option value='Presentiel' >Presentiel</option>
                <option value="distanciel" >Distanciel</option>
            </select>
        </div>
        <input v-model="date_abs"   class="w-[10rem] font-medium h-[2rem] shadow-lg shadow-gray-300"
         v-if="nom_gp != null" type="date"  name="date_abs" />
    <!-- Button -->
        <div v-if="nom_gp != null" class="w-full pl-[90%] mt-[2rem]">
            
            <button 
         @click="addAbsence()"   :disabled="submitBtn==false"
         :class="submitBtn == true ? 'text-green-600':'text-red-600'"
            class="text-2xl text-white rounded-full
                w-[3rem] h-[3rem]" 
                ><fas icon="arrow-right" /></button>
       
            
        </div>
   
        <span>{{isStdChecked}}</span>-
        <span>{{student_ids}}</span>-
        <span>{{seance}}</span>-
        <span>{{date_abs}}</span>-
        <span>{{prof_id}}</span>-
        <span>{{absenceDuration}}</span>-
</template>


<script setup>
    import axios from "axios";
    import { ref } from 'vue';
    import useFilieres from '../services/filieres.js'
    import { onMounted,onUpdated } from 'vue';
    /* some Logic Variables */
    const currentHour =ref(new Date().getHours()) 
    const currentminutes =ref(new Date().getMinutes())
    const hourMinute = ref((currentHour.value + currentminutes.value/60)) 
    const st_inputs = ref([])
    /* Inputs to send  */
    const prof_id = ref(null);
    const seance = ref(null);
    const date_abs = ref(new Date().toISOString().slice(0, 19).split('T')[0])/* return the date of today  */
    const isStdChecked = ref(false)/* return true if a student is selected False if not */
    const absenceDuration = ref((hourMinute.value < 13.5) ? 'matin':('midi'));
    const student_ids = ref([]);/* an Array that contain all of the student ids selected */

    
    const submitBtn = ref(false);

    function checkStd(){
           isStdChecked.value = false
            student_ids.value = [];
            for(let i = 0 ; i < st_inputs.value.length ; i++){
                var id = st_inputs.value[i].name
                if(st_inputs.value[i].checked ){
                    isStdChecked.value = true
                    student_ids.value.push( Number(id))
                }
            }
           
    }
    
    function addAbsence(){
        // send a POST request
        console.log('entered');
     axios.post('/api/addAbsence', {
            stagiaire_ids:student_ids.value,
            prof_id: prof_id.value,
            absenceDuration:absenceDuration.value,
            seance:seance.value,
            date_abs:date_abs.value
        })
        .then((response) => {
            /* success */
            console.log(response);

        }).catch((error) => {
            /* Error */
            console.log(error);
            });
        reset();
    }
/* fomateur , seance ,student */
    onUpdated(()=>{
        submitBtn.value = formCheck()
    })

    function formCheck(){
        if(isStdChecked.value == false ||  prof_id.value == null
        || seance.value == null){
            return false;
        }
        return true;
    }

    function reset(){
        prof_id.value = null
        isStdChecked.value = false 
        seance.value = null
         for(let i = 0 ; i < st_inputs.value.length ; i++){
                st_inputs.value[i].checked = false;   
            }
    }

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
