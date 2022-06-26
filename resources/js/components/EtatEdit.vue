<template>
    <div>Let's edit an Etat</div>
    <div class="w-full lg:w-[45%] my-12">
        <select   class="w-full font-medium h-[2rem]" @change="gpSelect"  v-model="selectedFil" >
            <option    value="all" selected>Tous les Filieres</option>
            <option  :value="index" v-for="(fil,index) in allFilWithGroupes" :key="fil.id">{{fil.nom_fil}}</option>
        </select>
    </div>
    <select  v-model="selectedGroupe"  @change="gpSelect">
    
        <template v-if="selectedFil != 'all'">
            <option value="none" class="hidden">Select A Groupe</option>
            <option :value="groupe.id" v-for="groupe in currentGroupe ">{{groupe.nom_gp}}</option>
        </template>
        <template v-else>
            <option value="none" class="hidden" selected>You need to choose a Class </option>
        </template>
        
    </select>
    <!-- {{allFilWithGroupes[selectedFil]}} -->
    <table >
        <tr>
            <th>nom</th>
            <th>prenom</th>
            <th>date_abs</th>
            <th>h_debut</th>
            <th>h_fin</th>
            <th>prof</th>
            <th>type seance</th>
            <th>etat_justif</th>
            <th>motif</th>  
            <th>Edit</th>
        </tr>
        <tr v-for="abs in allAbs ">
            <th>{{abs.stagiaire.nom_st}}</th>
            <th>{{abs.stagiaire.prenom_st}}</th>
            <th>{{abs.date_abs}}</th>
            <th>{{abs.h_debut}}</th>
            <th>{{abs.h_fin}}</th>
            <th>{{abs.prof.nom_prof}}</th>
            <th>{{abs.seance}}</th>
            <th>{{abs.etat_justif}}</th>
            <th>{{abs.motif}}</th>
            <th><Button ref="">Edit</Button></th>
        </tr>
    </table>
</template>



<script setup>
    import axios from 'axios';
    import {onMounted, ref} from "vue";
    const message = ref("Hello World")
    const selectedFil = ref("all")
    /*Start raw data */
    const allFilWithGroupes = ref([])
    const allGroupes = ref([])
    const data = ref([])
    const allAbs = ref([])
    /* End raw data */

    const selectedGroupe = ref("none")
    const currentGroupe = ref([])
    const fillWithAbs =ref([])
    onMounted(()=>{
        getData()
    })

    async function getData(){
        let response = await axios("/api/etatFil");
        data.value = response.data
        allFilWithGroupes.value = data.value.allFilWithGroupes
        fillWithAbs.value = data.value.fillWithAbs
        allGroupes.value = data.value.allGroupes
        allAbs.value = data.value.allAbs
        console.log(data.value)
        // gpSelect()
    }

    function gpSelect(){
        if(selectedFil.value !="all"){
            currentGroupe.value =  allFilWithGroupes.value[selectedFil.value].groupes
            selectedGroupe.value = "none"
        }else{
            currentGroupe.value = []
            selectedFil.value="all"
          
        }
        
        console.log(currentGroupe.value);
    }
</script>

<style scoped>

table  *{
    border:1px solid black;
}
</style>