# Desafio Back-End - OW Interactive 20/21

## Informações Gerais

- Desenvolvido com PHP 7.4
- Laravel Framework 7.3
- MySQL 8.0;

## Instalando a Aplicação

- Crie uma base de dados com o nome de sua preferência.

- Clone o projeto
	- git clone https://github.com/wesleysilva059/desafio-backend.git

- Após o download, acesse o projeto
	- cd desafio-backend/system-api

- Crie o arquivo de configuração (.env)
	- cp .env.example .env

- Abra o arquivo **.env** e altere a váriavel DB_DATABASE para o nome que você escolheu
	- DB_DATABASE=nome_do_banco

- Instale as dependencias do projeto
	- composer install

- Intale as tabelas e informações inicias, utilizando **migration** e **seeds**
	- php artisan migrate
	- php artisan db:seed

- Para a autenticação no sistema, utilizaremos a biblioteca **passport**
	- php artisan passport:install
	- php artisan key:generate

## Iniciando a aplicação

- Agora iremos subir a aplicação. Após a execução do comando abaixo, você deverá acessar seu nevegador e na URL digitar http://127.0.0.1:8000/
	- php artisan serve

- Agora com nossa aplicação funcionando, iremos executar a limpeza de cache e o autoload de nossa aplicação
	- php artisan cache:clear
	- composer dump-autoload

## Documentação das rotas da API

- php artisan route:list

- O Sistema usado para testes das rotas foi o Insomnia e o arquivo Json das rotas se encontra neste repositorio ou pelo link https://github.com/wesleysilva059/desafio-backend/blob/master/Insomnia_2020-09-01.json

> Obs:

- As informações 
- Os posts e put de dados, foram feitos na tab `body`, na opção `x-www-form-urlencoded`;
- A url usada foi a `http://127.0.0.1:8000` criada pelo comando `php artisan serve`.

| Method | URI                                          | Action
+--------+----------------------------------------------+-----------------------------------------+
|GET     | api/exportCSV/{filter}/{user}                | OperationController@exportCVS 
|POST    | api/operation                                | OperationController@storeOperation   
|GET     | api/operation/{id}                           | OperationController@showOperation    
|DELETE  | api/operation/{user_id}/{operation_id}       | OperationController@destroyOperation 
|GET     | api/operationReport/{param}                  | OperationController@operationReport  
|GET     | api/totalOperations/{id}                     | OperationController@totalOperations  
|PUT     | api/updateOpeningBalance/{id}                | UserController@updateOpeningBalance  
|POST    | api/user                                     | UserController@storeUser             
|GET     | api/user/{id}                                | UserController@showUser              
|DELETE  | api/user/{id}                                | UserController@destroyUser           
|GET     | api/users                                    | UserController@listUsers
+--------+----------------------------------------------+-----------------------------------------+
