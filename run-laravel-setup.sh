#!/bin/bash
# para gerar o binario -> chmod +x <run-laravel-setup.sh>
# para rodar a aplicação -> execute com ./<run-laravel-setup>

docker compose up -d
npm run dev
