<template>
<div class="flex flex-col  w-[90%] md:w-[500px] lg:w-[800px] lg:h-[400px]    bg-[#FFFFFF]
                shadow-lg rounded
             h-[300px]  mx-auto mb-5">
             <div class="flex flex-row justify-between p-2">
                <span >Absence Total :{{data.total_h}} h</span>
                <span>Absence NJ :{{data.nj_h}} h</span>
             </div>
             
             
            <div class="w-full h-full  mx-auto  ">   
                <canvas :id="data.groupe.nom_gp"></canvas>
            </div>
            
</div>
            
</template>


<script setup>
    import {ref,onMounted} from "vue";
    import Chart from 'chart.js/auto';
    const props = defineProps(['data'])
    var monthlyChart = {}

      onMounted(()=>{
       
       

            

            var monthlyOptions = {
                barThickness:10,
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
                            color:"black",
                            display: true,
                            text: props.data.groupe.nom_gp,
                            font: {
                                size: 15,
                                family:"cursive"
                                }    
                        },
                        ticks:{
                            color:"white"
                        },
                        
                        legend: 
                        {
                            position:"bottom",
                            align:"end",
                            labels: {
                                font: {
                                    size: 12,
                                    weight:"bold"
                                    },
                                color:"black",
                                align:"end",
                                position:"end",
                                usePointStyle:true,
                                pointStyle:"cirlce"
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
                                color:"gray",
                                font:{
                                    size:10,
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
                        data:   props.data.just_abs ,
                        backgroundColor: "#ed64a6",
                        borderColor: "#ed64a6",
                        fill: false,     
                        borderWidth: 1
                        },
                        { 
                        label: 'Heures Non justifiées',
                        data:props.data.nj_abs,
                        backgroundColor: "#4c51bf",
                        borderColor: "#4c51bf",
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
            const monthlyCtx = document.getElementById(props.data.groupe.nom_gp);
                    monthlyChart = new Chart(monthlyCtx,monthlyConfig)
      })
   
</script>