
### Passo a passo

Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME="Desafio backend - Iury Cleber"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acessar o container
```sh
docker-compose exec app bash
```


Instalar as dependências do projeto
```sh
composer install --ignore-platform-req=ext-zip
```
Migrar banco
```sh
php artisan migrate
```


Gerar a key do projeto Laravel
```sh
php artisan key:generate
```


Comando para rodar seeder e popular o banco com usuarios e movimentações dos usúarios
```sh
php artisan db:seed
```

Acessar o projeto
[http://localhost:8989](http://localhost:8989)

Para acessar a documentação dos endpoints por Swagger, acessar:
[http://localhost:8989/api/documentation](http://localhost:8989/api/documentation)

