# Desafio Back-End - OW Interactive 21/22

## Informações Gerais

- Desenvolvido com PHP 8.1
- Laravel Framework 10.8
- MySQL 8.0;

## Instalando a Aplicação

- A aplicação esta configurada para rodar pelo docker.

- Clone o projeto
	- git clone git@github.com:wesleysilva059/desafio-backend-21-22.git

- Após o download, acesse o projeto
	- cd desafio-backend-21-22/app

- Subir os containers do Docker e acessar a aplicação dentro do container
    - docker compose up -d
    - docker compose exec app bash

- Instale as dependencias do projeto
	- composer install

- Intale as tabelas e informações inicias, utilizando **migration** e **seeds**
	- php artisan migrate
	- php artisan db:seed

- Para a autenticação no sistema, utilizei o Laravel Sanctum, portanto todas as rotas estão sobre esse middleware, use o usuario criado na seeder
	- email administrador@admin.com
	- senha password
    - usar a rota /api/login e obter o bearertoken necessario a execução das rotas.

## Iniciando a aplicação

- A aplicação estará disponivel na seguinte url
    - http://localost:8000

- Agora com nossa aplicação funcionando, iremos executar a limpeza de cache e o autoload de nossa aplicação
	- php artisan cache:clear
	- composer dump-autoload

## Documentação das rotas da API

- php artisan route:list

- O Sistema usado para testes das rotas foi o Postman e o arquivo Json das rotas se encontra neste repositorio ou pelo link https://github.com/wesleysilva059/desafio-backend-21-22/blob/master/Desafio%20OW.postman_collection.json

> Obs:

- As informações 
- Os posts e put de dados, foram feitos na tab `body`, na opção `x-www-form-urlencoded`;
- A url usada foi a `http://127.0.0.1:8000` criada pelo comando `php artisan serve`.


| Method | URI                                          
|--------|----------------------------------------------
|POST    | api/login                                   
|POST    | api/logout                
|GET     | api/users/list                                
|POST    | api/users/store                           
|DELETE  | api/users/destroy/{id}       
|GET     | api/users/show/{id}                  
|PUT     | api/users/save-opening-balance/{id}                     
|POST    | api/transactions/store                
|GET     | api/transactions/transactions/{id}/{paginate}                             
|GET     | api/transactions/export/{id}                                
|DELETE  | api/transactions/destroy/{id}                                
|GET     | api/users                                    
 
