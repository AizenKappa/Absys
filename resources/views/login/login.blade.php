

<x-loginLayout>

<div class="h-screen overflow-hidden login-bg">
  <div class="grid justify-center">
    <div class="sm:w-[400px]">

      {{-- img --}}
      <div class="grid place-items-center my-10">
        <img src="{{ asset('img/logo_ofppt.png') }}" class="rounded-full w-24">
      </div>

      {{-- form --}}
      <div class="block p-6 rounded-lg shadow-lg bg-white w-full">
        <h1 class="text-2xl text-center mb-3">Connexion</h1>
          <form method="POST" action="/login" >
            @csrf
            {{-- usermane --}}
            <div class="form-group mb-6">
              <label for="username" class="form-label inline-block text-sm font-semibold mb-2 text-gray-700">Identifiant</label>
              <x-contents.inpute placeholder="Matricule / Email" type='text' name='cin_email' value="{{old('cin_email')}}"/>
            </div>
            
            {{-- password --}}
            <div class="form-group mb-6">



                <label for="Password" class="form-label text-sm font-semibold inline-block mb-2 text-gray-700">Mot de passe</label>
                <pass />
            </div>
                  

            
                
            

            {{-- token --}}
            <div class="flex justify-between items-center mb-6">
              <div class="form-group form-check">
                <input type="checkbox" name="check" id="Check">
                <label class="form-check-label inline-block text-gray-800" for="Check">Remember me</label>
              </div>
              <a href="/user_info"
                class="text-blue-600 hover:text-blue-800 focus:text-blue-700 transition duration-200 ease-in-out">Mot de passe oublié ?</a>
            </div>


            <x-contents.button type='submit'/>
          </form>
          <span>
            @if(session()->has('suspended'))
                <div class="w-full text-center bg-red-100 py-2 mt-3 rounded-md text-md text-red-500">
                  {{session('suspended')}}
                </div>
            @endif
          </span>

          <span>
            @if ($errors->any())
              @foreach ($errors->all() as $error)
                <div class="w-full text-center bg-red-100 py-2 mt-3 rounded-md text-md text-red-500">
                  {{$error}}            
                </div>
              @endforeach
            @endif
          </span>
      </div>

    </div>
  </div>
  

  <div class="flex justify-between text-sm font-semibold text-slate-800 mx-5 mt-[5rem]">
    <span >&copy;2022 ABSYS Réalisé par : <span class="font-bold">Hakim assim | Anass dabibe</span> 
    Encadré par Mr Najil Kamal</span>
    <span>Supervisé par Mr Rabii Najmeddine</span>
  </div>
    
</div>

</x-loginLayout>