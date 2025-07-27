@extends('layouts.layout')

@section('content')
    @include('components.navbar')

    <div class="container-fluid px-17 py-5" id="start">
        <div class="row align-items-center justify-content-center flex-lg-row-reverse">
            <div class="col-lg-5 text-center">
                <img src="{{ asset('assets/img/logo_2.png') }}" class="img-fluid w-75 toggle-image-dark m-5" alt="Preview"
                    loading="lazy">
            </div>
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold mb-3">Boas-vindas ao Skeleton Laravel Octane</h1>
                <p class="lead">Este projeto base está pronto para performance com Laravel Octane e Swoole. Ideal para
                    acelerar desenvolvimento de APIs, microserviços e sistemas escaláveis.</p>
            </div>
        </div>
    </div>

    <div class="container-fluid px-17 py-5">
        <h2 class="pb-2 border-bottom">Recursos do Skeleton</h2>
        <div class="row g-4 py-4 row-cols-1 row-cols-lg-3">
            <div class="feature col">
                <div class="feature-icon bg-gradient text-primary">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <h3>Alta performance</h3>
                <p>Com Open Swoole e Laravel Octane, o tempo de resposta é ultrarrápido e ideal para aplicações que precisam
                    escalar.</p>
            </div>
            <div class="feature col">
                <div class="feature-icon bg-gradient text-primary">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <h3>Arquitetura Limpa</h3>
                <p>Separação clara de responsabilidades, preparado para usar Service Providers, Repositories, e testes
                    automatizados.</p>
            </div>
            <div class="feature col">
                <div class="feature-icon bg-gradient text-primary">
                    <i class="bi bi-tools"></i>
                </div>
                <h3>Pronto para Customizações</h3>
                <p>Use como base para qualquer aplicação Laravel moderna com autenticação, banco de dados e API REST.</p>
            </div>
        </div>
    </div>


    <div class="container-fluid px-17 py-5 text-center"
        id="support">
        <h2 class="pb-3">Apoie este projeto 🎉</h2>
        <p class="lead mb-4">Se este skeleton Laravel Octane + OpenSwoole te ajudou, considere apoiar o projeto.</p>

        <a href="https://www.buymeacoffee.com/seu_usuario" target="_blank" rel="noopener" class="btn btn-warning btn-lg">
            <i class="bi bi-cup-hot"></i> Buy Me a Coffee
        </a>
    </div>


    @include('components.footer')
@endsection