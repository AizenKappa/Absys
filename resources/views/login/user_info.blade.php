<x-layout>
    <div class="h-screen overflow-hidden login-bg grid place-items-center">
        <div class="p-6 rounded-lg shadow-lg bg-white max-w-md">
            <div class="grid place-items-center my-2">
                <img src="{{ asset('img/logo_ofppt.png') }}" class="rounded-full w-24">
            </div>
            <h1 class="text-xl text-center mb-5">Verification</h1>
            <form method="POST" action="/check_user">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-contents.inpute type='text' value="{{old('firstname')}}" name='firstname' placeholder="First name"/>
                    <x-contents.inpute type='text' value="{{old('lastname')}}" name='lastname' placeholder="Last name"/>
                    <x-contents.inpute type='text' value="{{old('cin')}}" name='cin' placeholder="CIN" class="mb-5 col-span-2"/>
                </div>
                <x-contents.button type='submit'/>
                    @if ($errors->any())
                        <div class="w-full text-center bg-red-100 py-2 mt-3 rounded-md text-md text-red-500">
                            Les donnees sont incorecte         
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-layout>