@extends('layouts.layout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
            @include('components.darkmode')
            <h2 class="text-center mb-4 mt-4">Recuperar Senha</h2>
            <div id="alert" class="alert alert-danger d-none" role="alert">
                A simple danger alert—check it out!
            </div>
            <p class="text-center mb-4">Digite seu e-mail para receber um link de recuperação de senha.</p>
            <form action="/login/forgot" onsubmit="onSubmit(event)">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/alert.js') }}"></script>
    <script>
        const onSubmit = async (e) => {
            e.preventDefault();

            let form = e.target;
            let formData = {
                email: form.email.value,
            }; 

            if (!formData?.email) {
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

                showAlert('alert', ALERT.SUCCESS, 'E-mail enviado com sucesso!');

                setTimeout(() => {
                    window.location.href = "{{ route('home') }}";
                }, 1500);
            } catch (error) {
                showAlert('alert', ALERT.DANGER, error.message);
            }
        };
    </script>
@endsection