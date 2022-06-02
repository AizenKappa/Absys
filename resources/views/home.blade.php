<x-layout>
    {{-- <h1>{{auth()->user()->firstname}}</h1>
    <a href="/logout">Logout</a> --}}
    <div class="h-full bg-[#059669] flex relative" x-data="{open:(window.innerWidth > 768) ? true : false,
        activeLink:1,
        activeClass:'text-green-600',
        inactiveClass:'text-gray-400'}" @resize.window="open = (window.innerWidth > 768) ? true : false">
        {{-- Start sidebar --}}
        <div x-show="open" class="absolute top-0 z-20  w-full bg-transparent p-1
            md:static md:w-[15rem]  md:p-0">
            <div class="bg-white rounded-md overflow-scroll shadow-lg h-auto md:rounded-none md:h-screen">
                <div class="pt-5 px-6 ">

                    <div class="flex justify-between pb-5 items-center border-b border-gray-300 mb-8
                    md:mb-0">
                        <a class="font-semibold text-xl text-[#475569]" href="/OFPPT">Kappa</a>
                        <button class="border py-2 px-1 rounded-sm text-bold text-[#475569] md:hidden"
                            @click="open=false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div class="pb-5 md:hidden md:p-0">
                        <input class="p-2 border border-gray-800/80  rounded-md w-full" type="text"
                            placeholder="Search">
                    </div>
                    <div class="border-t py-5 border-gray-300 grid gap-4">
                        <h1 class="font-bold text-xs text-[#64748B] uppercase" href="/OFPPT">admin layout pages</h1>
                        <div class="cursor-pointer">
                            <livewire:navlink :name="'dashboard'" :numLink="1" />
                            <livewire:navlink :name="'Login'" :numLink="2" />
                            <livewire:navlink :name="'Register'" :numLink="3" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Sidebar --}}

        <div class="border w-full">

            {{-- Start header --}}
            <header class="bg-white mb-12 md:bg-transparent">
                <nav class="drop-shadow-md py-5 px-6 flex justify-between items-center ">

                    <button class="border py-1 px-2 rounded-md md:hidden" @click="open = true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="gray">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <a class="font-semibold text-xl text-[#475569] " href="/OFPPT">Dashboard</a>
                    <div class="flex items-center">
                        <a class="float-right" href="/bell" class="pr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="gray">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                        </a>
                        <img class="rounded-full w-12" src="{{asset('img/pro.jpg')}}" alt="profile">
                    </div>
                </nav>
            </header>
            {{--End Header --}}

            {{-- Start content --}}
            <main class="w-full h-auto">
                    <div x-show="activeLink==1 ? true:false" class="bg-white w-full h-auto">
                        link 1{{-- here we will be putting the components --}}
                    </div>

                    <div x-show="activeLink==2 ? true:false" class="bg-white w-full">
                        link 2
                    </div>
                    <div x-show="activeLink==3 ? true:false" class="bg-white w-full">
                        link 3
                    </div>
            </main>
        {{--End Content  --}}


        </div>



    </div>
    {{-- end --}}




</x-layout>


{{--start noticard --}}
{{-- <div class="p-4 bg-white mt-5 w-4/5 mx-auto rounded-md">
    <div class="flex justify-between">

        <div>
            <p class="text-gray-500 text-xs font-bold  uppercase">traffic</p>
            <h1 class="text-xl font-semibold">350,897</h1>
        </div>
        <div class="bg-red-600 w-fit p-[11px] rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="white">
                <path
                    d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
            </svg>
        </div>

    </div>
    <div class="flex flex-row mt-4 items-center">
        <span class="text-green-500 font-normal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                    clip-rule="evenodd" />
            </svg><span class="text-[0.9rem]">3.68%</span>

        </span>
        <span class="text-gray-500 text-sm pl-1">Since last month</span>
    </div>

</div> --}}

{{-- end NotiCard --}}