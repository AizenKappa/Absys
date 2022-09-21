<template>
<section>

    <div class="w-full lg:w-[45%] my-12 mx-2">
        <select v-model="type" class="w-full font-medium h-[2rem]">
            <option class="hidden" value="null" selected>Choisir le type d'impression</option>
            <option value="feuille_de_presence">Feuille de présence</option>
            <option value="pv_de_notes">Pv de notes</option>
            <option value="grille_de_notation">Grille de notation</option>
            <option value="enveloppe_cc_efm">Enveloppe CC et EFM</option>
        </select>
    </div>

    <div v-show="type =='feuille_de_presence' || type == 'pv_de_notes' || type == 'grille_de_notation'" class="w-full lg:w-[45%] my-12 mx-2">
            <select name="filiere" id="filieres_select" v-model="selected_fil" @change="changeFil"  class="w-full font-medium h-[2rem]" >
                <option class="hidden" :value="null">Choisir une filiere</option>
                <option  :value="fil.id" v-for="fil in filieres" :key="fil.id">{{fil.nom_fil}}</option>
            </select>
    </div>

    <div v-show="type =='enveloppe_cc_efm'" class="w-full lg:w-[45%] my-12 mx-2">
        <select v-model="selected_type"  class="w-full font-medium h-[2rem]" >
                <option value="par_formateur">Par Formateur</option>
                <option value="par_module">Par module</option>
        </select>   
    </div>

    <!-- formateut selection -->
    <div v-show="selected_type == 'par_formateur' && type == 'enveloppe_cc_efm'" class="w-full bg-white px-4 py-5">
        <div class="grid-cols-3 bg-slate-100 lg:scale-100 scale-75 rounded-lg grid sm:grid-cols-5 border-4 border-slate-100">
            <template v-for="pr in profs" :key="pr.id">
            <div class="grid items-center">
                <label :title="pr.id" :for="'pr_'+pr.id"   class="p-5 cursor-pointer select-none bg-slate-100 text-center border-b-4 border-transparent " 
                    >{{ pr.nom_prof }}</label>
                <input  type="checkbox" class="w-9 mx-auto" :id="'pr_'+pr.id" :value="pr.id" v-model="selected_profs">
            </div>
                    
            </template>
            
        </div>
    </div>
    <!-- Modules selection -->
    <div v-show="selected_type == 'par_module' && type == 'enveloppe_cc_efm'" class="w-full bg-white px-4 py-5">
        <div class="grid-cols-3 bg-slate-100 lg:scale-100 scale-75 rounded-lg grid sm:grid-cols-5 border-4 border-slate-100">
            <template v-for="md in modules" :key="md.id">

                    <div class="grid items-center">
                        <label :title="md.id" :for="'md_'+md.id"   class="p-5 cursor-pointer select-none bg-slate-100 text-center border-b-4 border-transparent " 
                    >{{ md.nom_module }}</label>
                    <input class="w-9 mx-auto" type="checkbox"  :id="'md_'+md.id" :value="md.id" v-model="selected_modules">
                    </div>
                    
            </template>
            
        </div>
    </div>

    <div v-show="selected_fil != null && (type == 'feuille_de_presence' || type == 'pv_de_notes' || type == 'grille_de_notation')" class="w-full bg-white px-4 py-5">
        <div class="grid-cols-3 bg-slate-100 lg:scale-100 scale-75 rounded-lg grid sm:grid-cols-5 border-4 border-slate-100">
            <template v-for="gp in currentGroupes" :key="gp.id">
                    <label :title="gp.id" :for="'gp_'+gp.id"   class="p-5 cursor-pointer bg-slate-100 text-center border-b-4 border-transparent " 
                    @click="add_remove_gp($event,gp.id)">{{ gp.nom_gp }}</label>
                    <input type="checkbox" class="hidden"  :id="'gp_'+gp.id" :value="gp.id" v-model="selected_groupes">
            </template>
            
        </div>
    </div>

    <div v-show="selected_fil != null && (type == 'feuille_de_presence' || type == 'pv_de_notes' || type == 'grille_de_notation')" class="w-full  grid place-items-center">
        <button @click="loadPresencePdf" :disabled="(selected_groupes.length == 0 || type == null)" class="bg-sky-600 m-2 text-white cursor-pointer p-2 rounded-sm"
        :class="(selected_groupes.length == 0 || type == null)? 'opacity-50':'opacity-100'">Imprimer 
    <span v-if="loadingPrint"  class="ml-2">
        <svg role="status" class="inline w-4 h-4 mr-2 text-blue-900 animate-spin fill-blue-900 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
    </span>
</button>
    </div>
    
    <div v-show="type == 'enveloppe_cc_efm' && selected_type == 'par_formateur'" class="w-full  grid place-items-center">
        <button @click="envParProf" :disabled="(selected_profs.length == 0 && selected_type == 'par_formateur')" class="bg-sky-600 m-2 text-white cursor-pointer p-2 rounded-sm"
        :class="(selected_profs.length == 0 && selected_type == 'par_formateur')? 'opacity-50':'opacity-100'">Imprimer 
    <span v-if="loadingPrint"  class="ml-2">
        <svg role="status" class="inline w-4 h-4 mr-2 text-blue-900 animate-spin fill-blue-900 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
    </span>
</button>
    </div>
    
    <div v-show="type == 'enveloppe_cc_efm' && selected_type == 'par_module'" class="w-full  grid place-items-center">
        <button @click="envParModule" :disabled="(selected_modules.length == 0 && selected_type == 'par_module')" class="bg-sky-600 m-2 text-white cursor-pointer p-2 rounded-sm"
        :class="(selected_modules.length == 0 && selected_type == 'par_module')? 'opacity-50':'opacity-100'">Imprimer 
    <span v-if="loadingPrint"  class="ml-2">
        <svg role="status" class="inline w-4 h-4 mr-2 text-blue-900 animate-spin fill-blue-900 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
    </span>
</button>
        
    </div>

   
   
</section>
</template>



<script setup>
    import {ref,onMounted} from "vue";
    import axios from "axios";
   
    const selected_groupes = ref([])
    const currentGroupes = ref([]);
    const type = ref("null")
    const selected_fil = ref(null)
     const selected_type = ref('par_formateur')
    const selected_profs = ref([])
    const selected_modules = ref([])
    const modules = ref([])
    const filieres = ref([])

    const loadingPrint = ref(false)
    
    const profs = ref([]);
    const allProfs = async () =>{
        let response = await axios.get(`/getProfs`)
        profs.value = response.data

    };
    const allModules = async () =>{
        let response = await axios.get(`/getModules`)
        modules.value = response.data
        console.log(modules.value)
    };
    onMounted(()=>{
        allModules()
        allProfs()
        getFilieres()
    })
    function add_remove_gp(event,groupe_id){
        if(selected_groupes.value.includes(groupe_id)){
            event.target.classList.remove("activeLink")
        }
        else{
            event.target.classList.add("activeLink")
        }
    }
    function add_remove_pr(event,prof_id){
        if(selected_profs.value.includes(prof_id)){
            event.target.classList.remove("activeLink")
        }
        else{
            event.target.classList.add("activeLink")
        }
    }

    function add_remove_md(event,module_id){
        if(selected_modules.value.includes(module_id)){
            event.target.classList.remove("activeLink")
        }
        else{
            event.target.classList.add("activeLink")
        }
    }
    async function loadPresencePdf(){
        loadingPrint.value = true
        await axios("/loadPresencePdf",{
            method:"POST",
            responseType: 'blob',
            data:{
                // anneeScolaire:anneeScolaire.value,
                // dr:dr.value,
                // complexe:complexe.value,
                // institut:institut.value,
                type:type.value,
                groupes:selected_groupes.value
            }
            
        }).then((response)=>{
            const file = new Blob([response.data],{type:"application/pdf"})
            const fileURL = URL.createObjectURL(file);
            window.open(fileURL);
            // console.log(response.data)
        })
        loadingPrint.value = false
    }

    async function envParModule(){
        loadingPrint.value = true
            await axios("/envParModule",{
            method:"POST",
            responseType: 'blob',
            data:{
                // anneeScolaire:anneeScolaire.value,
                // dr:dr.value,
                // complexe:complexe.value,
                // institut:institut.value,
                
                modules:selected_modules.value
            }
            
        }).then((response)=>{
            const file = new Blob([response.data],{type:"application/pdf"})
            const fileURL = URL.createObjectURL(file);
            window.open(fileURL);
            console.log(response.data)
        })
        loadingPrint.value = false
    }
    async function envParProf(){
            loadingPrint.value = true
            await axios("/envParProf",{
            method:"POST",
            responseType: 'blob',
            data:{
                // anneeScolaire:anneeScolaire.value,
                // dr:dr.value,
                // complexe:complexe.value,
                // institut:institut.value,
                
                profs:selected_profs.value
            }
            
        }).then((response)=>{
            const file = new Blob([response.data],{type:"application/pdf"})
            const fileURL = URL.createObjectURL(file);
            window.open(fileURL);
            // console.log(response.data)
        })
        loadingPrint.value = false
    }
    const getFilieres = async () => {
        let response = await axios.get("/filieres")
        filieres.value = response.data.data
    };

    const getgroupes = async (filiere_id) =>{
        let response = await axios.get(`/filieres/${filiere_id}`)
        currentGroupes.value = response.data.data
    };

    async function changeFil(){
        selected_groupes.value = [];
        if(selected_fil.value != null){
            await getgroupes(Number(selected_fil.value))
            
        }
    }

</script>

<style scoped>
    .activeLink{
        border-color: rgb(8, 91, 255);
        transition: all .8s ease 0s;
    }
</style>