<template>
<section>
<div class="flex flex-col lg:flex-row mt-2 gap-2 items-center justify-around lg:justify-center  md:grid-cols-2
  ">
    <div class=" p-4 w-[300px] h-[300px]  shadow-lg rounded bg-[#334155] mx-auto ">   
         <canvas class="relateive z-20" id="pie"></canvas>
    </div>

    <div class="h-[260px] max-w-[450px]  mx-auto  w-full md:w-full md:justify-self-end  md:h-[316px]
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
          <thead class="border-b border-2 ">

                <tr class="bg-[#26d0ce]">
                    <th colspan="7"><h1 class="text-black text-sm py-2 md:text-2xl font-bold
                    text-center w-full">Les Absences justifiées</h1>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-600">
                <tr class="border text-white">
                    <th scope="col" class="
                    text-md border border-black
                    font-medium  md:px-2 md:py-1 text-center">
                        Date
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
            <template v-if="just_abs.length > 0">
                <tr v-for="abs in just_abs" :key="abs.id" class="border-b bg-white">
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500">{{abs.date_abs}}</td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center">
                        {{abs.duration.h_debut.slice(0,5)}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center">
                        {{abs.duration.h_fin.slice(0,5)}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center">
                        {{abs.nbAbs}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 border border-gray-500
                     whitespace-nowrap text-center">
                    
                        {{abs.prof.nom_prof}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center">
                        {{abs.seance}}
                    </td>
                    <td class="text-sm text-gray-900
                    font-medium px-6 py-4 whitespace-nowrap
                    border border-gray-500 text-center">
                        {{abs.motif}}
                    </td>
                </tr>
            </template>
            
            <template v-else>
                <tr class="bg-white"  v-cloak>
                    <th colspan="7" class="text-lg text-gray-900
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
</section>

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
            <template v-if="boolean">
                <tr v-for="abs in nj_abs" :key="abs.id" class="border border-black">
                    <td class="md:px-2 md:py-1  whitespace-nowrap
                    text-sm font-medium text-gray-900 text-center border border-gray-500">{{abs.date_abs}}</td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap">
                        {{abs.duration.h_debut.slice(0,5)}}
                    </td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap">
                        {{abs.duration.h_fin.slice(0,5)}}
                    </td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap">
                        {{abs.nbAbs}}
                    </td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap">
                        {{abs.prof.nom_prof}}
                    </td>
                    <td class="text-sm text-gray-900 text-center border border-gray-500
                    font-medium md:px-2 md:py-1 whitespace-nowrap">
                        {{abs.seance}}
                    </td>
                </tr>
            </template>
            

            <template v-else>
                <tr class="bg-white"  v-cloak>
                    <th colspan="6" class="text-lg text-gray-900
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
               Absences totales
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

<div class="flex max-w-[800px] mx-auto h-20 items-center justify-between" v-cloak>
    <span></span>
    <button @click="loadStagPdf" target="_blank" class="bg-sky-400 ml-[50%] text-gray-900 font-semibold py-2 px-4
    rounded shadow hover:shadow-xl
    hover:bg-sky-500 duration-300">Imprimer
    <span v-if="loadingPrint">
        <svg role="status" class="inline w-4 h-4 mr-2 text-blue-900 animate-spin fill-blue-900 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
    </span>
</button>

</div>




</template>


<script setup>
    import {ref,computed,onMounted,reactive, onBeforeMount} from "vue";
    import axios from "axios";
    import Chart from 'chart.js/auto';
    import { useRouter, useRoute } from 'vue-router';
  

    const route = useRoute();
    const loadingPrint = ref(false)

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
    const boolean = ref(false)
    
    const absProf =  ref({})
    onMounted(async()=>
    {
       
        await axios.get(`/stagiaireAbs/${studentId.value}`).then((response) =>
        {
            // console.log(response.data)
            /* console.log(response.data) */
            studentInfo.value = response.data;
            stFullName.value = studentInfo.value.stFullName
            groupe_name.value= studentInfo.value.groupe_name
            st_total_abs.value = studentInfo.value.st_total_abs
            groupe_total_abs.value = studentInfo.value.class_total_abs

            monthly_abs_just.value =studentInfo.value.monthly_abs.just 
            monthly_abs_nj.value =studentInfo.value.monthly_abs.nj
            
            
            just_abs.value =studentInfo.value.just_abs 
            nj_abs.value =studentInfo.value.nj_abs

            boolean.value = Object.keys(nj_abs.value).length > 0

            
            
            absProf.value =studentInfo.value.absProf 
            // console.log(st_total_abs.value)
            // console.log(groupe_total_abs.value)

            /* console.log(JSON.parse(JSON.stringify(nj_abs.value)).length) */

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
                                    
                                    console.log(context);
                                    return context.label + " : " +context.formattedValue + " h";
                            }
                            }
                            
                        }
                        
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

    async function loadStagPdf(){
        loadingPrint.value = true
         await axios("/loadStagPdf",{
            method:"POST",
            responseType: 'blob',
            data:{
                id:studentId.value,
                info:studentInfo.value  
            }
            
        }).then((response)=>{
            const file = new Blob([response.data],{type:"application/pdf"})
            const fileURL = URL.createObjectURL(file);
            window.open(fileURL);
          
            console.log(response.data)
        })
        .catch((error)=>{
            console.log(error)
        })
        loadingPrint.value = false
    }
      
</script>

<style scoped>
    /* table > *{
        border:1px solid black
    } */
    [v-cloak] {
    display: none;
    }
</style>


