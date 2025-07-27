@extends('layouts.layout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
            @include('components.darkmode')
            <h2 class="text-center mb-4">Registrar</h2>

            <div id="alert" class="alert alert-danger d-none" role="alert">
                A simple danger alert—check it out!
            </div>
            <form action="register" onsubmit="onSubmit(event)">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="name" class="form-control" id="name" name="name" placeholder="Digite seu nome" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Sobrenome</label>
                    <input type="last_name" class="form-control" id="last_name" name="last_name" placeholder="Digite seu sobrenome" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Digite sua senha" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Registrar</button>

                    <a href="javascript:void(0);" onclick="openSocialLogin('/login/google');" class="btn btn-light">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" style="width: 20px; margin-right: 10px;">
                        Login com Google
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/alert.js') }}"></script>
    <script src="{{ asset('js/social-login.js') }}"></script>

    <script>
        const onSubmit = async (e) => {
            e.preventDefault();

            let form = e.target;
            let formData = {
                name: form.name.value,
                last_name: form.last_name.value,
                email: form.email.value,
                password: form.password.value,
                password_confirmation: form.password_confirmation.value
            };

            const headers = {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            };

            try {
                const response = await request(form.action, form._method.value, formData, headers);
                const json = await response.json();

                if (response.status >= 300) {
                    throw new Error(json.message);
                }

                showAlert('alert', ALERT.SUCCESS, 'Usuário registrado com sucesso! Redirecionando para o login...');

                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 1500);
            } catch (error) {
                showAlert('alert', ALERT.DANGER, error.message);
            }
        };
    </script>
@endsection