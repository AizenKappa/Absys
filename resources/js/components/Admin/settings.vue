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
    <div v-show="shallWe" class="w-[40rem] rounded-sm bg-white mt-5 shadow-md shadow-slate-300 h-32 grid place-content-center">
        <div class="relative">
            <div
            :class="BoxSeconds == null ?'opacity-[1]':'opacity-[0.5]'"
            class="checkPrent">
                <input :disabled="true" @click="conterSpam"  ref="ramdanTime" type="checkbox" class="checkbox">
            </div>  
        </div>

        <span class="mt-10" v-if="spin">
                <svg role="status" class="w-6 h-6 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
        </span>

        <div  v-if="BoxSeconds != null ">
            <div class="mt-10 font-semibold text-teal-500">{{BoxHours}} : {{BoxMinutes}} : {{BoxSeconds}}</div>
        </div>
    </div>

    
    
</div>     
                    
    
    
</template>

<script setup>

    import { ref, onBeforeMount, watch } from "vue";
    import axios from "axios";
    import { useToast } from "vue-toastification";
    const toast = useToast();

    const baseExcel = ref("");
    const avantExcel = ref("");
    const awrong = ref(false)
    const spin = ref(false)
    const bwrong = ref(false)
    const loading = ref(false)
    const ramdanTime = ref(false)
    const time = ref(null)
    const checked = ref(false)
    const BoxHours = ref(null)
    const BoxMinutes = ref(null)
    const BoxSeconds = ref(null)
    const intervalID = ref(null)
    const wait = ref(false)
    const shallWe = ref(false)

    function handleBase(event){ baseExcel.value = event.target.files[0] }

    
    function handleAvant(event){ avantExcel.value = event.target.files[0] }
    
    onBeforeMount(()=>{
        chekckTime()
    })

    const updateTime = async () => 
    {
        axios.get('updateTime')

        .then((response)=>{
            if(response.data.type == "success"){
                chekckTime()
                success(response.data.message)
            }else if(response.data.type == "wrong"){
                error(response.data.message)
            }
        })
        .catch(()=>{
            rerror("Something went wrong try again !!")
        })
    }

    const conterSpam = () =>{
        ramdanTime.value.checked = checked.value
        if (wait.value) {
            return;
        }

        if(BoxSeconds.value != null){
            wait.value = true
            error("Vou devez attendre le temps ci-dessus")
        }else{
            sweetalert()
        }


        setTimeout(function() {
            wait.value = false;
        }, 5000);
    }


    const change = () => {
        updateTime()
    }

    const chekckTime = async () =>
    {
        let response = await axios.get('checkTime')

        if(response.data.active == "on"){
            ramdanTime.value.checked = true
            checked.value = true
        }else{
            ramdanTime.value.checked = false
            checked.value = false
        }
        shallWe.value = true

        if(response.data.ready == "no"){
            time.value = response.data.time
            spin.value = true
            intervalID.value = setInterval( showTime, 1000);
        }else{
            /* shallWe.value = true */
            ramdanTime.value.disabled = false
        }

                    
    }

    watch(() => time.value , () => {
        if(time.value < 0){
            stop()
            BoxSeconds.value = null
            wait.value = false
        }
    })


    const showTime = () => {
            let reverse = true
            var floathour = time.value/3600
            var hour = parseInt(floathour) 
            var floatmin = (floathour -  hour)*60
            var minute = parseInt(floatmin) 
            var floatSec = (floatmin - minute)*60
            var second = Math.ceil(floatSec)
            
            hour >= 10 ? hour = hour : hour = "0"+hour
            minute >= 10 ? minute = minute : minute = "0"+minute
            second >= 10 ? second = second : second = "0"+second

            BoxHours.value = hour
            BoxMinutes.value = minute
            BoxSeconds.value = second
            time.value -= 1
            if(reverse){
                spin.value = false
                /* shallWe.value = true */
                ramdanTime.value.disabled = false
                reverse = false
            } 
            
    } 

    function stop(){
        clearInterval(intervalID.value);
    }

    const sweetalert = () => {

        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Vou devrez attendre 24 heures pour le changer!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText:"Annuler",
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Valider!'
        }).then((result) => {
            if (result.isConfirmed) {
                change()
                wait.value  = true;
            }
        })
    }

    function handleSubmit(){

        loading.value = true
        storeExcel()
        
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
            console.log(response.data)
        })
        .catch((erro) => { 
             loading.value = false
            error(`Something went wrong${erro}`) 
            })

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
    const rerror = (message) => {

         toast.error(message, {
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