






<template>
<section class="h-screen">
    <div class="grid place-content-center mt-10 w-full">

        <div class="bg-white xl:w-[45rem] lg:w-[38rem] md:w-[29rem] w-[85vw] sm:[23rem] px-5 py-10 rounded-lg shadow-md shadow-slate-300">

            <div class=" uppercase text-center mb-8  font-semibold text-lg">Ajouter un utilisateur</div>

            <form @submit.prevent>

                <div class="grid xl:grid-cols-2 xl:gap-6">
                    <div class="relative z-0 w-full mb-8 group">
                        <input @input="checkinpute" title="first" v-model="newUser.nom.text" type="text" name="floating_first_name" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                        <label for="floating_first_name" class="peer-focus:font-medium absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-1 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nom</label>
                        <span v-if="!newUser.nom.check" class=" text-red-600">{{ nomError }}</span>
                    </div>
                    <div class="relative z-0 w-full mb-8 group">
                        <input @input="checkinpute" title="last" v-model="newUser.prenom.text" type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                        <label for="floating_last_name" class="peer-focus:font-medium absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-1 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Prénom</label>
                        <span v-if="!newUser.prenom.check" class=" text-red-600">{{ prenomError }}</span>
                    </div>
                </div>

                <div class="relative z-0 w-full mb-8 group">
                    <input @input="checkinpute" title="email" v-model="newUser.email.text" type="text" name="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                    <label for="floating_email" class="peer-focus:font-medium absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-1 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">E-mail address</label>
                    <span v-if="!newUser.email.check" class=" text-red-600">{{ emailError }}</span>
                </div>

                <div class="relative z-0 w-full mb-8 group">
                    <input @input="checkinpute" title="cin" v-model="newUser.cin.text" type="text" name="cin" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                    <label for="cin" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-1 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">CIN</label>
                    <span v-if="!newUser.cin.check" class=" text-red-600">{{ cinError }}</span>
                </div>

                <div class="relative z-0 w-full mb-8 group">
                    <input @input="checkinpute" title="pwd" v-model="newUser.password.text" type="password" name="pwd" class="block py-2.5 px-0 w-full text-md text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                    <label for="pwd" class="peer-focus:font-medium absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-1 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mot de pass</label>
                    <span v-if="!newUser.password.check" class=" text-orange-400">{{ pwdError }}</span>
                </div>

                <div class="relative z-0 w-full mb-8 group">
                    <input @input="checkinpute" title="rpwd" v-model="newUser.rpassword.text" type="password" name="r-pwd" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                    <label for="r-pwd" class="peer-focus:font-medium absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-1 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Répéter le mot de pass</label>
                    <span v-if="!newUser.rpassword.check" class=" text-red-600">{{ rpwdError }}</span>
                </div>

            <button @click="checkform()" type="submit" class="text-white bg-blue-600 mt-2 w-[6rem] hover:bg-blue-700 active:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Créer</button>
            </form>

        </div>
</div>

</section>
</template>

<script setup>

    import { reactive, onMounted, ref } from "vue"

    import { useRouter } from "vue-router";
    
    import axios from "axios";

    const newUser = reactive({
        nom : { text:"", check:true, reg: /^[a-z\s]{3,}$/i },
        prenom : { text:"", check:true, reg: /^[a-z\s]{3,}$/i},
        email : { text:"", check:true, reg: /^[\w\.\-]{5,}@[\w\-]+\.[\w]+$/i },
        cin : { text:"", check:true, reg: /^[A-Z]{1,3}[0-9]{4,6}$/i },
        password : { text:"", check:true },
        rpassword : { text:"", check:true}
    })

    const router = useRouter()

    const nomError = ref("Nom invalide")
    const prenomError = ref("Prenom invalide")
    const emailError = ref("E-mail invalide")
    const cinError = ref("Cin invalide")
    const pwdError = ref("Mot de pass faible !!")
    const rpwdError = ref("Mots de passe ne correspondent pas")

    //checking on-inpute
    const start = ref(false)

    const send = ref(false)



    const checkform = () => {

        //si les champs vide
        for(let e in newUser){ if(newUser[e].text == ""){ return false } } 
        
        newUser.nom.check = newUser.nom.reg.test(newUser.nom.text)
        newUser.prenom.check = newUser.prenom.reg.test(newUser.prenom.text)
        newUser.email.check = newUser.email.reg.test(newUser.email.text)
        newUser.cin.check = newUser.cin.reg.test(newUser.cin.text)

        if( newUser.password.text.length <= 3 ){ newUser.password.check = false
        }else if(newUser.password.text != newUser.rpassword.text){ newUser.rpassword.check = false }

        start.value = true

        checkuser()
    }


    const checkinpute = (event) => {

        if(start.value){
            if(event.target.title == "first") newUser.nom.check = newUser.nom.reg.test(newUser.nom.text)

            else if(event.target.title == "last") newUser.prenom.check = newUser.prenom.reg.test(newUser.prenom.text)
            
            else if(event.target.title == "email") newUser.email.check = newUser.email.reg.test(newUser.email.text)
            
            else if(event.target.title == "cin") newUser.cin.check = newUser.cin.reg.test(newUser.cin.text)

            else if(event.target.title == "pwd") {
                newUser.password.text.length <= 4 ? newUser.password.check = false : newUser.password.check = true}

            else if(event.target.title == "rpwd"){
                newUser.password.text != newUser.rpassword.text ? 
                newUser.rpassword.check = false : newUser.rpassword.check = true
            }

        }
    }

    const checkuser = () => {

        for(let e in newUser){

            if(newUser[e].check == false){
                send.value = false
                break
            }
            else{  send.value = true }
        }

        if(send.value == true){

            addUser()

        }



    }

    const addUser = async () =>{
        let response = await axios.post(`/addNewUser`,{
            first:newUser.nom.text,last:newUser.prenom.text,
            cin:newUser.cin.text, email:newUser.email.text,
            pwd:newUser.password.text
        })
        console.log(response.data)

        router.push('/user')
    };


</script>
