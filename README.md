# Product management ddd

Implementação de um módulo de **Gestão de Produtos** seguindo princípios reais de **Domain-Driven Design (DDD)**.

# Requisitos

- Docker >= 24
- Docker Compose >= 2
- PHP 8.0+ (caso rode sem Docker)
- Composer
- MySQL
- Elastic search

# Tecnologias Usadas
- PHP 8.0
- Laravel 9
- Mysql
- Elasticsearch
- Redis
- Docker

# Rodar com Docker
- Criar carpetas de volumes ```mkdir -p ./docker/volumes/elasticsearch && chmod -R 777 ./docker/volumes/elasticsearch && mkdir -p ./docker/volumes/mysql && chmod -R 777 ./docker/volumes/mysql && mkdir -p ./docker/volumes/redis && chmod -R 777 ./docker/volumes/redis```
- subir containers ```./vendor/bin/sail build --no-cache && ./vendor/bin/sail up -d```
- accede al container "laravel.test": ```docker exec -it etiquetaunica-laravel.test-1 bash```
- instalar pacotes ```composer install```
- rodar migrações ```php artisan migrate```
- rodar seed ```php artisan db:seed```

# Comandos Básicos – Elasticsearch
Abaixo estão alguns comandos úteis para inspecionar e validar dados diretamente no Elasticsearch utilizando `curl`.
> Certifique-se de que o Elasticsearch esteja rodando em `http://localhost:9200`.

---

## Buscar documento por ID

```bash
curl -X GET "http://localhost:9200/products/_doc/TU_UUID_AQUI?pretty"
```

---

## Listar índices existentes

```bash
curl -X GET "http://localhost:9200/_cat/indices?v"
```

---

## Buscar todos os documentos do índice

```bash
curl -X GET "http://localhost:9200/products/_search?pretty"
```
---

## Apagar índice

```bash
curl -X DELETE "http://localhost:9200/products" 
```



