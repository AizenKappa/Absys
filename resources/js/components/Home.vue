<template>

<div class="border border-red-600   ">
    <select v-model="stagPerPage" @change="changePage" >
        <option value="15" hidden>Stagiaires Par Page</option>
        <option value="20">20</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>

    <input  @keyup="stagBySearch" v-model="search" type="text" placeholder="Recherche Par Nom">
        <table  class="bg-white p-2 w-full">
            <tr class="border-b ">
                <th>
                    <div data-column="id"  @click="sortTable" class="
                    border cursor-pointer flex items-center justify-center gap-2 p-2" >
                        <div  class="text-gray-300 flex p-0">
                            <fas :class="(sort.type =='id' &&
                             sort.option =='asc')? 'text-black':''"  size="xs" icon="arrow-up" />
                            <fas :class="(sort.type =='id' &&
                             sort.option =='desc')? 'text-black':''" size="xs" icon="arrow-down" />
                        </div>
                    <span class="font-semibold">Id</span>
                    </div> 
                </th>

                <th>
                    <div data-column="nom_st" @click="sortTable" class="flex
                    border cursor-pointer  items-center justify-center gap-2 p-2" >
                        <div  class="text-gray-300 flex p-0">
                            <fas :class="(sort.type =='nom_st' &&
                             sort.option =='asc')? 'text-black':''"  size="xs" icon="arrow-up" />
                            <fas :class="(sort.type =='nom_st' &&
                             sort.option =='desc')? 'text-black':''" size="xs" icon="arrow-down" />
                        </div>
                    <span class="font-semibold">Nom</span>
                    </div> 
                </th>

                <th>
                    <div data-column="prenom_st"  @click="sortTable" class="
                    border cursor-pointer flex items-center justify-center gap-2 p-2" >
                        <div class=" flex p-0 text-gray-300">
                        <fas :class="(sort.type =='prenom_st' &&
                             sort.option =='asc')? 'text-black':''"  size="xs" icon="arrow-up" />
                            <fas :class="(sort.type =='prenom_st' &&
                             sort.option =='desc')? 'text-black':''" size="xs" icon="arrow-down" />
                    </div>
                    <span class="font-semibold">Prenom</span>
                    </div> 
                </th>

                <th>
                    <div  @click="sortTable"
                    data-column="groupe" class="border cursor-pointer flex items-center justify-center gap-2 p-2" >
                        <div class=" flex p-0  text-gray-300">
                            <fas :class="(sort.type =='groupe' &&
                             sort.option =='asc')? 'text-black':''"  size="xs" icon="arrow-up" />
                            <fas :class="(sort.type =='groupe' &&
                             sort.option =='desc')? 'text-black':''" size="xs" icon="arrow-down" />
                        </div>
                        <span class="font-semibold">Groupe</span>
                    </div> 
                </th>

                <th>
                    <div  @click="sortTable" 
                    data-column="heure_absence_st" class="border cursor-pointer flex items-center justify-center gap-2 p-2" >
                        <div class=" flex p-0 text-gray-300">
                        <fas :class="(sort.type =='heure_absence_st' &&
                             sort.option =='asc')? 'text-black':''"  size="xs" icon="arrow-up" />
                            <fas :class="(sort.type =='heure_absence_st' &&
                             sort.option =='desc')? 'text-black':''" size="xs" icon="arrow-down" />
                    </div>
                    <span class="font-semibold">Heure Absence</span>
                    </div> 
                </th>

                <th >
                    <div  @click="sortTable" 
                    data-column="numero_personnelle" class=" border cursor-pointer flex items-center justify-center gap-2 p-2" >
                        <div class="border flex p-0 text-gray-300">
                        <fas :class="(sort.type =='numero_personnelle' &&
                             sort.option =='asc')? 'text-black':''"  size="xs" icon="arrow-up" />
                            <fas :class="(sort.type =='numero_personnelle' &&
                             sort.option =='desc')? 'text-black':''" size="xs" icon="arrow-down" />
                    </div>
                    <span class="font-semibold">Tel N°</span>
                    </div> 
                </th>
            </tr>
            <tr class="p-4 cursor-pointer  border-b hover:bg-slate-500 transition-colors"  v-show="searchFailed">
                    <td colspan="6">
                       <p class="text-center text-red-600 text-lg font-bold"> No Result Found</p>
                        </td>
            </tr>
            <tr  v-show="!searchFailed" class="p-4 cursor-pointer  border-b hover:bg-slate-500 transition-colors"  
            v-for="st in stagIntoPages[currentPage]" :key="st.id">
                <td class="text-center border">{{st.id}}</td>
                <td class="text-center border">{{st.nom_st}}</td>
                <td class="text-center border">{{st.prenom_st}}</td>
                <td class="text-center border">{{st.groupe.nom_gp}}</td>
                <td class="text-center border">{{st.heure_absence_st}}</td>
                <td class="text-center p-2 border">{{st.numero_personnelle}}</td>
            </tr>
        </table>
<!-- pointer-events-none -->
<div v-show="!searchFailed" class="flex justify-center select-none bg-white ">
  <nav aria-label="Page navigation example">
    <ul class="flex list-style-none">
      <li class="page-item"><a
          :class="currentPage != 0 ?'text-gray-800 hover:text-gray-800 hover:bg-gray-200':''" 
          class="page-link text-sm py-1 px-2 relative block border-0 bg-transparent outline-none transition-all duration-300 rounded   focus:shadow-none"
          @click="previousPage"  >Previous</a></li>
      <li class="page-item"><a
          class="page-link text-sm py-1 px-2 relative block border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
          @click="previousPage" v-show="currentPage != 0">{{currentPage-1}}</a></li>
      <li class="page-item active"><a
          class="page-link text-sm py-1 px-2 relative block border-0 bg-blue-600 outline-none transition-all duration-300 rounded text-white hover:text-white hover:bg-blue-600 shadow-md focus:shadow-md"
          href="#">{{currentPage}}</a></li>
      <li class="page-item"><a
          class="page-link text-sm py-1 px-2 relative block border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
          @click="nextPage"  v-show="currentPage != lastPageNum ">{{currentPage + 1}}</a></li>
      <li class="page-item"><a
        :class="currentPage != lastPageNum ?'text-gray-800 hover:text-gray-800 hover:bg-gray-200':''"
          class="page-link  text-sm py-1 px-2 relative block border-0 bg-transparent outline-none transition-all duration-300 rounded  focus:shadow-none"
          @click="nextPage">Next</a></li>
    </ul>
  </nav>
</div>

</div>
</template>

<script setup>
    import { faSortAlphaAsc } from '@fortawesome/free-solid-svg-icons';
    import axios  from 'axios';
    import {ref ,reactive,watch, onMounted,computed} from "vue";
    const stagPerPage = ref(15);
    const stagiaires = ref([]);
    const currentPage=ref(0)
    const search = ref("")
    const lastPageNum = computed(()=>{
        return stagIntoPages.value.length - 1
    })
    watch(stagPerPage,()=>{
        console.log(stagPerPage.value)
        stagIntoPages.value= arrayChunk(stagiaires.value,Number(stagPerPage.value),search.value)
        currentPage.value = 0
    })
    const searchFailed = ref(false)
    const stagIntoPages =ref(0)
    const sort = reactive({
        type:"heure_absence_st",
        option:"desc"
    })

    function stagBySearch(){
        
        var searchResult = arrayChunk(stagiaires.value,Number(stagPerPage.value),search.value)
       
        if(searchResult[0].length !== 0){
                
                searchFailed.value = false
                stagIntoPages.value = searchResult
                console.log(searchResult)
        }   
        else{
             searchFailed.value = true
             
             console.log("this is bad")
        }
        currentPage.value = 0
    }

    function arrayChunk(arr,len,search){
        var upSearch = search.toUpperCase().split(" ").join("")
        var result = []
        var i = 0
        while(i < arr.length){
            var chunk = []
            var j = 0
                while(j < len && i < arr.length){
                    var nom = arr[i]['nom_st'].toUpperCase().split(" ").join("")
                    var prenom = arr[i]['prenom_st'].toUpperCase().split(" ").join("")
                    var x1 = nom+prenom
                    var x2 = prenom+nom 
                    if(search === "") {
                        chunk.push(arr[i])
                        j++;
                    }
                    else{
                        if(x1.includes(upSearch) || x2.includes(upSearch)){
                                chunk.push(arr[i])
                                    j++;
                        }  
                    }
                    i++;
                }

            result.push(chunk)
            
        }
        return result

    }

    const getSt = async () =>{
        let response = await axios.get("/api/stagiaires")
        stagiaires.value = response.data
        stagiaires.value.sort((a, b) => (a['heure_absence_st'] < b['heure_absence_st']) ? 1 : -1)
        stagIntoPages.value = arrayChunk(stagiaires.value,Number(stagPerPage.value),search.value)
        console.log(stagiaires.value)
    };


    onMounted(()=>{
        getSt();
       
    })
    
    function previousPage(){
        if( currentPage.value > 0){
            currentPage.value = currentPage.value - 1
        }   
    }
    function nextPage(){
        if( currentPage.value < stagIntoPages.value.length-1   ){
            currentPage.value = currentPage.value + 1
        }   
    }
    function sortTable(event){
        var parent = event.currentTarget
        var sortType =parent.dataset.column
        
         if(sort.type == sortType){
            
             if(sort.option == "asc"){
                sort.option = "desc"
            }else{
                 sort.option = "asc"
            }
         }else{
            sort.option="desc"
            
            sort.type = sortType
         }

         if(sort.option =="asc"){
            if(sortType == "groupe"){
                stagiaires.value.sort((a, b) => (a.groupe.nom_gp > b.groupe.nom_gp) ? 1 : -1)
            }else{
                stagiaires.value.sort((a, b) => (a[sortType] > b[sortType]) ? 1 : -1)
            }
            
         }
         else{
            if(sortType == "groupe"){
                stagiaires.value.sort((a, b) => (a.groupe.nom_gp < b.groupe.nom_gp) ? 1 : -1)
            }else{
                 stagiaires.value.sort((a, b) => (a[sortType] < b[sortType]) ? 1 : -1)
            }
            
         }
         currentPage.value = 0
        stagIntoPages.value = arrayChunk(stagiaires.value,Number(stagPerPage.value),search.value)
        console.log(sort.type)
        console.log(sort.option)
    }
</script>

<style scoped>
    
</style>