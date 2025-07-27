# ⚡ Laravel OpenSwoole Skeleton

Este projeto é um skeleton moderno para aplicações Laravel utilizando o Octane com OpenSwoole. Ele foca em alto desempenho, execução assíncrona e processamento em memória.

## 🚀 Sobre o projeto

Este repositório fornece uma base enxuta para iniciar aplicações Laravel com arquitetura baseada em workers persistentes e eventos assíncronos via OpenSwoole. É ideal para quem busca performance real-time e escalabilidade.

## 🧠 Conceitos importantes ao usar OpenSwoole com Laravel

- **Execução persistente em memória**: Diferente do modelo tradicional HTTP, o servidor mantém o Laravel carregado e em memória, reutilizando instâncias entre requisições.
- **Workers em paralelo**: O OpenSwoole cria múltiplos workers, cada um gerenciando requisições de forma independente e eficiente.
- **Octane**: Facilita a integração do Laravel com servidores baseados em corrotinas como OpenSwoole.
- **Cuidados com estado compartilhado**:
  - Evite variáveis globais e singleton compartilhados.
  - Recursos como banco de dados, cache ou conexões devem ser inicializados por worker.
- **Eventos Octane**:
  - Use `Octane::start`, `Octane::tick`, ou `Octane::requestReceived` para ações específicas por worker.

## ⚙️ Comandos via Makefile

Este projeto vem com um `Makefile` que facilita rotinas comuns de desenvolvimento:

```sh
make help        # Exibe ajuda com comandos e variáveis configuráveis
make start       # Inicia o servidor Laravel com Octane (OpenSwoole)
make stop        # Para o servidor
make test        # Roda testes paralelos
make migrate     # Executa as migrations no banco de dados
make clear       # Limpa caches e arquivos temporários
make build       # Constrói imagem Docker
make showlogs    # Exibe logs da aplicação Laravel
make shell       # Abre shell interativo no container
```

## 🔧 Variáveis Configuráveis

Ao usar `make start`, você pode sobrescrever variáveis de ambiente para ajustar o comportamento do servidor OpenSwoole. Isso é útil para testes locais, ajustes finos ou diferentes ambientes de deploy.

### ✅ Exemplos de uso:

```bash
make start HOST=0.0.0.0 PORT=8080 WORKERS=4 LOG_LEVEL=debug HTTPS=true

