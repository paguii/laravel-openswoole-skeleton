@extends('layouts.layout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
            @include('components.darkmode')
            <h2 class="text-center mb-4 mt-4">Recuperação de conta</h2>
            <div id="alert" class="alert alert-danger d-none" role="alert">
                A simple danger alert—check it out!
            </div>
            <p class="text-center mb-4">Crie uma senha nova</p>
            <form action="/login/recovery" onsubmit="onSubmit(event)">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua nova senha" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Digite sua nova senha" required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/alert.js') }}"></script>
    <script>
        const onSubmit = async (e) => {
            e.preventDefault();

            const params = new URLSearchParams(window.location.search); 
            const token = params.get('token');

            let form = e.target;
            let formData = {
                token: token,
                password: form.password.value,
                password_confirmation: form.password_confirmation.value,
            };

            if (!formData?.password || !formData?.password_confirmation) {
                showAlert('alert', ALERT.DANGER, "Por favor, preencha todos os campos.");
                return;
            }

            const headers = {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            };

            try {
                const response = request(form.action, form._method.value, formData, headers);
                
                const json = await response.json();

                if (response.status >= 300) {
                    throw new Error(json.message);
                }

                showAlert('alert', ALERT.SUCCESS, 'Senha recuperada com sucesso!');

                setTimeout(() => {
                    window.location.href = "{{ route('loginView') }}";
                }, 1500);
            } catch (error) {
                showAlert('alert', ALERT.DANGER, error.message);
            }
        };
    </script>
@endsection