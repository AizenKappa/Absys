<template>
    <div class="w-[50%] border mx-auto">   
         <canvas id="pie"></canvas>
    </div>

    <div class="w-[90%] border mx-auto">   
         <canvas id="monthly"></canvas>
    </div>
    <!-- <div>
        <h1>Heure justifiées</h1>
        <table class="border border-black">
            <tr>
                <th>date abs</th>
                <th>h_debut</th>
                <th>h_fin</th>
                <th>Nb h</th>
                <th>prof</th>
                <th>seance</th>
                <th>motif</th>
            </tr>
            <template  v-if="nj_abs.length>0">
                 <tr v-for="abs in nj_abs" :key="abs.id">
                    <td>{{abs.date_abs}}</td>
                    <td>{{abs.h_debut}}</td>
                    <td>{{abs.h_fin}}</td>
                    <td>{{abs.nbAbs}}</td>
                    <td>{{abs.prof.nom_prof}}</td>
                    <td>{{abs.seance}}</td>
                    <td>{{abs.motif}}</td>
            </tr>
            </template>
           
            <template v-else>
                <tr>
                    <td colspan="7"> Aucune Absence justifiées</td> 
                </tr>
            </template>
           
                
        </table>

    </div>

    <div>
        <h1>Heure non justifiées</h1>
        <table class="border border-black">
            <tr>
                <th>date abs</th>
                <th>h_debut</th>
                <th>h_fin</th>
                <th>Nb h</th>
                <th>prof</th>
                <th>seance</th>
            </tr>
            <template  v-if="just_abs.length > 0">
                <tr v-for="abs in just_abs" :key="abs.id">
                    <td>{{abs.date_abs}}</td>
                    <td>{{abs.h_debut}}</td>
                    <td>{{abs.h_fin}}</td>
                    <td>{{abs.nbAbs}}</td>
                    <td>{{abs.prof.nom_prof}}</td>
                    <td>{{abs.seance}}</td>
                    
                </tr>
            </template>
            
            <template v-else>
                <tr>
                    <td colspan="6">Tous les absence sont justifées</td>  
                </tr>
                
            </template>
                
        </table>

    </div>

    <div>
        <h1>HEURE d'ABSENCE PAR PROF</h1>
        <table>
            <tr>
                <th>Nom PROF</th>
                <th>HOURs</th>
            </tr>
            <template v-if="absProf.length > 0"  v-for="(pr,index) in absProf" :key="index">
                <tr>
                    <th>{{pr.nom}}</th>
                    <th>{{pr.hours}}</th>
                </tr>
            </template>
            <template v-else>
                <tr>
                    <td colspan="2">Clean</td>
                </tr>
            </template>
        </table>
    </div> -->
<div class="flex flex-col">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="border-b border-2 border-black">

                <tr class="bg-[#21e88b]">
                    <th colspan="7"><h1 class="text-black text-center w-full">Les Absences justifiées</h1>
                    </th>
                </tr>
                <tr>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Date
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Debut
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Fin
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Durée
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Prof
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Type Seance
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Motif
              </th>
             
            </tr>
          </thead>
          <tbody>
            <template v-if="just_abs.length > 0">
                <tr v-for="abs in just_abs" :key="abs.id" class="border-b">
                    <td class="px-6 py-4 whitespace-nowrap
                    text-sm font-medium text-gray-900">{{abs.date_abs}}</td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.h_debut}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.h_fin}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.nbAbs}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.prof.nom_prof}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.seance}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.motif}}
                    </td>
                </tr>
            </template>
            
            <template v-else>

                <th colspan="6" class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        Aucune Absence justifiées
                </th>

            </template>
          </tbody>
        </table>
      </div>
    </div>
  </div>


</div>


<div class="flex flex-col">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="border-b border-2 border-black">

                <tr class="bg-[#f3158f]">
                    <th colspan="7"><h1 class="text-black text-center w-full">Les Absences Non justifiées</h1>
                    </th>
                </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Date
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Debut
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Fin
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Durée
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Prof
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Type Seance
              </th>
            </tr>
          </tbody>
          <tbody>
            <template v-if="nj_abs.length > 0">
                <tr v-for="abs in nj_abs" :key="abs.id" class="border-2 border-black">
                    <td class="px-6 py-4  whitespace-nowrap
                    text-sm font-medium text-gray-900">{{abs.date_abs}}</td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.h_debut}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.h_fin}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.nbAbs}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.prof.nom_prof}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        {{abs.seance}}
                    </td>
                </tr>
            </template>
            
            <template v-else>

                <th colspan="6" class="text-sm text-gray-900
                    font-light px-6 py-4 whitespace-nowrap">
                        Aucune Absence justifiées
                </th>

            </template>
          </tbody>
        </table>
      </div>
    </div>
  </div>


</div>
</template>


<script setup>
    import {ref,computed,onMounted,reactive, onBeforeMount} from "vue";
    import axios from "axios";
    import Chart from 'chart.js/auto';
    import { useRouter, useRoute } from 'vue-router';
  
   
    const router = useRouter();
    const route = useRoute();

    const  studentId= ref(route.params.id)
    
    /* Pie Chart Configuration */
    // onMounted(()=>{
    //         window.addEventListener("unload",function(event){
    //         alert("hello")
           
    //     })
    // })
    var pieChart = {}
    var monthlyChart = {}

    const studentInfo = ref({})
    const groupe_name = ref('');
    const stFullName = ref("");
    const st_total_abs = ref(0)
    const groupe_total_abs = ref(0)
  
    const monthly_abs_just = ref([]);
    const monthly_abs_nj = ref([]);
   
    const just_abs = ref([])
    const nj_abs = ref([])
    
    const absProf =  ref({})
    onMounted(async()=>{
       
        await axios.get(`/api/stagiaire/${studentId.value}`).then((response) =>
        {
            // console.log(response.data)
            studentInfo.value = response.data;
            stFullName.value = studentInfo.value.stFullName
            groupe_name.value= studentInfo.value.groupe_name
            st_total_abs.value = studentInfo.value.st_total_abs
            groupe_total_abs.value = studentInfo.value.class_total_abs

            monthly_abs_just.value =studentInfo.value.monthly_abs.just 
            monthly_abs_nj.value =studentInfo.value.monthly_abs.nj
            
            
            just_abs.value =studentInfo.value.just_abs 
            nj_abs.value =studentInfo.value.nj_abs
            
            absProf.value =studentInfo.value.absProf 
            // console.log(st_total_abs.value)
            // console.log(groupe_total_abs.value)
            var pieOptions =  
            {
                plugins: 
                    {
                        labels:
                        {
                            render: 'percentage',
                            fontStyle: 'bolder',
                            position: 'bottom',
                        },
                        datalabels: 
                        {
                            fontStyle: 'bolder',
                            render: true,
                            formatter: function(value) { return ""} 
                        }
                    }
            }
            var pieData =
            {
                    labels: [groupe_name.value,stFullName.value],
                    datasets: 
                    [{
                        label: 'My First Dataset',
                        data: [groupe_total_abs.value,st_total_abs.value],
                        backgroundColor: ['rgb(255, 99, 132)','rgb(54, 162, 235)'],
                        hoverOffset: 4    
                    }]
                }

            /* Configuration Object  */
            var pieConfig = {
            type:"pie",
            data:pieData,//object
            options:pieOptions,//object
       //array
        }
        /* Pie Context */
            const pieCtx = document.getElementById('pie');
                    pieChart = new Chart(pieCtx,pieConfig);
                    })


            

            var monthlyOptions = {
                    scales: 
                    {
                        y: 
                        {   beginAtZero: true,
                            ticks: {callback: function(value, index, ticks) {return value + " h";}}
                        }
                    },                                    
                    plugins: 
                    {
                        title: 
                        {
                            display: true,text: stFullName.value,
                            font: {size: 15}    
                        },
                        legend: 
                        {
                            labels: {
                                font: {size: 10}
                            }
                        },
                        labels: 
                        {
                            render: function(args) 
                            {
                                if (args.value == 0) {
                                    return ""
                                }else {
                                    return args.value + ' H';
                                }
                            },      
                            fontStyle: "bolder",
                            showZero: true,
                        },
                    }
                }
                
            var monthlyData = 
            {
                    labels: ['Septembre', 'Octobre', 'Novembre', 'Décembre',
                    'Janvier', 'Février', 'Mars', 'Avril', 
                    'Mai', 'Juin', 
                    'Juillet', 'Aout'],
                    datasets: 
                    [
                        {
                        label: 'Heures justifiées',
                        data:  monthly_abs_just.value ,
                        backgroundColor: ['rgb(78, 216, 36, 0.3)'],
                        borderColor: [ 'rgb(78, 216, 36, 1)'],    
                        borderWidth: 1
                        },
                        { 
                        label: 'Heures Non justifiées',
                        data: monthly_abs_nj.value,
                        backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                        borderColor: ['rgba(255, 99, 132, 1)',],
                        borderWidth: 1
                        }
                    ]
            }
            var monthlyConfig=
            {
                type:"bar",
                data: monthlyData,
                options: monthlyOptions
            }
            /* Pie Context */
            const monthlyCtx = document.getElementById('monthly');
                    monthlyChart = new Chart(monthlyCtx,monthlyConfig);
    })
      
</script>

<style scoped>
    table,thead,tr,td,tbody{
        border:1px solid black
    }
</style>