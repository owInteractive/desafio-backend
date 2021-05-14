## Iniciando o projeto

Para baixar o projeto e instalar as dependência execute os comandos abaixo:

```
git clone https://github.com/MenezesLucas/desafio-backend
cd desafio-backend
composer install
cp .env.example .env
```

Obs.: Por padrão o projeto irá executar na porta 8000 e o banco na porta 3306, mas é possivel alterar essa configuração editando o arquivo .env

## Executando o projeto

Para executar o docker com o projeto rode o seguinte comando:

```
./vendor/bin/sail up
```

## Inicializando o banco

Agora só falta executar as migrations e seed:

```
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

Agora já esta tudo pronto! O banco foi criado e também foi criado um usuário com os seguinte dados:

Email: admin@admin.com
Senha: admin

Documentação do projeto: https://www.getpostman.com/collections/930204e4c87df464e773

## Teste unitarios

Para executar os testes unitários

```
php artisan test --testsuite=Unit
```