<template>  
    <div class="w-[50%] border mx-auto">   
         <canvas id="pie"></canvas>
    </div>

    <div class="w-[90%] border mx-auto">   
         <canvas id="monthly"></canvas>
    </div>
  
    <!-- <button @click="add">Add</button>
    <button @click="remove">Remove</button> -->

</template> 

<script setup>
    import {ref,onMounted} from "vue";
    import Chart from 'chart.js/auto';
    import axios from "axios";
    const props = defineProps(['studentId']);

    
    /* Chart Object */
    var pieChart = {}
    var monthlyChart = {}

    const studentInfo = ref({})
    const groupe_name = ref('');
    const stFullName = ref("");
    const st_total_abs = ref(0)
    const groupe_total_abs = ref(0)
  
    const monthly_abs_just = ref([]);
    const monthly_abs_nj = ref([]);
   
        
    
    onMounted(async()=>{
       
        await axios.get(`/api/stagiaire/${props.studentId}`).then((response) =>
        {
            // console.log(response.data)
            studentInfo.value = response.data;
            stFullName.value = studentInfo.value.stFullName
            groupe_name.value= studentInfo.value.groupe_name
            st_total_abs.value = studentInfo.value.st_total_abs
            groupe_total_abs.value = studentInfo.value.class_total_abs

            monthly_abs_just.value =studentInfo.value.monthly_abs.just 
            monthly_abs_nj.value =studentInfo.value.monthly_abs.nj 
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

