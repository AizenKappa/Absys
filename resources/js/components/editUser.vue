
<template>
<section class="h-scree">

    <div class="grid place-content-center mt-16">
        <div class="grid rounded-md shadow-md shadow-slate-300 max-w-max py-10 gap-10 bg-white px-10">
            
            <!-- Edit User -->
            <template v-if="editpage">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 ">
                    <div class="">
                        <div class="mb-2"><label class=" font-semibold px-2" for="nom">Nom</label></div>
                        <input
                        @input="checkinpute"
                        :class="user.nom.check?'outline-teal-500':'outline-red-500'"
                        v-model="user.nom.text" title="first" id="nom" class=" outline-2 focus:bg-white px-3 h-[2.8rem] rounded-md bg-slate-200 w-full lg:w-[15rem]" placeholder="Nom" type="text">
                        <div class="mt-1"><span v-if="!user.nom.check" class=" text-red-600 ml-2">{{nomError}}</span></div>
                    </div>
                    <div class="">
                        <div class="mb-2"><label class=" font-semibold px-2" for="prenom">Prenom</label></div>
                        <input
                        @input="checkinpute"
                        :class="user.prenom.check?'outline-teal-500':'outline-red-500'"
                        v-model="user.prenom.text" title="last" id="prenom" class=" outline-2 focus:bg-white px-3 h-[2.8rem] rounded-md bg-slate-200 w-full lg:w-[15rem]" placeholder="Prenom" type="text">
                        <div class="mt-1"><span v-if="!user.prenom.check" class=" text-red-600 ml-2">{{prenomError}}</span></div>
                    </div>
                    
                </div>
                <div class="grid grid-cols-1 gap-1">
                    <label class="mb-1 font-semibold px-2" for="email">E-mail adresse</label>
                    <input
                    @input="checkinpute"
                    :class="user.email.check?'outline-teal-500':'outline-red-500'"
                    v-model="user.email.text" title="email" id="email" class=" outline-2 focus:bg-white px-3 h-[2.8rem] rounded-md bg-slate-200 w-[32rem]" placeholder="mail@edu-ofppt.ma" type="text">
                    <span v-if="!user.email.check" class=" text-red-600 ml-2">{{emailError}}</span>
                </div>
                <div class="grid grid-cols-1 gap-1">
                    <label class="mb-1 font-semibold px-2" for="cin">Cin</label>
                    <input
                    @input="checkinpute"
                    :class="user.cin.check?'outline-teal-500':'outline-red-500'"
                    v-model="user.cin.text" title="cin" id="cin" class=" outline-2 focus:bg-white px-3 h-[2.8rem] rounded-md bg-slate-200 w-[32rem]" placeholder="Cin" type="text">
                    <span v-if="!user.cin.check" class=" text-red-600 ml-2">{{cinError}}</span>
                </div>

                <div class="flex justify-between">

                    <button @click="checkform()" type="submit" class="text-white bg-blue-600 mt-2 w-[8rem] hover:bg-blue-700 active:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Enregistrer</button>

                    <span v-on:click="editpage = false" class="text-blue-700 cursor-pointer hover:text-blue-800 active:text-sky-900">Changer le mot de pass ?</span>
                </div>

            </template>

            <!-- Update Password -->
            <template v-else>
                <div class="grid grid-cols-1 gap-1">
                    <label class="mb-1 font-semibold px-2" for="email">Mot de passe</label>
                    <input
                    @input="checkinpute"
                    :class="user.pwd.check?'outline-teal-500':'outline-red-500'"
                    v-model="user.pwd.text" title="pwd" id="email" class=" outline-2 focus:bg-white px-3 h-[2.8rem] rounded-md bg-slate-200 w-[32rem]" placeholder="Mot de passe" type="password">
                    <span v-if="!user.pwd.check" class=" text-orange-600 ml-2">{{ pwdError }}</span>
                </div>
                <div class="grid grid-cols-1 gap-1">
                    <label class="mb-1 font-semibold px-2" for="cin">Répète le mot de pass</label>
                    <input
                    @input="checkinpute"
                    :class="user.pwd.check?'outline-teal-500':'outline-red-500'"
                    v-model="user.rpwd.text" title="rpwd" id="cin" class=" outline-2 focus:bg-white px-3 h-[2.8rem] rounded-md bg-slate-200 w-[32rem]" placeholder="Repeter le mot de passs" type="password">
                    <span v-if="!user.rpwd.check" class=" text-red-600 ml-2">{{ rpwdError }}</span>
                </div>

                <button @click="checkPwdform()" type="submit" class="text-white bg-blue-600 mt-2 w-[8rem] hover:bg-blue-700 active:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Enregistrer</button>
            </template>

        </div>
    </div>


</section>
</template>

<script setup>

    import { reactive, onMounted, ref,  onBeforeMount, } from "vue"
    import { useRoute } from "vue-router";
    import axios from "axios";

    const editpage = ref(true)
    const route = useRoute()

    const user = reactive({
        id: { value:"", check:true },
        nom : { text:"", check:true, reg: /^[a-z\s]{3,}$/i },
        prenom : { text:"", check:true, reg: /^[a-z\s]{3,}$/i},
        email : { text:"", check:true, reg: /^[\w\.\-]{5,}@[\w\-]+\.[\w]+$/i },
        cin : { text:"", check:true, reg: /^[A-Z]{1,3}[0-9]{4,6}$/i },
        pwd : { text:"", check:true },
        rpwd : { text:"", check:true },
    })

    const send = ref(false)

    const nomError = ref("Nom invalide")
    const prenomError = ref("Prenom invalide")
    const emailError = ref("E-mail invalide")
    const cinError = ref("Cin invalide")
    const pwdError = ref("Mot de pass faible 5 caractères au minimum !!")
    const rpwdError = ref("Les mots de passe ne correspondent pas")

    const resetEmailError = ref(false)
    const resetCinError = ref(false)
    const startCheck = ref(false)
    const currentEmail = ref(null)
    const currentCin = ref(null)


    onBeforeMount(()=>{
        
        getThisUser(route.params.id)

        console.log(user)
    })

    const checkinpute = (event) => {


            if(event.target.title == "first") user.nom.check = user.nom.reg.test(user.nom.text)

            else if(event.target.title == "last") user.prenom.check = user.prenom.reg.test(user.prenom.text)
            
            else if(event.target.title == "email"){

                resetEmailError.value == true ? emailError.value = "E-mail invalide" : ''

                user.email.check = user.email.reg.test(user.email.text)

            } 
            
            else if(event.target.title == "cin"){

                resetCinError.value == true ? cinError.value = "Cin invalide" : ''

                user.cin.check = user.cin.reg.test(user.cin.text)

            }
            else if(event.target.title == "pwd"){

                if(startCheck.value == true){
                    user.pwd.check = user.pwd.text.length >= 4
                }
                

            }
            else if(event.target.title == "rpwd"){

                if(startCheck.value == true){
                    user.rpwd.check = user.pwd.text == user.rpwd.text
                }   

            }


    }

    const getThisUser = async (id) =>{

        let response = await axios.post(`/userById`,{ id : id })
        user.id.value = response.data.user_id
        user.nom.text = response.data.firstname
        user.prenom.text = response.data.lastname
        user.email.text = response.data.email
        user.cin.text = response.data.cin
 
        currentCin.value = response.data.cin
        currentEmail.value = response.data.email

    };


    const checkform = () => {

        for(let e in user){

            if(user[e].check == false){
                send.value = false
                break
            }
            else{  send.value = true }
        }

        if(send.value == true){

            editUser()
        }
    }


    const editUser = async () => {

        let response = await axios.post(`/editThisUser`,{

            id: user.id.value ,first:user.nom.text,last:user.prenom.text,
            cin: user.cin.text.toLowerCase() == currentCin.value.toLowerCase() ?  null : user.cin.text , 
            email: user.email.text.toLowerCase() == currentEmail.value.toLowerCase() ?  null : user.email.text ,
        })

        if(response.data.message !== "user edited successe" ){
            if(response.data.champ == "email"){

                user.email.check = false
                emailError.value = response.data.message
                resetEmailError.value = true
                
            }else if (response.data.champ == "cin"){

                user.cin.check = false
                cinError.value = response.data.message
                resetCinError.value = true
            }
        }else{
            console.log(response.data)
        }

    }

    const checkPwdform = () => {

        startCheck.value = true

        if(user.pwd.text.length >= 4){
            user.rpwd.check = user.pwd.text == user.rpwd.text
        }else{
            user.pwd.check = user.pwd.text.length >= 4
        }
       
        

        if(user.pwd.check == true && user.rpwd.check == true){
            updatePwd()
        }
    }

    const updatePwd = async () => {
        let response = await axios.post(`/updatePwdUser`,{ id: user.id.value , password : user.pwd.text })
        console.log(response.data)
    }

</script>