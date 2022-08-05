<template>
<section >
<div class="flex flex-col lg:flex-row mt-2 gap-2 items-center justify-around lg:justify-center  md:grid-cols-2
  ">
    <div id="pieChart" class="print:hidden p-4 w-[300px] h-[300px]  shadow-lg rounded bg-[#334155] mx-auto ">   
         <canvas class="relateive z-20" id="pie"></canvas>
    </div>

    <div id="monthChart" class="print:hidden h-[260px] max-w-[450px]  mx-auto  w-full md:w-full md:justify-self-end  md:h-[316px]
    shadow-lg rounded bg-[#334155] " >   
         <canvas id="monthly"></canvas>
    </div>
</div>
    

    <!-- justifée -->
<div class="flex flex-col max-w-[800px]  mx-auto rounded-lg" v-cloak>
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
      <div class="overflow-x-auto">
        <table class="min-w-full rounded-sm">
          <thead class=" ">

                <tr class="bg-[#26d0ce] print:bg-white">
                    <th colspan="7"><h1 class="text-black text-sm py-2 md:text-2xl font-bold
                    text-center w-full">Les Absences justifiées</h1>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-600 print:bg-white print:text-black">
                <tr class="border text-white">
                    <th scope="col" class="
                    text-md border border-black
                    font-medium  md:px-2 md:py-1 text-center">
                        <span class="print:text-black"> Date</span>   
                    </th>
                    <th scope="col" class="text-md border border-black
                    font-medium  md:px-2 md:py-1 text-center ">
                        Debut
                    </th>
                    <th scope="col" class="text-md border border-black
                    font-medium  md:px-2 md:py-1 text-center ">
                        Fin
                    </th>
                    <th scope="col" class="text-md border border-black
                    font-medium  md:px-2 md:py-1 text-center">
                        Durée
                    </th>
                    <th scope="col" class="text-md border border-black
                    font-medium  md:px-2 md:py-1 text-center">
                        Prof
                    </th>
                    <th scope="col" class="text-md border border-black
                    font-medium  md:px-2 md:py-1 text-center">
                        Type Seance
                    </th>
                    <th scope="col" class="text-md border border-black
                    font-medium  md:px-2 md:py-1 text-center">
                        Motif
                    </th>
             
                </tr>
            </tbody>
                
          
          <tbody >
            <template v-if="(Object.keys(just_abs).length != 0)">
                <tr v-for="abs in just_abs" :key="abs.id" class="border-b bg-white">
                    <td class="border text-sm text-gray-900 print:text-black print:border-black
                    font-medium px-6 py-4 whitespace-nowrap
                     border-gray-500">{{abs.date_abs}}</td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center print:text-black print:border-black">
                        {{abs.duration.h_debut.slice(0,5)}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center print:text-black print:border-black">
                        {{abs.duration.h_fin.slice(0,5)}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center print:text-black print:border-black">
                        {{abs.nbAbs}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 border border-gray-500
                     whitespace-nowrap text-center print:text-black print:border-black">
                    
                        {{abs.prof.nom_prof}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center print:text-black print:border-black">
                        {{abs.seance}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center print:text-black print:border-black">
                        {{abs.motif}}
                    </td>
                </tr>
            </template>
            
            <template v-else>
                <tr class="bg-white border border-black"  v-cloak>
                    <th colspan="7" class="text-lg text-gray-900 print:text-black print:border-black
                    font-semibold px-6 py-4 whitespace-nowrap">
                        Aucune Absence justifiées
                    </th>
                </tr>
                

            </template>
          </tbody>
        </table>
      </div>
    </div>
  </div>


</div>


<!-- no justifée -->
<div class="flex flex-col max-w-[800px]  mx-auto" v-cloak>
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
          <thead class="border-b ">

                <tr class="bg-[#4c51bf]">
                    <th colspan="7">
                        <h1 class="text-black py-2 text-sm    md:text-2xl font-bold
                    text-center w-full">
                        Les Absences Non justifiées
                        </h1>
                    </th>
                </tr>
          </thead>
          <tbody class="bg-gray-600">
            <tr class="border text-white">
              <th scope="col" class="text-sm md:text-md border border-black
               font-medium  md:px-2 md:py-1 text-center">
                Date
              </th>
              <th scope="col" class="text-sm md:text-md border border-black
               font-medium  md:px-2 md:py-1 text-center">
                Debut
              </th>
              <th scope="col" class="text-sm md:text-md border border-black
               font-medium  md:px-2 md:py-1 text-center">
                Fin
              </th>
              <th scope="col" class="text-sm md:text-md border border-black
               font-medium  md:px-2 md:py-1 text-center">
                Durée
              </th>
              <th scope="col" class="text-sm md:text-md border border-black
               font-medium  md:px-2 md:py-1 text-center">
                Prof
              </th>
              <th scope="col" class="text-sm md:text-md border border-black
               font-medium  md:px-2 md:py-1 text-center">
                Type Seance
              </th>
            </tr>
          </tbody>
          <tbody>
            <template v-if="(Object.keys(nj_abs).length != 0)">
                <tr v-for="abs in nj_abs" :key="abs.id" class="border border-black">
                    <td class="md:px-2 md:py-1  whitespace-nowrap
                    text-sm font-medium text-gray-900 text-center border border-gray-500
                    print:text-black print:border-black">{{abs.date_abs}}</td>
                    
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap
                    print:text-black print:border-black">
                        {{abs.duration.h_debut.slice(0,5)}}
                    </td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap
                    print:text-black print:border-black">
                        {{abs.duration.h_fin.slice(0,5)}}
                    </td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap
                    print:text-black print:border-black">
                        {{abs.nbAbs}}
                    </td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap
                    print:text-black print:border-black">
                        {{abs.prof.nom_prof}}
                    </td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap
                    print:text-black print:border-black">
                        {{abs.seance}}
                    </td>
                </tr>
            </template>
            

            <template v-else>
                <tr class="bg-white"  v-cloak>
                    <th colspan="6" class="text-lg text-gray-900
                    print:text-black print:border-black
                    font-semibold px-6 py-4 whitespace-nowrap">
                        Aucune Absence justifiées
                    </th>
                </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>
  </div>



</div>

<!-- no justifée -->
<div class="flex flex-col max-w-[800px]  mx-auto" v-cloak>
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
          <thead class="border-b ">

                <tr class="bg-[#19d869]">
                    <th colspan="7">
                        <h1 class="text-black py-2 text-sm    md:text-2xl font-bold
                    text-center w-full">
                        Les Absences Par Prof
                        </h1>
                    </th>
                </tr>
          </thead>
          <tbody class="bg-gray-600">
            <tr class="border text-white">
              <th scope="col" class="text-sm md:text-md border border-black
               font-medium  md:px-2 md:py-1 text-center">
                Prof
              </th>
              <th scope="col" class="text-sm md:text-md border border-black
               font-medium  md:px-2 md:py-1 text-center">
               Heure total
              </th>
             
            </tr>
          </tbody>
          <tbody>
            <template v-if="(Object.keys(absProf).length != 0)">
                <tr v-for="abs in absProf" :key="abs.id" class="border border-black print:border-black">
                    <td class="md:px-2 md:py-1  whitespace-nowrap
                    text-sm font-medium text-gray-900
                     text-center border border-gray-500">{{abs.nom}}</td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500  print:border-black
                    print:text-black
                    font-medium md:px-2 md:py-1 whitespace-nowrap">
                    <span class="print:text-black">{{abs.hours}}</span>
                        
                    </td>
                    
                </tr>
            </template>
            

            <template v-else>
                <tr class="bg-white"  v-cloak>
                    <th colspan="6" class="text-lg text-gray-900
                    font-semibold px-6 py-4 whitespace-nowrap">
                        Aucune Absence 
                    </th>
                </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>
  </div>



</div>
<a :href="'/api/loadPdf?stag='+studentId" target="_blank" class="bg-yellow-200 ml-[50%] text-yellow-900 py-2 px-4
 rounded shadow hover:shadow-xl
  hover:bg-yellow-300 duration-300">Print the report</a>
</section>




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


    // function genPdf(){
    //     axios
    // }

   onBeforeMount(async()=>{
       
        await axios.get(`/api/stagiaire/${studentId.value}`).then((response) =>
        {
            
            studentInfo.value = response.data;
            stFullName.value = studentInfo.value.stFullName
            groupe_name.value= studentInfo.value.groupe_name
            st_total_abs.value = studentInfo.value.st_total_abs
            groupe_total_abs.value = studentInfo.value.class_total_abs

            monthly_abs_just.value =studentInfo.value.monthly_abs.just 
            monthly_abs_nj.value =studentInfo.value.monthly_abs.nj
            
            
            just_abs.value = studentInfo.value.just_abs
            nj_abs.value =studentInfo.value.nj_abs
            console.log(just_abs.value)
            absProf.value =studentInfo.value.absProf 
            // console.log(st_total_abs.value)
            // console.log(groupe_total_abs.value)
            var pieOptions =  
            {
                layout: {
                    padding: 5
                    },
                plugins: 
                    {
                        

                        datalabels: 
                        {
                            fontStyle: 'bolder',
                            color:"white",
                            render: true,
                          
                        },
                        legend: 
                        {
                            labels: {
                                font: {
                                    size: 12,
                                    weight:"bold"
                                    },
                                color:"white",
                                align:"end",
                                position:"end"
                            },
                        },
                    }
            }
            var pieData =
            {
                    labels: [groupe_name.value,stFullName.value],
                    datasets: 
                    [{
                      
                        data: [groupe_total_abs.value,st_total_abs.value],
                        backgroundColor: ['#4c51bf','#26d0ce'],
                        hoverOffset: 4    
                    }]
                }

            /* Configuration Object  */
            var pieConfig = {
            type:"doughnut",
            data:pieData,//object
            options:pieOptions,//object
       //array
        }
        /* Pie Context */
            const pieCtx = document.getElementById('pie');
                    pieChart = new Chart(pieCtx,pieConfig);
            })


            

            var monthlyOptions = {
                interaction: {
                intersect: false,
                mode: 'index',
                },
                    maintainAspectRatio:false,
                    responsive:true,
                    plugins: 
                    {
                        title: 
                        {
                            position:"top",
                            align:"top",
                            color:"white",
                            display: true,
                            text: stFullName.value,
                            font: {size: 15}    
                        },
                        ticks:{
                            color:"white"
                        },
                        
                        legend: 
                        {
                            labels: {
                                font: {
                                    size: 12,
                                    weight:"bold"
                                    },
                                color:"white",
                                align:"end",
                                position:"end"
                            },
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
                        tooltip:{
                            callbacks:{
                                label: function(context) {
                                    var label = context.dataset.label || '';
                                    return label + ": "+ context.parsed.y + " h";
                            }
                            }
                            
                        }
                    },
                    scales: {
                        y:{ 
                            ticks: {
                                callback: function(value, index, ticks) {return value + " h";},
                                color:"#AAB0B8",
                                font:{
                                    size:12,
                                    weight:"bolder"
                                }
                                },
                            grid:{
                                display: true,
                                borderDash: [3],
                                borderDashOffset: [3],
                                color:"gray"
                            }
                          
                        },
                        x:{
                            ticks: {
                                
                                color:"#AAB0B8",
                                font:{
                                    size:10,
                                    weight:"bolder"
                                }
                                },
                            grid:{
                                display: false,
                             
                            }
                        }
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
                        backgroundColor: "#4c51bf",
                        borderColor: "#4c51bf",    
                        tension:0.5,
                        borderWidth: 2,
                        fill:false
                        },
                        { 
                        label: 'Heures Non justifiées',
                        data: monthly_abs_nj.value,
                        backgroundColor:"#fff",
                        borderColor: "#fff",
                        tension:0.5,
                        borderWidth: 2
                        }
                    ]
            }
            var monthlyConfig=
            {
                type:"line",
                data: monthlyData,
                options: monthlyOptions
            }
            /* Pie Context */
            const monthlyCtx = document.getElementById('monthly');
                    monthlyChart = new Chart(monthlyCtx,monthlyConfig);
    })
      
</script>

<style scoped>
    /* table > *{
        border:1px solid black
    } */
    [v-cloak] {
    display: none;
    }

    @media print{
        *{
            color:black;
            background-color: white;
            overflow: hidden;
        }
    }
    
</style>


