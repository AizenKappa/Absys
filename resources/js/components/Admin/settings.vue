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

        <!-- <button type="submit" class="bg-transparent  font-semibold 
          py-2 px-4  rounded">
            Upload
        </button> -->
        
        <button type="submit"
        class="rounded text-md px-5 py-2.5 mr-2 inline-flex items-center w-[8rem]"
        :class="loading? 
        'text-white bg-blue-700':
        'hover:bg-blue-600  text-blue-700 hover:text-white border border-blue-500 hover:border-transparent'"
        >
            <span v-if="loading">
                <svg role="status" class="inline w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
            </span>

            <span v-if="loading" class="text-center">Loading...</span>
            <div v-if="!loading"  class="text-center w-full">Upload</div>
            
        </button>
        
            
    </form>
    <div class="w-[40rem] rounded-sm bg-white mt-5 shadow-md shadow-slate-300 h-32 grid place-content-center">
        <div class="relative">
            <div class="checkPrent">
                <input type="checkbox" class="checkbox">
            </div>  
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
    const loading = ref(false)

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
                        loading.value = true
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
                loading.value = false
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