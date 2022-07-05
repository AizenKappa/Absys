

<template>

    <section v-if="reboot">

        <!-- Filieres_Select -->
        <div class=" px-10">
                <div class="w-[100%] lg:flex lg:justify-between">
                    <div class="w-full lg:w-[45%] my-12">
                        <select name="filiere" id="filieres_select" v-model="selected_fil" class="w-full font-medium h-[2rem]"
                        @change="getcontents()">
                            <option value="Tous" selected>Tous Filieres</option>
                            <option  :value="fil.id" v-for="fil in filieres" :key="fil.id">{{fil.nom_fil}}</option>
                        </select>            
                    </div>
                </div>
        </div>

        <!-- Period_Select -->
        <div class="w-full px-10 grid grid-cols-1 gap-6 lg:flex md:justify-between">
            <select v-on:change="periodChanged" class=" w-full sm:w-[50%] md:w-[15rem] h-7" v-model="selected_period">
                <option id="year" value="year" selected>L'annee entiere</option>
                <option id="week" value="week">Cette semaine</option>
                <option id="subweek" value="subweek">La semain precedent</option>
                <option id="month" value="month">Ce mois</option>
                <option id="submonth" value="submonth">Le mois precedent</option>
                <option value="limit">Limitation</option>
            </select>
            <div v-if="selected_period == 'limit'" class="sm:w-[28rem] w-[100%] place-items-center gap-4 grid grid-cols-1 sm:flex justify-between items-center">
                <input @change="inputeDate" v-model="period_debut" class="sm:w-[12rem] w-[60%] px-2" type="date" required>
                <fas class="hidden sm:block" icon="angles-right"/><fas class="block sm:hidden" icon="angles-down"/>
                <input @change="inputeDate" v-model="period_fin" class="sm:w-[12rem] w-[60%] px-2" type="date" required>
            </div>
        </div>

        <!-- Groupe_Select -->
        <nav v-if="groupes != null && etats != null" class="w-full bg-white px-4 py-5 mt-6">
            <div class="grid-cols-3 bg-slate-100 lg:scale-100 scale-75 rounded-lg grid sm:grid-cols-5 border-4 border-slate-100">
                <a
                v-for="gp in groupes"
                :title="gp.id"
                @click="changeGp" 
                class="p-5 cursor-pointer bg-slate-100 text-center border-b-4 border-transparent" :key="gp.id">{{ gp.nom_gp }}</a>
            </div>
        </nav>

        <!-- Les Heures -->
        <div class="sm:flex sm:justify-center px-10 sm:px-0 mt-10 lg:scale-100 md:scale-90 sm:scale-75 gap-5 place-content-center grid grid-cols-1 scale-90">
            <a
                id="NJ"
                @click="activeHoure = 'NJ'"
                class="px-6 py-2.5 text-white sm:w-auto w-[100%]  font-medium text-xs uppercase rounded flex select-none
                items-center whitespace-nowrap  cursor-pointer active:bg-blue-800 active:shadow-lg"
                :class="activeHoure == 'NJ'?'bg-blue-800 shadow-lg':'bg-blue-600 shadow-md hover:bg-blue-700'"
                >
                Les Absences Non justifiées
            </a>
            <a
                id="TT"
                @click="activeHoure = 'TT'"
                class="px-6 py-2.5 text-white sm:w-auto w-[100%]  font-medium text-xs uppercase rounded flex select-none
                items-center whitespace-nowrap  cursor-pointer active:bg-blue-800 active:shadow-lg sm:mx-2 lg:mx-8"
                :class="activeHoure == 'TT'?'bg-blue-800 shadow-lg':'bg-blue-600 shadow-md hover:bg-blue-700'"
                >
                Les Absences justifiées et Non justifiées
            </a>
            <a
                id="J"
                @click="activeHoure = 'J'"
                class="px-6 py-2.5 sm:w-auto w-[100%] text-white font-medium text-xs uppercase rounded flex select-none
                items-center whitespace-nowrap cursor-pointer active:bg-blue-800 active:shadow-lg"
                :class="activeHoure == 'J'?'bg-blue-800 shadow-lg':'bg-blue-600 shadow-md hover:bg-blue-700'"
                >
                Les Absences  justifiées
            </a>
        </div>

        <!-- Table Etats -->
        <div id="printTable" v-if="etats != null" class="relative sm:p-5 scale-75 overflow-x-auto shadow-md sm:scale-90 lg:scale-100 s">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-white uppercase bg-cyan-500">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="text-center">Nom</div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="text-center">Date</div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="text-center">Debut</div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="text-center">Fin</div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="text-center">Formateur</div>
                        </th>
                        <th  scope="col" class="px-6 py-3">
                            <div class="text-center">Jutife</div>
                
                        </th>
                        <th  scope="col" class="px-6 py-3">
                            <div class="text-center">Motif</div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="text-center">Seance</div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <template v-if="(Object.keys(etats).length != 0)">
                         <tr ref="absenceRefs"  class="bg-white border-b select-none"
                    v-for="(e,index) in etats" :key="index" >

                        <td class="p-4">
                            <div class="scale-90 w-full font-medium">
                                {{ e.stagiaire.nom_st +" " + e.stagiaire.prenom_st}}
                            </div>             
                        </td>

                        <td class="p-4" >
                            <div class="scale-90 w-full font-medium">
                                {{e.date_abs}}
                            </div> 
                        </td>

                        <td class="p-4">
                            <div class="scale-90 font-medium">
                                {{e.duration.h_debut}}
                            </div>          
                        </td>

                        <td class="px-6 py-4 text-left font-medium">
                            <div class="scale-90">
                            {{e.duration.h_fin}}
                            </div>
                        </td>

                        <td class="px-6 py-4 text-left scale-90 font-medium">
                            {{e.prof.nom_prof}}
                        </td>


                        <td class=" scale-90 font-medium">
                        <div class="text-center">{{e.etat_justif}}</div>
                        </td>


                        <td class="px-6 py-4 text-left scale-90 font-medium">
                        {{e.motif}}
                        </td>

                        <td>
                            <div class="grid grid-cols-1 place-items-center gap-2 scale-90 font-medium">
                                {{e.seance}}
                            </div>
                        </td>

                    </tr>
                    </template>
                    <template v-else>
                        <tr class="bg-white"  v-cloak>
                        <th colspan="8" class="text-lg text-gray-900
                                font-semibold px-6 py-4 text-center whitespace-nowrap">
                            Aucune Absence 
                        </th>
                    </tr>
                    </template>
                   

                </tbody>

            </table>
        </div>
        <button @click="printPdf" class="bg-yellow-200 ml-[50%] text-yellow-900 py-2 px-4
            rounded shadow hover:shadow-xl
            hover:bg-yellow-300 duration-300">
            Print the report
            </button>
    </section>

</template>

<script setup>
    import { ref, reactive, watch } from 'vue';
    import useFilieres from '../services/filieres.js'
    import { onMounted } from 'vue';
    
    /* Variables Help-us */
    const reboot  =ref(true)
    const selected_fil = ref("Tous")
    const selected_gp = ref(null)
    const selected_period = ref("year")
    const period_debut = ref(null)
    const period_fin = ref(null)
    const activeHoure = ref('TT')
    const gpId = ref(null)


    function printPdf(){
        var oldCode =document.documentElement.innerHTML
        var table = document.getElementById('printTable')
        var nom_fil = ""
        
        var period=""
        if(selected_fil.value == "Tous"){
            console.log("entered")
            nom_fil = "Tous les filieres"
        }
        else{
            filieres.value.forEach((ele)=>{
        
                if(ele.id == selected_fil.value ){
                    nom_fil = ele.nom_fil
                    
                }
            })
        }

        if(selected_period.value != "limit"){
            period = document.getElementById(`${selected_period.value}`).innerText
        }
        else if(period_debut.value != null && period_fin.value != null){
            period = period_debut.value + " => " + period_fin.value
        } 

        var newCode =
        `
            <head>
                <style>
                    h3,h4{
                    text-align: center
       
                    }
                table{
                    border-collapse: collapse;
                    width:max-content;  
                    margin:auto
                }
                table ,th,td{
                    border:1px solid black;
                    text-align: center
                }
                *{
                    text-align:center
                }
                </style>
            </head>
            <body>
                
            <body>
        `
            var houreType = document.getElementById(`${activeHoure.value}`).innerText
            document.documentElement.innerHTML = newCode
            document.body.innerHTML +=`<h2>${houreType}</h2>`
            document.body.innerHTML +=`<h3>${nom_fil}</h3>`
            document.body.innerHTML +=`<h4>${period}</h4>`
            if(selected_gp.value != null){
                 document.body.innerHTML +=`<h2>${selected_gp.value}</h2>`
            }
            document.body.innerHTML+=table.innerHTML
            window.print()
            location.reload()
            // reboot.value = false
            // reboot.value = true
            // document.documentElement.innerHTML = oldCode
    }

    const periodChanged = () => {
        period_debut.value = null , period_fin.value = null
        getetats(selected_fil.value,selected_period.value,period_debut.value,period_fin.value)
        activeHoure.value = 'TT'
    }
    const inputeDate = () => {
        if(period_debut.value != null && period_fin.value != null){
            getetats(selected_fil.value,selected_period.value,period_debut.value,period_fin.value)
            activeHoure.value = 'TT'
        }
    }

    
    const changeGp = (event) => {
        
        document.querySelectorAll("a").forEach(element => {
            element.classList.remove("activeLink")
        });
        event.target.classList.add("activeLink")
        selected_gp.value = event.target.innerHTML
        gpId.value = event.target.title
        activeHoure.value == 'TT' ? filterEtat() : filterEtat(activeHoure.value)
        
        
    }

    const filterEtat = (hour = null) => {

        if(gpId.value != null){
            if(hour == null){
                etats.value = allEtats.value.filter((e)=>{
                    return e.stagiaire.groupe_id == gpId.value
                })
            }else{
                etats.value = allEtats.value.filter((e)=>{
                    return e.stagiaire.groupe_id == gpId.value && e.etat_justif == hour
                });
            }
        }else{
            if(hour == null){
                etats.value = allEtats.value.filter((e)=>{
                    return true
                })
            }else{
                console.log("yo")
                etats.value = allEtats.value.filter((e)=>{
                    return e.etat_justif == hour
                });
            }
        }
    }

    watch(() => activeHoure.value, () => {
        if(activeHoure.value == 'NJ') filterEtat('NJ')
        else if(activeHoure.value == 'J') filterEtat('J')
        else if(activeHoure.value == 'TT') filterEtat()
    })

    /* Call Api Groupes */
    const getcontents = () =>  {  selected_fil.value !== "Tous" ? getgroupes(selected_fil.value) : groupes.value = null,
    getetats(selected_fil.value,selected_period.value,period_debut.value,period_fin.value), activeHoure.value = 'TT',selected_gp.value=null}
    /* Return all our functuons and variables from { services/filieres.js } to use here */
    const { getFilieres , filieres , profs , getgroupes , groupes , stagiaires, getstagiaires , allEtats , nom_gp , getetats, etats } = useFilieres();
    /* On Mounted call Aoi Flieres */
    onMounted(getFilieres(),getetats(selected_fil.value,selected_period.value,period_debut.value,period_fin.value))
    
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
    .activeLink{
        border-color: rgb(8, 91, 255);
        transition: all .8s ease 0s;
    }
    *{
        box-sizing: border-box;
    }
</style>