

<template>
    <section v-cloak>
        <!-- Profile-informations -->
        <div class="w-full grid grid-cols-1 place-items-center xl:flex justify-around gap-8 py-5">

            <div class="row-start-2 row-end-3 xl:my-10 mx-8 lg:w-[40rem] w-[95%] sm:w-[30rem] bg-gray-100 shadow-lg shadow-gray-300 rounded-md relative">
                <!-- header -->
                <div class="bg-white text-xl px-6 py-8 text-gray-700 font-bold w-full rounded-md">
                    My account
                </div>
                <div class="uppercase px-6 pt-6 text-base text-gray-400 font-bold">
                    user information
                </div>
                <!-- Inputes -->
                <div class="grid grid-cols-1 w-full lg:grid-cols-2 gap-5 pb-12 pt-8 px-10 place-items-start">
                    <label class="w-full">
                        <div class="mb-2 text-sm text-slate-600 font-bold">Nom</div>
                        <input
                        @click="clickbtn"
                        v-on:input="checkinpute"
                        :class="!user.first.check ?'inpute-error':''" title="first" v-model="user.first.text" class="shadow-md rounded-md py-6 px-3 outline-2 outline-cyan-500 shadow-gray-300 w-[100%] lg:w-[16rem] h-[2rem]" placeholder="Nom" type="text">
                        <span class="error_message" v-if="!user.first.check">Nom invalide</span>
                    </label>
                    <label class="w-full">
                        <div class="mb-2 text-sm text-slate-600 font-bold">Prenom</div>
                        <input
                        @click="clickbtn"
                        v-on:input="checkinpute"
                        :class="!user.last.check ?'inpute-error':''" title="last"  v-model="user.last.text" class="shadow-md rounded-md py-6 px-3 outline-2 outline-cyan-500 shadow-gray-300 w-[100%] lg:w-[16rem] h-[2rem]" placeholder="Prenom" type="text">
                        <span class="error_message" v-if="!user.last.check">Prenom invalide</span>
                    </label>
                    <label class="w-full">
                        <div class="mb-2 text-sm text-slate-600 font-bold">CIN</div>
                        <input
                        @click="clickbtn"
                        v-on:input="checkinpute"
                        :class="!user.cin.check ? 'inpute-error':''" title="cin"  v-model="user.cin.text" class="shadow-md rounded-md py-6 px-3 outline-2 outline-cyan-500 shadow-gray-300 w-[100%] lg:w-[16rem] h-[2rem]" placeholder="CIN" type="text">
                        <span class="error_message" v-if="!user.cin.check">{{ cinError }}</span>
                    </label>
                    <label class="w-full">
                        <div class="mb-2 text-sm text-slate-600 font-bold">EMAIL</div>
                        <input
                        @click="clickbtn"
                        v-on:input="checkinpute"
                        :class="!user.email.check ? 'inpute-error':''" title="email" v-model="user.email.text" class="shadow-md rounded-md py-6 px-3 outline-2 outline-cyan-500 shadow-gray-300 w-[100%] lg:w-[16rem] h-[2rem]" placeholder="mail@edu-ofppt.ma"  type="email">
                        <span class="error_message" v-if="!user.email.check">{{ emailError }}</span>
                    </label>
                </div>
                <!-- Password -->
                <div class="py-8 px-5 mb-10">
                    <label class="grid grid-cols-1">
                        <div class="mb-2 text-sm text-slate-600 font-bold">PASSWORD</div>
                        <span class="text-sm text-slate-400">// Entrez le mot de pass pour enregistrer les modifications</span>
                        <input v-model="user.pwd.text" type="password" title="pwd"
                        @click="clickbtn"
                        :class="!user.pwd.check ? 'inpute-error':''"
                        v-on:input="checkinpute"
                        class="shadow-md rounded-md py-6 px-3 outline-2 outline-cyan-500 shadow-gray-300 w-[17rem] h-[1.5rem]">
                        <span class="error_message" v-if="!user.pwd.check" >{{ pwdError}}</span>
                    </label>
                </div>
                <!-- Button -->
                <div class="absolute bottom-5 right-5">
                    <button
                    v-on:click="checkuser()"
                    class="bg-transparent active:bg-blue-500 text-blue-700 font-semibold active:text-white py-2 px-6 border border-blue-500 active:border-transparent rounded">
                        Save
                    </button>
                </div>

            </div>

            <div class="h-[20rem] w-[15rem] relative row-start-1 row-end-2">
                <div class="h-[5rem] w-full bg-transparent"></div>
                <div class="xl:h-[15rem] h-[10rem] w-full bg-gray-100 shadow-lg shadow-gray-300 rounded-md"></div>
                <div
                v-if="user.image.path"
                v-on:mouseover="show = true"
                v-on:mouseout="show = false"
                class="absolute top-0 left[50%] translate-x-[19%] w-[11rem] h-[11rem] rounded-full">
                    <div class=" w-full h-full rounded-full relative overflow-hidden">
                        
                        <img :src="user.image.path" 
                        @click="$refs.fileInpute.click()" 
                        class="w-full h-full rounded-full bg-black cursor-pointer">
                         

                        <div v-show="show" @click="$refs.fileInpute.click()" class="cursor-pointer absolute w-full h-full top-[70%] flex justify-center bg-slate-900 opacity-[0.7] z-10">
                            <div class="w-[2rem] cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M464 96h-88l-12.38-32.88C356.6 44.38 338.8 32 318.8 32h-125.5c-20 0-38 12.38-45 31.12L136 96H48C21.5 96 0 117.5 0 144v288C0 458.5 21.5 480 48 480h416c26.5 0 48-21.5 48-48v-288C512 117.5 490.5 96 464 96zM356.9 366.8C332.4 398.1 295.7 416 256 416c-31.78 0-61.37-11.94-84.58-32.61l-19.28 19.29C143.2 411.6 128 405.3 128 392.7V316.3c0-5.453 4.359-9.838 9.775-9.99h76.98c12.35 .3027 18.47 15.27 9.654 24.09l-19.27 19.28C219.3 361.4 237.1 368 256 368c24.8 0 47.78-11.22 63.08-30.78c8.172-10.44 23.25-12.28 33.69-4.125S365.1 356.3 356.9 366.8zM384 259.7c0 5.453-4.359 9.838-9.775 9.99h-76.98c-12.35-.3027-18.47-15.27-9.654-24.09l19.27-19.28C292.7 214.6 274.9 208 256 208c-24.8 0-47.78 11.22-63.08 30.78C184.8 249.2 169.7 251.1 159.2 242.9C148.8 234.8 146.9 219.7 155.1 209.2C179.6 177.9 216.3 160 256 160c31.78 0 61.37 11.94 84.58 32.61l19.28-19.29C368.8 164.4 384 170.7 384 183.3V259.7z"/></svg>
                            </div>
                        </div>
                        <input @change="inputeload" class="hidden" ref="fileInpute" type="file"/>



                    </div>
                        <div
                        @click="$refs.deletBtn.click()"
                        v-show="show" 
                        class=" hover:opacity-[1] opacity-[0.7] cursor-pointer w-8 h-8 border-2 border-black flex justify-center items-center rounded-full absolute z-30 top-[140px] right-[15px]">
                        <span><fas icon="trash-can" size="lg" /></span>
                        </div>
                        <button ref="deletBtn" class="hidden" @click="deletprofile()">Delet</button>
                   
                </div>
            </div>

        </div>
        
        
    </section>
</template>

    
    

<script setup>
    import { reactive , onBeforeMount, ref, onMounted, } from 'vue';
    import axios from "axios";

    const done = ref(false)
    const rex = ref({})
    const show = ref(false)
    const input = ref(null)



    const cinError = ref("Cin invalide")
    const emailError = ref("E-mail invalide")
    const pwdError = ref("Empty password")

    
    const user = reactive({
        id : { value : "", check:true },
        first : { text: "", check: true, reg: /^[a-z\s]{3,}$/i },
        last : { text: "", check: true, reg: /^[a-z\s]{3,}$/i },
        cin : { text: "", check: true, reg: /^[A-Z]{1,3}[0-9]{4,6}$/i },
        email : { text: "", check: true, reg: /^[\w\.\-]{5,}@[\w\-]+\.[\w]+$/i },
        pwd : { text: "", check:true},
        image: { path: "", check:true}
    })

 
    function inputeload(event) {
      
        const data = new FormData()
        data.append('image',event.target.files[0])

        getprofile(data)
        // let reader = new FileReader();
        // reader.readAsDataURL(event.target.files[0])
        // reader.onload = e => {
        //     input.value.src = e.target.result
        // }

        

    }
    


    const old_user = ref(null)

    const getuser = async () =>{
        let response = await axios.get(`/user`)
        user.id.value = response.data.user_id
        user.first.text = response.data.firstname
        user.last.text = response.data.lastname
        user.email.text = response.data.email
        user.cin.text = response.data.cin
        user.image.path = response.data.image



        old_user.value = response.data

    };
    
    onBeforeMount(() => { getuser() })

    const checkinpute = (event) => {

        if(event.target.title == "first") user.first.check = user.first.reg.test(user.first.text)

        else if(event.target.title == "last") user.last.check = user.last.reg.test(user.last.text)
           
        else if(event.target.title == "cin") user.cin.check = user.cin.reg.test(user.cin.text)
           
        else if(event.target.title == "email") user.email.check = user.email.reg.test(user.email.text)

        else if(event.target.title == "pwd") user.pwd.text == "" ? user.pwd.check = false : user.pwd.check = true

    }

    const checkuser = () => {

        for(let e in user){
            if(!user[e].check){
                done.value = false
                break
            }else done.value = true }
        if(user.pwd.text == ""){
            done.value = false
            user.pwd.check = false
        }
        if(done.value == true )
            sendData()
    }

    const sendData = async () => {
        console.log("ye^p")
        await axios.post('/api/updateUser', {
            id:user.id.value,
            firstname: user.first.text,
            lastname: user.last.text,
            cin: user.cin.text == old_user.value.cin ? null : user.cin.text,
            email: user.email.text == old_user.value.email ? null : user.email.text,
            password:user.pwd.text
        }).then((response) => { rex.value = response.data, console.log(rex.value) }).catch((error) => {console.log(error);});
        if(rex.value.champ == 'cin'){
            cinError.value = rex.value.message
            user.cin.check = false

        }else if(rex.value.champ == 'email'){
            emailError.value = rex.value.message
            user.email.check = false
        }else if(rex.value.champ == 'password'){
            pwdError.value = rex.value.message
            user.pwd.check = false
        }
    }

    const clickbtn = (event) => {
        if(event.target.title == "cin"){ cinError.value = "Cin invalide" } 
        else if(event.target.title == "email"){ emailError.value = "email invalide" }
        else if(event.target.title == "pwd"){  pwdError.value = "Empty password" }        
    }

    const updateimage = async () => {
        let response = await axios.get(`/user`)
        user.image.path = response.data.image
    }

    const getprofile = async (data) =>{
        let response = await axios.post(`/profile`,data)
        updateimage()
        console.log(response.data.status)
    };

    const deletprofile = async () => {
        let response = await axios.get(`/deletPicture`)
        updateimage()
        console.log(response.data.status)
    }

</script>


<style scoped>
    .inpute-error{
        outline: 2px solid red;
    }
    .error_message{
        color: red;
    }
    profile-div{
        background-image: url('https://source.unsplash.com/random/500x500/?face');
    }

</style>