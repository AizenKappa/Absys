import { ref } from "vue"; 
import axios from "axios";

export default function useFilieres(){
    
    const filieres = ref([])
    const groupes = ref([])
    const stagiaires = ref([])
    const profs = ref([])
    const etats = ref([])

    var nom_gp = ref(null)

    const getFilieres = async () => {
        let response = await axios.get("/api/filieres")
        filieres.value = response.data.data
    };

    const getgroupes = async (filiere_id) =>{
        let response = await axios.get(`/api/filieres/${filiere_id}`)
        groupes.value = response.data.data
    };

    const getstagiaires = async (groupe_id) =>{
        let response = await axios.get(`/api/groupes/${groupe_id}`)
        stagiaires.value = response.data.data
        nom_gp.value = stagiaires.value[0].nom_gp
        getprofs(groupe_id)
        
    };

    const getprofs = async (groupe_id) =>{
        let response = await axios.get(`/api/profs/${groupe_id}`)
        profs.value = response.data.data

    };

    const getetats = async (id, period , limitD , limitF) =>{
        console.log(period,limitD,limitF)
        let response = await axios.get(`/api/etats/${id}/${period}/${limitD}/${limitF}`)
        // etats.value = response.data.data
        console.log(response.data.data)
    };
    

    return { filieres , groupes , stagiaires , getFilieres , profs , getgroupes , getstagiaires , nom_gp , getetats};

    
}