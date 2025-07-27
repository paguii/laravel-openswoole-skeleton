#!/bin/sh

# Executa comandos de otimização do Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Inicia o supervisord (que por sua vez inicia o Octane)
exec /usr/bin/supervisord -c /etc/supervisord.conf
