<x-layout>
<section class="h-auto relative"  @resize.window="show = (window.innerWidth < 768) ? false : true" x-data="{show : (window.innerWidth < 768) ? false : true}">
<div id="helper">
        {{-- Dashboard-header --}}
    <div x-show = "show" class="md:h-screen md:w-[16rem] w-[96%] md:mx-0 mt-3 md:mt-0 bg-white md:overflow-y-scroll md:fixed absolute z-20">
        <div id="dashboard-header" class="flex justify-between mt-8 mb-10 mx-6">
            <h1 class=" text-sm uppercase font-bold">Hello User</h1>
            <x-contents.svg :name="'close'"/>
    </div>
        {{-- Caeds --}}
        <x-contents.card/>

    </div>
</div>
<div x-data="{open:false}" id="home" class="md:pl-[16rem] bg-blue-50 h-full">
    {{-- -->home page --}}
    <div class="relative h-full">
        <div class="md:h-[20rem] h-[30rem] bg-[#059669]"></div>
        <div id="contents" class="absolute top-0 w-full h-full z-10">
            {{-- Navbar ---> --}}
            <div class="w-full h-20 md:px-14 md:pt-4 bg-blue-50 md:bg-[#059669] flex justify-between px-6 pt-5 ">
                <span class="hidden md:block mt-3 font-bold text-white uppercase text-sm">Dashboard</span>
                   <x-contents.svg :name="'menu'"/>
                <div @click="open=!open" class="bg-red-700 rounded-full h-10 w-10 cursor-pointer" ></div>
            </div>
            <div id="testets" class="w-full h-auto">
                {{-- contents --}}
                <livewire:fildrop  />
                <livewire:groupe-drop  />
            </div>
        </div>
    </div>
    {{-- Profile --}}
    <div x-show="open" class=" w-44 h-28 bg-white rounded z-30 absolute top-16 md:right-20 right-10">
        <ul>
            <li class="px-4 py-3">View profile</li>
            <li><hr></li>
            <li class="px-4 p-3"><a href="/logout">Logout</a></li>
        </ul>
    </div>
</div>
</section>

<script>
    var items = document.querySelectorAll("#dashboard-cards li")
    var demo = document.querySelector("#testets")
        items.forEach(e =>{e.addEventListener("click",function(){
            items.forEach(li =>{li.style.color = "gray";li.children[1].style.color = "black"})
            e.style.color = "#059669"; e.children[1].style.color = "#059669"
            
            /* First one */



           /*  if(e.dataset.link == "dashboard"){
                demo.innerHTML = `this is the dashboard`;
            }
            else if(e.dataset.link == "ajt"){
                demo.innerHTML = `<livewire:fildrop  />`;
            }
            else if(e.dataset.link =="justif"){
                demo.innerHTML = `Justifier l'absence`;
            } */
            
                


                
    })});onload = () => document.querySelector("#test").click()
    
    
</script>
</x-layout>