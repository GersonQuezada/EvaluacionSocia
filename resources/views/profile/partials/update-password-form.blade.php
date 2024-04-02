
@section('content')

<div class="card">
<div class="card-body">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Cambiar Contraseña
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura.
    </p>
    <form method="post" action="{{ route('password.update') }}" class="">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña Actual : ')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nueva Contraseña : ')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña : ')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>
        <p>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>


        </div>
    </form>
</div>

</div>



    @stop

@section('js')

    @if (session('status') === 'password-updated')
        <script>
            Swal.fire({
                title: "Contraseña Modificada",
                text: "Se ha grabado los cambios.",
                icon: "success"
                });
        </script>
    @endif


    @endsection
