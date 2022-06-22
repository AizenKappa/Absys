<template>  
    <div class="w-[50%] border mx-auto">   
         <canvas id="my"></canvas>
    </div>
   
    <!-- <button @click="add">Add</button>
    <button @click="remove">Remove</button> -->
</template> 

<script setup>
    import {ref,onMounted} from "vue";
    import Chart from 'chart.js/auto';
    import axios from "axios";
    const props = defineProps(['chartData'])
    
    var type = "pie"
    /* Chart Object */
    var myChart = {}

    /* options  */
    var options = {
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
                formatter: function(value) { return value+"h"} 
            }
        }
    }
    

    /* Plugins  */
    var plugins = [

    ] 
    /* Data Object */
    var data = 
    {
                    labels: ["groupe","fname"],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [10, 2],
                        backgroundColor: ['rgb(255, 99, 132)','rgb(54, 162, 235)'],
                        hoverOffset: 4    
    }]};
    /* configuration object */
    var config = {
        type:type,
        data:data,//object
        options:options,//object
        plugins:plugins//array
    }
    onMounted(()=>{
        const ctx = document.getElementById('my');
        myChart = new Chart(ctx,config);

    })

    // function renderChart(){

    // }

    // function add(){
    //         dataChart.push(5)
    //         console.log(myChart.data.datasets[0].data = dataChart)
    //         myChart.update()
    // }
    // function remove(){
    //     dataChart.pop()
    //     myChart.data.datasets[0].data =dataChart 
    //     myChart.update()
    // }

    
</script>

<!--  var myPie = new Chart(pie, {
                type: 'pie',
                data: {
                    labels: [groupe,fname],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [otherStAbs, stAbs],
                        backgroundColor: ['rgb(255, 99, 132)','rgb(54, 162, 235)'],
                        hoverOffset: 4    
                }]},
                plugins: [ChartDataLabels],
                options: {
                    plugins: {
                        labels: {
                            render: 'percentage',
                            fontStyle: 'bolder',
                            position: 'bottom',
                        },
                        datalabels: {
                            fontStyle: 'bolder',
                            render: false,
                            formatter: function(value) { return ""} }}}})}
   } -->


    <!-- var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                    'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                    datasets: [{
                        label: 'Heures justifiées',
                        data: monthData[0],
                        backgroundColor: ['rgb(78, 216, 36, 0.3)'],
                        borderColor: [ 'rgb(78, 216, 36, 1)'],    
                        borderWidth: 1
                    },{ 
                        label: 'Heures Non justifiées',
                        data: monthData[1],
                        backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                        borderColor: ['rgba(255, 99, 132, 1)',],
                        borderWidth: 1}]
                    },         
                options: {
                    scales: {
                        y: {beginAtZero: true,
                            ticks: {callback: function(value, index, ticks) {return value + " h";}}
                    }},                                    
                    plugins: {
                        title: {
                            display: true,text: fname,
                            font: {size: 15}    
                        },
                        legend: {
                            labels: {
                                font: {size: 10}
                        }},
                        labels: {
                            render: function(args) {
                                if (args.value == 0) {return ""
                                }else {return args.value + ' H';}},      
                            fontStyle: "bolder",
                            showZero: true,},}}
            });  -->