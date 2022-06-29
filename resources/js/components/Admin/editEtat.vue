<template>
   <input type="text"/>
    <div class="w-full lg:w-[45%] my-12">
        <select   class="w-full font-medium h-[2rem]" @change="changeFil"  v-model="selectedFil" >
            <option    value="all" selected>Tous les Filieres</option>
            <option  :value="fil.id" v-for="(fil,index) in allFilWithGroupes" :key="fil.id">{{fil.nom_fil}}</option>
        </select>
    </div>

    <!-- <nav v-if="selectedFil!='all'" class="w-full bg-white px-4 py-5">
        <div class="grid-cols-3 bg-slate-100 lg:scale-100 scale-75 rounded-lg grid sm:grid-cols-5 border-4 border-slate-100">
            <a
            v-for="groupe in currentGroupe "
            :title="groupe.id"
            @click="check" 
            class="p-5 cursor-pointer bg-slate-100 text-center border-b-4 border-transparent" :key="groupe.id">{{groupe.nom_gp}}</a>
        </div>
    </nav> -->
    <select  v-model="selectedGroupe" @change="changeGp">
    
        <template v-if="selectedFil != 'all'">
            <option value="none" class="hidden">Select A Groupe</option>
            <option :value="groupe.id" v-for="groupe in currentGroupe ">{{groupe.nom_gp}}</option>
        </template>
        <template v-else>
            <option value="none" class="hidden" selected>You need to choose a Class </option>
        </template>
        
    </select>
    <!-- {{allFilWithGroupes[selectedFil]}} -->
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-white uppercase bg-sky-600">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nom Complet
                </th>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Formateur
                </th>
                <th  scope="col" class="px-6 py-3">
                    Durée
                </th>
                <th  scope="col" class="px-6 py-3">
                    Type
                </th>
                <th scope="col" class="px-6 py-3">
                    Etat
                </th>
                <th scope="col" class="px-6 py-3">
                    motif
                </th>
                <th scope="col" class="px-6 py-3">
                    Edit
                </th>

            </tr>
        </thead>

        <tbody>
            
        <tr ref="absenceRefs"
         class="bg-white border-b select-none"
         :class="abs.etat_jusitf == 'NJ'?' bg-red-100':''"
         v-for="(abs,index) in currentEtatList" :key="index" >
            <td >
                <!-- <select ref="stag" :disabled="(index == currentEtat)? false:true"  >
                    <option :value="abs.stagiaire_id"    selected></option>
                    <option v-show="st.id != abs.stagiaire_id " :value="st.id" v-for="st in currentStList" :key="st.id">{{st.nom_st+" "+st.prenom_st}}</option>
                </select> -->
                <span>{{ abs.stagiaire.nom_st +" " + abs.stagiaire.prenom_st }}</span>
            </td>
            <td>
                <input ref="date_abs" :disabled="(index == currentEtat)? false:true"
                        type="date" :value="abs.date_abs">
            </td>
            <td>
                <select ref="prof" :disabled="(index == currentEtat)? false:true"  >
                    <option  :value=" abs.prof_id" selected>{{ abs.prof.nom_prof }}</option>
                    <option v-show="prof.id != abs.prof_id " :value="prof.id" v-for="prof in currentProfs" :key="prof.id">{{prof.nom_prof}}</option>
                </select>
            </td>
            <td>
                <select ref="duration" :disabled="(index == currentEtat)? false:true"
                    name="absenceDuration" class="w-[70%] md:w-[15rem] lg:w-[70%] font-medium h-[2rem] shadow-lg shadow-gray-300">
                    <option   :value="abs.duration_id"  >{{abs.duration.title}}</option>
                    <option :value="duration.id"  v-show="duration.id != abs.duration_id"
                      v-for="duration in allDurations" :key="duration.id"
                      >{{duration.title}}</option>
                   
                    
                </select>
            </td>
            <td>
                <select ref="seance" :disabled="(index == currentEtat)? false:true"  >
                    <option  class="hidden" selected>{{ abs.seance }}</option>
                    <option value='Presentiel' >Presentiel</option>
                    <option value="distanciel" >Distanciel</option>>
                </select>
            </td>
            <td>
                <select ref="etat_jusitf"
                    @change="editMotif(index)"
                 :disabled="(index == currentEtat)? false:true"  >
                    <option     class="hidden" selected>{{ abs.etat_justif }}</option>
                    <option     value='NJ' >NJ</option>
                    <option     value="J" >J</option>>
                </select>
            </td>
            <td>
                <input ref="motif" 
                :disabled="abs.etat_justif == 'NJ'"
                 type="text"
                 class="bg-transparent px-2 h-9 focus:outline-cyan-500"
                  :value="abs.motif" size="6">
            </td>
            <td>
                <button ref="editBtn"    class="w-8 cursor-pointer text-blue-600 hover:underline"
                  @click="getInfo(abs.stagiaire.groupe_id,abs.id,index)"
                  >Edit</button>
                <button ref="saveBtn"  class="hidden  cursor-pointer text-green-600 hover:underline " @click="updateEtat(abs.id,index)">Save</button>
                <button ref="deleteBtn"
                  class="hidden  cursor-pointer text-red-600 hover:underline " @click="deleteEtat(abs.id,index)">Delete</button>
            </td>
                <!-- <td class="px-6 py-4">
                    <input :disabled = "true" class="bg-transparent px-2 h-9 focus:outline-cyan-500" type="text" :value="abs.stagiaire.prenom_st ">
                </td>
                <td class="px-6 py-4">
                    <input :disabled = "true" class="bg-transparent px-2 h-9 focus:outline-cyan-500" type="text" :value=" st.num">
                </td>
                <td class="px-6 py-4 text-left font-medium">
                    <select :disabled = "true" class="py-2 px-1">
                        <option class="hidden" selected>{{ st.status }}</option>
                        <option>Active</option>
                        <option>Abondonné</option>

                    </select>
                </td>
                <td class="px-6 py-4 text-left font-medium">
                    <div @click="editThis" class="w-8 cursor-pointer text-blue-600 hover:underline">Edit</div>
                    <div :id="st.id" @click="saveThis" class="w-8 cursor-pointer text-green-600 hover:underline hidden">Save</div>
                </td> -->
            </tr>
        </tbody>

    </table>
    
    
</template>



<script setup>
    import axios from 'axios';
    import {onMounted, ref} from "vue";
    import testVue from '../test.vue';
    
    const message = ref("Hello World")
    const selectedFil = ref("all")
    /*Start raw data */
    const allFilWithGroupes = ref([])
    const allGroupes = ref([])
    const data = ref([])
    const allAbs = ref([])
    const allDurations = ref([])
    /* End raw data */

    const currentEtatList = ref([])
    const selectedGroupe = ref("none")
    const currentGroupe = ref([])
    const fillWithAbs =ref([])
    const currentStList = ref([]);
    const currentProfs = ref([])
    const currentEtat = ref(null)


    const absenceRefs = ref([])
    
   
    const date_abs = ref([]);
    const prof=ref([]);
    const duration = ref([])
    const seance = ref([]);
    const etat_jusitf = ref([]);
    const motif = ref([]);
    
    const currentAbsInfo =ref({
        id:null,
        prof_id:null,
        duration_id:null,
        date_abs:null,
        seance:null,
        etat_justif:null,
        motif:null

    })
     

    const saveBtn = ref([])
    const editBtn =ref([]);
    const deleteBtn= ref([]);
    /* current Edit */
    const editMode = ref(false)
    onMounted(()=>{
        getData()
        
        
    })
    function editMotif(index){
        
        var etat_j = etat_jusitf.value[index]
        var moti = motif.value[index]
        console.log(etat_j.value)
        if(etat_j.value == "NJ"){
            moti.disabled = true
            moti.value = "---"
        }else{
             moti.disabled = false
             moti.value = currentAbsInfo.value.motif
        }
    }
    function updateEtat(abs_id,index){
        
        editBtn.value.forEach((ele)=>{
            
                ele.disabled = false
            
            
        })
        saveBtn.value.forEach((ele)=>{
            
                ele.disabled = false
            
        })
        deleteBtn.value.forEach((ele)=>{
            
                ele.disabled = false
            
        })
        motif.value.forEach((ele)=>{
            
                ele.disabled = true
            
        })
        editBtn.value[index].classList.toggle("hidden")
        deleteBtn.value[index].classList.toggle("hidden")
        saveBtn.value[index].classList.toggle("hidden")
        editMode.value = false
        currentEtat.value = null

        
       
        if(
            date_abs.value[index].value != currentAbsInfo.value.date_abs||
             prof.value[index].value!=currentAbsInfo.value.prof_id||
             duration.value[index].value != currentAbsInfo.value.duration_id||
             seance.value[index].value !=currentAbsInfo.value.seance||
             etat_jusitf.value[index].value != currentAbsInfo.value.etat_justif||
             motif.value[index].value != currentAbsInfo.value.motif   
            ){
                console.log("something has Changed")
                if(allAbs.value[index].motif){
                    allAbs.value[index].motif = motif.value[index].value
                }
                

                sendUpdateRequest(abs_id,
                 prof.value[index].value,duration.value[index].value,
                 date_abs.value[index].value,seance.value[index].value,
                 etat_jusitf.value[index].value,motif.value[index].value,currentAbsInfo.value.duration_id)

                 
                
            }else{
                console.log("no changes")
            }
        
    }

    
    async function sendUpdateRequest(abs_id,prof_id,duration_id,date_abs,seance,etat_justif,motif,last_duration_id){
        let response = await axios.post("/api/updateEtat",
            {
        id:abs_id,
        
        prof_id:prof_id,
        duration_id:duration_id,
        date_abs:date_abs,
        seance:seance,
        etat_justif:etat_justif,
        motif:motif,
        last_duration_id:last_duration_id

    })
    console.log(response)
    }
    async function getData(){
        let response = await axios("/api/etatFil");
        data.value = response.data
        allFilWithGroupes.value = data.value.allFilWithGroupes
        fillWithAbs.value = data.value.fillWithAbs
        allGroupes.value = data.value.allGroupes
        allAbs.value = data.value.allAbs
        currentEtatList.value = allAbs.value
        allDurations.value = data.value.allDurations
        console.log(data.value)
        // gpSelect()
    }
   async function getInfo(groupe_id,abs_id,index){
        
        var etat_j = etat_jusitf.value[index]
        var moti = motif.value[index]
        console.log(etat_j.value)
        if(etat_j.value == "NJ"){
            moti.disabled = true
        }else{
            moti.disabled = false
        }  


        editBtn.value.forEach((ele,ind)=>{
            if(index!=ind){
                ele.disabled = true
            }
            
        })
        saveBtn.value.forEach((ele,ind)=>{
            if(index != ind){
                ele.disabled = true
            }
        })
        deleteBtn.value.forEach((ele,ind)=>{
            if(index != ind){
                ele.disabled = true
            }
        })
        editBtn.value[index].classList.toggle("hidden")
        saveBtn.value[index].classList.toggle("hidden")
        deleteBtn.value[index].classList.toggle("hidden")

        editMode.value = true
        if(currentEtat.value != index){
            console.log(groupe_id)
            currentEtat.value = index
            await axios.post("api/getSome",{
                "groupe_id":groupe_id,
                "abs_id":abs_id
            }).then((response)=>{
                console.log(response.data)
                currentStList.value  = response.data.Stagiaires
                currentProfs.value = response.data.Profs
                currentAbsInfo.value.id=abs_id
                
                currentAbsInfo.value.prof_id = prof.value[index].value
                currentAbsInfo.value.duration_id = duration.value[index].value
                currentAbsInfo.value.date_abs = date_abs.value[index].value
                currentAbsInfo.value.seance = seance.value[index].value
                currentAbsInfo.value.etat_justif = etat_jusitf.value[index].value
                currentAbsInfo.value.motif = motif.value[index].value
            })
        }else{
            console.log("you can' send a Request ")
        }
        
       
    }

    async function deleteEtat(abs_id,index){
        let response = await axios.post("/api/deleteEtat",{
            id:abs_id
        })
        console.log(response.data)
        
        currentEtatList.value =currentEtatList.value.filter((ele,ind)=>{
            return ind != index
        })
   
        editBtn.value.forEach((ele)=>{
            
                ele.disabled = false
            
            
        })
        saveBtn.value.forEach((ele)=>{
            
                ele.disabled = false
            
        })
        deleteBtn.value.forEach((ele)=>{
            
                ele.disabled = false
            
        })
        editBtn.value[index].classList.toggle("hidden")
        deleteBtn.value[index].classList.toggle("hidden")
        saveBtn.value[index].classList.toggle("hidden")
        editMode.value = false
        currentEtat.value = null
        
        
    }

    function changeFil(){
        selectedGroupe.value = "none"
        if(selectedFil.value != "all"){
            currentGroupe.value =  allFilWithGroupes.value[selectedFil.value-1].groupes
             currentEtatList.value = allAbs.value.filter((ele)=>{
                return ele.stagiaire.groupe.filiere_id == selectedFil.value
            })
        }else{
           
        }
    }

    function changeGp(){
        if(selectedFil.value == "all"){
            selectedGroupe.value ="none"
        }else{
            currentEtatList.value = allAbs.value.filter((ele)=>{
                     return ele.stagiaire.groupe_id == selectedGroupe.value
                })
        }
    }

    
</script>

<style scoped>

table  *{
    border:1px solid black;
}
</style>
