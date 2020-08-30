# Desafio Back-End - OW Interactive 20/21

## Informações

- Desenvolvido com PHP 7.1, Laravel Framework 5.8, MySQL 8.0;

## Preparando o Projeto

- Crie uma base de dados com o nome de **base_ow**, ou com o nome de sua preferência.

- Clone o projeto
	- git clone https://github.com/tiagoalvesdev/desafio-backend.git

- Após o download, acesso o projeto
	- cd desafio-backend/ow

- Agora você precisa ajustar seu arquivo de conexāo com o banco (.env)
	- cp .env.example .env

- Abra o arquivo **.env** e altere o valor da váriavel DB_DATABASE para **base_ow**, ou o nome que escolheu para sua base e salve o arquivo
	- DB_DATABASE=base_ow

- Instale o composer
	- composer install

- Agora vamos preparar as informações da nossa base, utilizando **migration** e **seeds**
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

## Rotas disponiveis no sistema

Method      | URI                                      | Action
----------- | ---------------------------------------- | -------------------------------------------------------
POST		| api/auth/login                           | App\Http\Controllers\AuthenticationController@login 
POST        | api/auth/logout                          | App\Http\Controllers\AuthenticationController@logout 
POST        | api/auth/register                        | App\Http\Controllers\AuthenticationController@register
GET|HEAD    | api/operations                           | App\Http\Controllers\OperationsController@index
GET|HEAD    | api/operations/amount/{user}             | App\Http\Controllers\OperationsController@amountUser
GET|HEAD    | api/operations/status/{status}           | App\Http\Controllers\OperationsController@showStatus
GET|HEAD    | api/operations/transaction/{transaction} | App\Http\Controllers\OperationsController@showTransaction
GET|HEAD    | api/operations/user/{user}               | App\Http\Controllers\OperationsController@showUser
GET|HEAD    | api/operations/{operation}               | App\Http\Controllers\OperationsController@show
DELETE      | api/operations/{operation}/{user}        | App\Http\Controllers\OperationsController@eliminate
POST        | api/report                               | App\Http\Controllers\OperationsController@reportPost
GET|HEAD    | api/report/{param}                       | App\Http\Controllers\OperationsController@reportGet
GET|HEAD    | api/report/{param}/{user}                | App\Http\Controllers\OperationsController@reportGet


- Testes no Postman
	- Os testes realizados nas rotas, foram com o [Postman](https://www.postman.com/)

	- Para os parametros dos métodos POST
		- Inseri os dados em *Body* e *x-www-form-urlencoded*

	- Lembrando que para acessar os métodos, os mesmos precisam de autenticação, desta forma é necessário:
		- Efetuar um login no sistema (Ex.: email: admin@admin.com / password: admin)
		- O token gerado no acesso deverá ser inserido em *Headers*
			- No campo **KEY** = Authorization e no campo **VALUE** = Bearer + *token gerado*

- Documentação das rotas [neste link](https://documenter.getpostman.com/view/12479411/TVCcXV7d/)