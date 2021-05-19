<h1>Configuração</h1>

Clone o repositório com o comando :<br/>
$ git clone --recurse-submodules https://github.com/MatMr7/desafio-backend.git<br/><br/>

Em seguida entre no repositório com o comando:<br/>
$ cd desafio-backend/<br/><br/>

Agora vamos configurar o .env, execute o comando:<br/>
$ nano .env<br/><br/>

Copie o conteúdo do <a href ="https://drive.google.com/file/d/1BZzqdw4831Lx41Ve7bKfSBfFIJIiOaGi/view?usp=sharing">link</a>, cole no .env e salve.<br/>
Caso prefira, mude o nome do .env-axample para .env<br/><br/>

Agora vamos configurar o .env do docker.<br/>

Execute o comando :<br/>
$ nano /docker/.env<br/>

Copie o conteúdo do <a href ="https://drive.google.com/file/d/1v-QpCxtuD93Um1R5VGw17huKL_ov8yy9/view?usp=sharing">link</a>, cole no .env e salve.<br/>
Caso prefira, copie o .env-axample para .env<br/><br/>

<h3>A configuração está completa :) </h3><br/>

<h1>Docker</h1>

Para executar o docker pela primeira vez, execute os comandos:<br/>

$ cd docker/<br/>

$ sudo docker-compose up nginx mysql redis

$ sudo docker-compose exec workspace bash<br/>

$ composer install<br/>

$ php artisan migrate<br/>

$ php artisan jwt:secret<br/>

$ php artisan db:seed<br/>

$ exit<br/>

Comando para iniciar api:<br/>

$ sudo docker-compose up nginx mysql redis <br/>

Obs: endereço da api: localhost:8888<br/>
Obg: caso tenha algum conflito de portas, altere a porta do container no .env dentro da pasta do docker<br/>

<h1>Documentação</h1>

Insomnia: <a href="https://drive.google.com/file/d/1sStborD0dtRZS5yoMGkdGJOTwhXHy_kR/view?usp=sharing">link </a>

Usuario Default: email: email@mail senha: password

<h3>Autenticação</h3><br/>
&nbsp;&nbsp;&nbsp;A autenticação é feita utilizando JWT, o token tem validade de 1 hora<br>
&nbsp;&nbsp;&nbsp;As requisições deverão conter o seguinte Header - Authorization : "Bearer " + {{token}},

&nbsp;&nbsp;&nbsp;<h5>Login - POST {{base_url}}login </h5><br>

Request Fields:
| Field  | Type   | Description         |
|--------|--------|---------------------|
| `email`    | text    | Este campo faz referência ao email do usuário que deseja recuperar sua senha|
|`password`| text | Este campo faz referência a senha do usuário que deseja logar|

<br>
Request Example<br>

{<br>
    "email":"email@mail",<br>
    "password":"password"<br>
}
<br>

Response Example<br>
{<br>
  "success": true,<br>
  "status": 200,<br>
  "access_token":<br> "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODg4OFwvYXBpXC9sb2dpbiIsImlhdCI6MTYyMTM4NTY1NiwiZXhwIjoxNjIxMzg5MjU2LCJuYmYiOjE2MjEzODU2NTYsImp0aSI6IjZXZno2enVxMmR3MWhPM3kiLCJzdWIiOiI3OGVmMGZjNS0yODI1LTQzNzAtODlhMi1kMTE2MjE0MDEwZTEiLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIiwiaWQiOiI3OGVmMGZjNS0yODI1LTQzNzAtODlhMi1kMTE2MjE0MDEwZTEifQ.awlUxP5nJI5rJI0kftGR5NVQfAZ15x5UleAAeNtLQFc",<br>
  "token_type": "bearer",<br>
  "expires_in": 60<br>
}<br>

&nbsp;&nbsp;&nbsp;<h5>Token refresh - GET {{ base_url }}refreshToken</h5><br>

Response Example<br>
{<br>
  "success": true,<br>
  "status": 200,<br>
  "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODg4OFwvYXBpXC9yZWZyZXNoVG9rZW4iLCJpYXQiOjE2MjExMTUxNzUsImV4cCI6MTYyMTExODc4OCwibmJmIjoxNjIxMTE1MTg4LCJqdGkiOiIxMFl6RkQyTDRmOUhFQllXIiwic3ViIjoiNzQ2ODk3ZGQtNDc1Ni00NWMzLThjMDgtZmY1MDhjM2FmZTc4IiwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.lLJbfXkEMAcVbrIECE99XGN40TiACfHgvGogHxYTvhU",<br>
  "token_type": "Bearer",<br>
  "expires_in": 60<br>
}<br>

&nbsp;&nbsp;&nbsp;<h5>Logout - GET {{ base_url }}Logout</h5><br>

Response Example<br>

{<br>
  "success": true,<br>
  "status": 200<br>
}<br>


<h3>User</h3><br/>

&nbsp;&nbsp;&nbsp;<h5>Cadastra usuário - POST {{ base_url }}user</h5><br>
Request Fields:
| Field  | Type   | Description         |
|--------|--------|---------------------|
| `name`    | text    | Este campo faz referência ao nome do novo usuário|
|`email`| text | Este campo faz referência ao email do novo usuário|
|`birthday`| Date (YYY-mm-dd) | Este campo faz referencia a data em que o usuário nasceu|
|`balance`| number | Este campo faz referencia ao saldo do usuário (campo não obrigatório)| 
|`password`|text | Este campo faz refência a senha do novo usuário|


Request Example<br>


{<br>
	"name":"Chiquinha3",    <br>  
	"email":"duda@mailap",<br>
	"birthday":"2003-03-02",<br>
	"balance":120,<br>
	"password":"123"<br>
}<br>

Response Example<br>
{<br>
  "status": 200,<br>
  "success": true,<br>
  "data": {<br>
    "name": "Chiquinha3",<br>
    "email": "duda@maill",<br>
    "birthday": "2003-03-02",<br>
    "balance": 120,<br>
    "id": "357a8f6f-afda-4e8d-93eb-50d41d1d1036",<br>
    "updated_at": "2021-05-19T02:04:06.000000Z",<br>
    "created_at": "2021-05-19T02:04:06.000000Z"<br>
  }<br>
}<br>

&nbsp;&nbsp;&nbsp;<h5>Listar usuários - GET {{ base_url }}user</h5><br>


Response Example<br>

{<br>
  "total_in_page": 2,<br>
  "success": true,<br><br>
  "status": 200,<br><br>
  "data": [<br><br>
    {<br><br>
      "id": "c401f232-a266-40ff-8ecd-fc12e20ce153",<br><br>
      "name": "matheus",<br><br>
      "email": "matheus@mail",
      "birthday": "2000-03-02",<br><br>
      "created_at": "2021-05-18T01:03:58.000000Z",<br><br>
      "updated_at": "2021-05-18T22:02:52.000000Z",<br><br>
      "balance": 120<br><br>
    },<br><br>
    {<br><br>
      "id": "943d5a7a-bee6-4050-bab2-af67990224d2",<br><br>
      "name": "Chiquinha",<br><br>
      "email": "chiquinha@email",<br><br>
      "birthday": "2000-03-02",<br><br>
      "created_at": "2021-05-18T15:42:13.000000Z",<br><br>
      "updated_at": "2021-05-18T15:42:13.000000Z",<br><br>
      "balance": 0<br><br>
    }<br><br>
  ],<br><br>
  "links": {
    "first": "http:\/\/localhost:8888\/api\/user?page=1",<br><br>
    "last": "http:\/\/localhost:8888\/api\/user?page=48",<br><br>
    "prev": null,<br>
    "next": "http:\/\/localhost:8888\/api\/user?page=2"<br>
  },<br>
  "meta": {<br>
    "current_page": 1,<br>
    "from": 1,<br>
    "last_page": 48,<br>
    "path": "http:\/\/localhost:8888\/api\/user",<br>
    "per_page": "2",
    "to": 2,<br>
    "total": 96<br>
  }<br>
  
  
  &nbsp;&nbsp;&nbsp;<h5>Recupera usuário pelo ID - GET {{ base_url }}user/{id}</h5><br>

Response Example<br>
{<br>
  "status": 200,<br>
  "success": true,<br>
  "data": {<br>
    "id": "c401f232-a266-40ff-8ecd-fc12e20ce153",<br>
    "name": "matheus",<br>
    "email": "matheus@mail",<br>
    "birthday": "2000-03-02",<br>
    "created_at": "2021-05-18T01:03:58.000000Z",<br>
    "updated_at": "2021-05-18T22:02:52.000000Z",<br>
    "balance": 120<br>
  }<br>
}<br>

  &nbsp;&nbsp;&nbsp;<h5>Deleta usuário - DELETE {{ base_url }}user/{id}</h5><br>

Response Example<br>

{<br>
  "status": 200,<br>
  "success": true<br>
}<br>

  &nbsp;&nbsp;&nbsp;<h5>Atualiza saldo do usuário usuário - PUT {{ base_url }}updateUserBalance/{id}</h5><br>
  Request Fields:
| Field  | Type   | Description         |
|--------|--------|---------------------|
| `newBalance`    | number    | Este campo faz referência ao novo balance do usuário|

Request Example<br>

{<br>
	"newBalance":120<br>
}<br>

Response Example<br>

{<br>
  "status": 200,<br>
  "success": true,<br>
  "data": {<br>
    "id": "c401f232-a266-40ff-8ecd-fc12e20ce153",<br>
    "name": "matheus",<br>
    "email": "matheus@mail",<br>
    "birthday": "2000-03-02",<br>
    "created_at": "2021-05-18T01:03:58.000000Z",<br>
    "updated_at": "2021-05-18T22:02:52.000000Z",<br>
    "balance": 120<br>
  }<br>
}<br>

  &nbsp;&nbsp;&nbsp;<h5>Retorna o valor do saldo do usuário - PUT {{ base_url }}sumUserTransactionsAndBalance/{id}</h5><br>
  O saldo é calculado da seguinte forma: Saldo inicial + Valor total das transações do tipo credit + Valor total das transações do tipo reversal - Valor total das transações do tipo debit<br/>
  
  Response Example<br>

  
  {<br>
  "status": 200,<br>
  "success": true,
  "data": 8438.38<br>
}<br>

<h3>Transaction</h3><br/>
  &nbsp;&nbsp;&nbsp;<h5>Cadastra transacao - POST {{ base_url }}transaction</h5><br>
 Request Fields:

| Field  | Type   | Description         |
|--------|--------------------------|---------------------|
| `amount`    | number    | Este campo faz referência ao valor da transação|
| `transaction_type`|enum (debit, credit, reversal) | Este campo faz referência ao tipo da transação|
| `user_email` | text | Este campo faz referência ao email do usuário ao qual a transação se refere |

Request Example<br>
{<br>
	"amount":100,<br>
	"transaction_type":"reversal",<br>
	"user_email":"matheus@mail"<br>
}<br>

Response Example<br>

{<br>
  "status": 200,<br>
  "success": true,<br>
  "data": {<br>
    "amount": 100,
    "transaction_type": "reversal",<br>
    "user_id": "c401f232-a266-40ff-8ecd-fc12e20ce153",<br>
    "id": "85da5d64-0ed8-4e7c-a5ff-750b2b3fc7f5",<br>
    "updated_at": "2021-05-19T02:21:57.000000Z",<br>
    "created_at": "2021-05-19T02:21:57.000000Z"<br>
  }<br>
}<br>

  &nbsp;&nbsp;&nbsp;<h5>Lista transações - GET {{ base_url }}transaction</h5><br>

Response Example<br>
{<br>
  "status": 200,<br>
  "success": true,<br>
  "data": {<br>
    "id": "05350a2e-fc3e-40cd-82da-27e555177c92",<br>
    "amount": 100.99,<br>
    "transaction_type": "reversal",<br>
    "user_id": "c401f232-a266-40ff-8ecd-fc12e20ce153",<br>
    "created_at": "2021-05-18T13:36:55.000000Z",<br>
    "updated_at": "2021-05-18T13:36:55.000000Z"<br>
  }<br>
}<br>

  &nbsp;&nbsp;&nbsp;<h5>Deleta transação - DELETE {{ base_url }}transaction/{id}</h5><br>
Response Example
{<br>
  "status": 200,<br>
  "success": true<br>
}<br>

  &nbsp;&nbsp;&nbsp;<h5>Exporta csv com todas as transacoes - get {{ base_url }}exportTransaction</h5><br>
  Esta rota retorna com um CSV com todas as transacoes com os seguintes cabeçalhos: id, amount, transaction_type, user_id, created_at, updated_at, user_name, user_birthday, user_email, user_balance


