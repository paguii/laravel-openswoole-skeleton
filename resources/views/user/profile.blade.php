@extends('layouts.layout')

@section('content')
    @include('components.navbar')

    <div class="container-fluid px-17 py-5">
        <h2 class="mb-4 border-bottom">Perfil</h2>
        <div id="alert" class="alert alert-danger d-none" role="alert">
            A simple danger alert—check it out!
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <form action="profile" onsubmit="onSubmitProfile(event)">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome:</label>
                        <input id="name" name="name" class="form-control" placeholder="Digite seu nome" type="text" value="{{ auth()->user()->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="form-label">Sobrenome:</label>
                        <input id="last_name" name="last_name" class="form-control" placeholder="Digite seu sobrenome" type="text" value="{{ auth()->user()->last_name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input id="email" class="form-control" placeholder="Digite seu e-mail" type="email" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <div class="text-end">
                        <button id="edit" class="btn btn-primary" onclick="toggleFields(true)" type="button">Editar</button>
                        <button id="save" class="btn btn-success d-none" type="submit">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="mb-4 text-center">Alterar senha</h2>
                <form action="profile/password" onsubmit="onSubmitPasswordChange(event)">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Senha Atual:</label>
                        <input id="current_password" class="form-control" placeholder="Digite sua senha atual" type="password">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha Nova:</label>
                        <input id="password" class="form-control" placeholder="Digite sua nova senha" type="password">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Senha Nova:</label>
                        <input id="password_confirmation" class="form-control" placeholder="Confirme sua nova senha" type="password">
                    </div>

                    <div class="text-end">
                        <button class="btn btn-success" type="submit">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/alert.js') }}"></script>
    <script>
        const toggleFields = (enable) => {
            const nameInput = document.getElementById('name');
            const lastnameInput = document.getElementById('last_name');
            const btnEdit = document.getElementById('edit');
            const btnSave = document.getElementById('save');

            if (enable) {
                nameInput.removeAttribute('disabled');
                lastnameInput.removeAttribute('disabled');
                btnEdit.classList.add('d-none');
                btnSave.classList.remove('d-none');
            } else {
                nameInput.setAttribute('disabled', true);
                lastnameInput.setAttribute('disabled', true);
                btnEdit.classList.remove('d-none');
                btnSave.classList.add('d-none');
            }
        };

        const cleanPasswordFields = (form) => {
            form.current_password.value = "";
            form.password.value = "";
            form.password_confirmation.value = "";
        };

        const onSubmitProfile = async (e) => {
            e.preventDefault();

            let form = e.target;
            let formData = {
                name: form.name.value,
                last_name: form.last_name.value
            };

            if (formData.name === "" || formData.last_name === "") {
                showAlert('alert', ALERT.DANGER, "Por favor, preencha todos os campos.");
                return;
            }

            try {

                const response = await fetch(form.action, {
                    method: form._method.value,
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(formData)
                });

                const json = await response.json();

                if (response.status >= 300) {
                    showAlert('alert', ALERT.DANGER, json.message);
                    return;
                }

                showAlert('alert', ALERT.SUCCESS, 'Alterações salvas com sucesso!', 3);

            } catch (error) {
                showAlert('alert', ALERT.DANGER, error.message);
                return;
            }

                   
            toggleFields(false);
        }

        const onSubmitPasswordChange = async (e) => {
            e.preventDefault();

            let form = e.target;
            let formData = {
                current_password: form.current_password.value,
                password: form.password.value,
                password_confirmation: form.password_confirmation.value
            };

            if (formData.current_password === "" || formData.password === "" || formData.password_confirmation === "") {
                showAlert('alert', ALERT.DANGER, "Por favor, preencha todos os campos.");
                return;
            }

            if (formData.password !== formData.password_confirmation) {
                showAlert('alert', ALERT.DANGER, "As senhas não coincidem.");
                return;
            }

            if (formData.password.length < 6) {
                showAlert('alert', ALERT.DANGER, "A nova senha deve ter pelo menos 6 caracteres.");
                return;
            }

            if (formData.current_password === formData.password) {
                showAlert('alert', ALERT.DANGER, "A nova senha não pode ser igual à senha atual.");
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
                    showAlert('alert', ALERT.DANGER, json.message);
                    return;
                }

                showAlert('alert', ALERT.SUCCESS, 'Senha alterada com sucesso!', 3);
                cleanPasswordFields(form);

            } catch (error) {
                showAlert('alert', ALERT.DANGER, error.message);
                return;
            }
        }
    </script>
@endsection