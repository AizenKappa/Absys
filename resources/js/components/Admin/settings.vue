<template>
    <div >
       
      
    <form class="bg-white pt-5 grid grid-cols-1 gap-2 place-items-center  border border-black" @submit.prevent="handleSubmit">
    <label for="base" class="bg-blue-600 px-3 py-1 cursor-pointer
     rounded-md shadow-sm
      hover:opacity-80 w-[200px]"
      :class="baseExcel != '' ? 'bg-green-600':''">Importer la base plate </label>

        <input class="hidden" name="base" id="base" type="file" 
    accept=".xls,.xlsx,application/vnd.ms-excel,
    application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                     " @change="handleBase" 
                     required>
<label for="avant" class="bg-blue-600 px-3 py-1 cursor-pointer
 rounded-md shadow-sm  hover:opacity-80
   w-[200px]"
   :class="avantExcel != '' ? 'bg-green-600':''">Importer l'avancement</label>
                     <input class="hidden" name="avant" type="file" 
    accept=".xls,.xlsx,application/vnd.ms-excel,
    application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                     " @change="handleAvant" 
                     id="avant" required>

                            <!-- <label  for="inputFileUpload">Choose file</label> -->
             
    <button :disabled="btnControl"  type="submit" class="border shadow-sm border-black rounded-sm
     bg-green-400 p-1 hover:opacity-80" > Upload</button>
    </form>       
     
                    
    
    </div>
</template>

<script setup>

    import {ref,watch,onMounted} from "vue";
    import axios from "axios";
    const fileToSend = ref(null);
    const baseExcel = ref("");
    const avantExcel = ref("");
    const avantSize =ref(0)
    const baseSize =ref(0)
    const btnControl = ref(false)
    onMounted(()=>{
        btnControl.value = false
    })
    function handleBase(event){
        console.log(event)
        if(event.target.files.length === 0 ){
            baseExcel.value = "";
         
            return;
        }
       baseSize.value = event.target.files[0].size
       baseExcel.value = event.target.files[0];
       check()
    }
    function handleAvant(event){
        console.log(event)
        if(event.target.files.length === 0 ){
           avantExcel.value = "";
         
            return;
        }
       avantExcel.value = event.target.files[0];
       avantSize.value = event.target.files[0].size
      
       
       check()
    }


    function check(){
        if(avantExcel.value == "" || baseExcel.value == ""){
            btnControl.value = true
        }
        else if(avantExcel.value != "" && baseExcel.value != ""){
            btnControl.value = false
        }
    }

   
    

    function handleSubmit(){
        if(baseSize.value < avantSize.value){
            alert("la taille de la base plate est normalement superieur a la base de l'avancemnt")
        }
        else{
            let data = new FormData();
            data.append('base',baseExcel.value)
            data.append('avant',avantExcel.value)
            axios.post('/api/storeExcel',data)
                .then((response)=>{
                console.log(response.data)
                })
        }
        
       
    }

</script>