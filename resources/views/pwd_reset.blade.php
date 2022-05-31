<x-layout>
    <div class="h-screen overflow-hidden login-bg grid place-items-center">
        <div class="p-6 rounded-lg shadow-lg bg-white max-w-md lg:w-[400px]">
            <div class="grid place-items-center my-2">
                <img src="{{ asset('img/logo_ofppt.png') }}" class="rounded-full w-24">
            </div>
            <h1 class="text-xl text-center mb-5">Password Reset</h1>
            {{-- @if(session()->has("user_cin"))
                {{session(['user_cin' => session("user_cin")]);}}
            @endif --}}
            <form method="POST" action="/pwd_reset">
                @csrf
                
                <div  class="grid grid-cols-1 gap-4 mb-5">
                    
                    <x-inpute type='text' name='pwd' placeholder="new password" />
                    <x-inpute type='text' name='rpwd' placeholder="repete password" />
                </div>
                <x-button type='submit'/>
                    @if ($errors->any())
                        <div class="w-full text-center bg-red-100 py-2 mt-3 rounded-md text-md text-red-500">
                            Les donnees sont incorecte         
                        </div>
                    @endif
                </div>
                <input type="hidden" name='cin' value="{{session("user_cin")}}">
            </form>
        </div>
    </div>
</x-layout>