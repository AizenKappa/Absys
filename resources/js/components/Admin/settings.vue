<template>
    
       
      



<div class="grid place-items-center mt-[2rem]">
    <form class="bg-white p-5 grid grid-cols-1 gap-4 place-items-center w-[40rem] rounded-sm shadow-md shadow-slate-300" 
        @submit.prevent="handleSubmit">

        <div class="uppercase font-bold ">Changer les fichiers excel</div>

        <div class="grid place-items-center gap-5 w-[33rem]">
            <div class="relative w-full">
                 <span class="font-semibold text-xs ml-2">Entrez la baseplate</span>
                <input id="custome_inpute" @change="handleBase" required class="form-control
                w-full text-lg font-normal text-gray-700 border border-solid border-gray-300 rounded
                focus:text-gray-700 focus:border-blue-600 focus:outline-none px-2 py-1.5" type="file">
                <span v-if="bwrong" class="absolute top-4 right-5 text-red-500">Wrong baseplate !!</span>
            </div>
            
            <div class="relative w-full">
                 <span class="font-semibold text-xs ml-2">Entrez l'avancement</span>
                <input id="custome_inpute" required  @change="handleAvant" class="form-control
                w-full text-lg font-normal text-gray-700 border border-solid border-gray-300 rounded
                focus:text-gray-700 focus:border-blue-600 focus:outline-none px-2 py-1.5" type="file">
                <span v-if="awrong" class="absolute top-4 right-5 text-red-500">Wrong avant !!</span>
            </div>
        </div>

        <button type="submit" class="bg-transparent hover:bg-blue-700  text-blue-700 font-semibold 
        hover:text-white w-[8rem] py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            Upload
        </button>
            
    </form>
    <div class="relative mt-10">
        <div class="checkPrent">
            <input type="checkbox" class="checkbox">
        </div>  
    </div>
    
</div>     
                    
    
    
</template>

<script setup>

    import { ref } from "vue";
    import axios from "axios";
    import { useToast } from "vue-toastification";
    const toast = useToast();

    const baseExcel = ref("");
    const avantExcel = ref("");
    const awrong = ref(false)
    const bwrong = ref(false)


    function handleBase(event){ baseExcel.value = event.target.files[0] }

    
    function handleAvant(event){ avantExcel.value = event.target.files[0] }
    

    function handleSubmit(){

       var resultBase = []
       var resultAvant = []

        let readerBase = new FileReader();
        readerBase.readAsText(baseExcel.value);
        readerBase.onload = function() {
        resultBase  = (readerBase.result).split(",")
            
            let readerAvant = new FileReader();
            readerAvant.readAsText(avantExcel.value);
            readerAvant.onload = function() {
                resultAvant  = (readerAvant.result).split(",")
                
                if(resultBase.includes('Stagiare en fomation')){
                    if(resultAvant.includes('Formateur Affecté Présentiel Actif')){
                        storeExcel()
                    }else{
                        error("Wrong avancement !!")
                    }
                }else{
                    error("Wrong baseplat !!")
                }
            };
        }
    }

    function storeExcel()
    {  
        let data = new FormData();
        data.append('base',baseExcel.value)
        data.append('avant',avantExcel.value)
        axios.post('/storeExcel',data)
        .then((response)=>{ 
            if(response.data.message == "success"){
               success("successeful")
            }
        })
        .catch((error) => { error("Something went wrong") })

    }
            
       
    

    const error = (message) => {

        toast.warning(message, {
            position: "bottom-right",
            timeout: 3000,
            closeOnClick: true,
            pauseOnFocusLoss: false,
            pauseOnHover: false,
            icon: true,
            hideProgressBar: false,
        });
    }
    const success = (message) => {

        toast.success(message, {
            position: "bottom-right",
            timeout: 3000,
            closeOnClick: true,
            pauseOnFocusLoss: false,
            pauseOnHover: false,
            icon: true,
            hideProgressBar: false,
        });
    }

</script>