.PHONY: help start test migrate clear

# Parâmetros configuráveis (com valores padrão)
HOST ?= 127.0.0.1
PORT ?= 8000
ADMIN_PORT ?= 2019
WORKERS ?= auto
MAX_REQUESTS ?= 500
CADDYFILE ?=
HTTPS ?= false
HTTP_REDIRECT ?= false
WATCH ?= false
POLL ?= false
LOG_LEVEL ?= info

help:  ## Exibe ajuda com os comandos disponíveis
	@echo "📘 Comandos disponíveis:"
	@echo "  make start             -> Inicia o servidor com os parâmetros padrão"
	@echo "    Variáveis que podem ser sobrescritas:"
	@echo "      HOST=$(HOST)"
	@echo "      PORT=$(PORT)"
	@echo "      ADMIN_PORT=$(ADMIN_PORT)"
	@echo "      WORKERS=$(WORKERS)"
	@echo "      MAX_REQUESTS=$(MAX_REQUESTS)"
	@echo "      CADDYFILE=$(CADDYFILE)"
	@echo "      HTTPS=$(HTTPS)"
	@echo "      HTTP_REDIRECT=$(HTTP_REDIRECT)"
	@echo "      WATCH=$(WATCH)"
	@echo "      POLL=$(POLL)"
	@echo "      LOG_LEVEL=$(LOG_LEVEL)"
	@echo ""
	@echo "  make test       -> Roda os testes da aplicação"
	@echo "  make migrate    -> Executa as migrations do banco"
	@echo "  make clear      -> Limpa cache e arquivos temporários"
	@echo ""

build:  ## Constrói a imagem do Docker
	@echo "🔨 Construindo a imagem do Docker..."
	docker compose build

start:  ## Inicia o servidor
	@echo "🚀 Iniciando servidor com Laravel Octane (Openswoole)..."
	docker compose up -d

stop: ## Para o servidor
	@echo "🛑 Parando servidor..."
	docker compose down

test:  ## Roda os testes
	@echo "Executando testes..."
	docker exec -it app sh -c "php artisan test --parallel --processes=4 --order-by=defects"

migrate:  ## Executa as migrations
	@echo "Migrando base de dados..."
	docker exec -it app sh -c "php artisan migrate --force"

clear:  ## Limpa caches e arquivos temporários
	@echo "Limpando cache..."
	docker exec -it app sh -c "php artisan cache:clear && \
	php artisan config:clear && \
	php artisan route:clear && \
	php artisan view:clear"

showlogs:
	@echo "Exibindo logs do Laravel..."
	docker exec -it app sh -c "php artisan pail -v"

shell:  ## Abre um shell interativo no container
	@echo "Abrindo shell interativo no container..."
	docker exec -it app sh
