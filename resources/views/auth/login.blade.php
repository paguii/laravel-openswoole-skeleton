@extends('layouts.layout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
            @include('components.darkmode')
            <h2 class="text-center mb-4">Login</h2>
            <div id="alert" class="alert alert-danger d-none" role="alert">
                A simple danger alert—check it out!
            </div>
            <form action="login" onsubmit="onSubmit(event)">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div></div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Lembrar login
                        </label>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                    <a href="javascript:void(0);" onclick="openSocialLogin('/login/google');" class="btn btn-light">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" style="width: 20px; margin-right: 10px;">
                        Login com Google
                    </a>
                </div>

                <div class="text-center mt-3">
                    <small><a href="login/forgot">Esqueceu sua senha?</a></small>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/social-login.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
    <script>
        const onSubmit = async (e) => {
            e.preventDefault();

            let form = e.target;
            let formData = {
                email: form.email.value,
                password: form.password.value,
                remember: form.remember.checked
            };

            if (!formData?.email || !formData?.password) {
                showAlert('alert', ALERT.DANGER, "Por favor, preencha todos os campos.");
                return;
            }

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

                showAlert('alert', ALERT.SUCCESS, 'Login efetuado com sucesso!');

                setTimeout(() => {
                    window.location.href = "{{ route('home') }}";
                }, 1500);
            } catch (error) {
                showAlert('alert', ALERT.DANGER, error.message);
            }
        };
    </script>
@endsection