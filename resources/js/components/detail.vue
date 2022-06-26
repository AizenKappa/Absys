<template>

    <div class="w-full lg:w-[45%] my-12">
        <select   class="w-full font-medium h-[2rem]" @change="chartfilter"  v-model="selectedFil" >
            <option    value="all" selected>Tous les Filieres</option>
            <option  :value="fil.id" v-for="fil in fillWithAbs" :key="fil.id">{{fil.nom_fil}}</option>
        </select>
    </div>
    <select  @change="chartSort" v-model="sort" >
        <option value="noSort" selected>Sort</option>
        <option value="total_h">Total</option>
        <option value="nj_h">Nj</option>
    </select>

    <template v-if="classDetails.exist == true">
            <template  v-for="el in classDetails.info" :key="el.groupe.nom_gp">
                <ClassChart v-if="el.show" :data="el" ></ClassChart>
            </template>
    </template>
   
    <template  v-else>
        <div class="bg-red-100 rounded-lg py-5 px-6 mb-4
         text-normal text-center text-red-700 mx-auto " role="alert">
            No Data found
        </div>
    </template>
    
</template>


<script setup>
    import {ref ,onMounted, onUpdated} from "vue";
    import ClassChart from "./ClassChart.vue";
     

    import axios from "axios";
    const selectedFil = ref("all")
    const classDetails = ref([])
    const fillWithAbs = ref([])
    const sort = ref("noSort")
   
    onMounted(()=>{
        getData()
        console.log(classDetails.value)
    })
    function help(){
        console.log(test.click())
    }
    
    
    async function getData(){
          
            
            let response = await  axios.get(`/api/details`)
            classDetails.value = response.data
            fillWithAbs.value = classDetails.value.fillWithAbs
            // console.log(classDetails.value)
            console.log(fillWithAbs.value)
    }
    function chartfilter(){
        console.log("hello")
        var fil_selected = selectedFil.value
        classDetails.value.info.forEach((ele)=>{
            var fil_id = ele.groupe.filiere.id 
            if(fil_selected == "all"){
                ele.show = true
            }
            else if(fil_id == fil_selected ){
                    ele.show = true
            }
            else{
                ele.show = false
            }
        })
    }

    function chartSort(){
        if(sort.value != "noSort"){
            classDetails.value.info.sort((a, b) => (a[sort.value] < b[sort.value]) ? 1 : -1)
        }
        
    }

    
    

</script>

<style scoped>
[v-cloak]{
    display: none;
}
</style>