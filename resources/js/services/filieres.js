import { ref } from "vue"; 
import axios from "axios";
import { useToast } from "vue-toastification";
export default function useFilieres(){

    const toast = useToast();
    const filieres = ref([])
    const groupes = ref(null)
    const stagiaires = ref(null)
    const profs = ref([])
    const etats = ref([])
    const add_status = ref(false)
    const justif_status = ref(false)
    const user = ref()

    const nom_gp = ref(null)

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
        console.log(stagiaires.value)
        getprofs(groupe_id)
        
    };
    

    const getprofs = async (groupe_id) =>{
        let response = await axios.get(`/api/profs/${groupe_id}`)
        profs.value = response.data.data

    };

    const getuser = async () =>{
        let response = await axios.get(`/user`)
        user.value = response.data

    };

    const getetats = async (id, period , limitD , limitF) =>{
        let response = await axios.get(`/api/etats/${id}/${period}/${limitD}/${limitF}`)
        etats.value = response.data.data
        console.log(etats)
    };

    const addAbsence = (st_ids,prof_id,duration_id,seance,date_abs,reset,errorNet) => {
        // send a POST request
        console.log(duration_id)
        if(date_abs==""){
            Swal.fire("You Need To Choose A Correct Date ")
        }else{
            axios.post('/api/addAbsence', {
            stagiaire_ids:st_ids,
            prof_id: prof_id,
            duration_id:duration_id,
            seance:seance,
            date_abs:date_abs
            }).then((response) => {
            reset(response.data.message)
            }).catch((error) => { errorNet() });
    

        }
        
    }

    const addJustif = (abs_ids,motif,manualle_motif,reset) => {
        // send a POST request
        axios.post('/api/addJustif', {
            absences_ids:abs_ids,
            motif: motif,
            manualle_motif:manualle_motif,})
        .then((response) => {success("justification ajoutée avec succés"), reset()})
        .catch((error) => {  errorNet() });
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

    const errorNet = () => {
        toast.error("Error network" , {
            position: "bottom-right",
            timeout: 3000,
            closeOnClick: true,
            pauseOnFocusLoss: false,
            pauseOnHover: false,
            icon: true,
            hideProgressBar: false,
        });
    }
    

    return { filieres , groupes , stagiaires , getFilieres , profs , getgroupes , justif_status , addJustif,
            getstagiaires , nom_gp , getetats , addAbsence , user , getuser , add_status};

    
}