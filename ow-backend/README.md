# ow-backend
Teste backend ow-interactive

## Instalando dependencias e executando a api

git clone https://github.com/matheuspdias/ow-backend.git
### Entrando na pasta do projeto
$ cd ow-backend
### Criando banco de dados
$ No phpmyadmin crie um banco com o nome ow_interactive  
### Instalando as dependências do projeto.
$ composer install --no-scripts
### renomeie o arquivo env.example para .env
$ no arquivo .env use DB_DATABASE=ow_interactive
### Execute as migrations para criar tabelas com o seguinte comando:
$ php artisan migrate
### Gere uma nova chave para a aplicação laravel:
$ php artisan key:generate
### Publicar configuração de JWT
$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
### Gerando o secret do jwt
$ php artisan jwt:secret
### Inicie a API
$ php artisan serve 

## obs: utilize o insomnia para importar o arquivo rotas_backend.json que está na raiz do projeto para testar a api


# ENDPOINTS

## BASEURL: http://localhost:8000/api

### POST /auth/register
este endpoint é responsavel por cadastra um novo usuário
### Parametros
email: email do usuário

birthdate: Data de nascimento no formato YYYY-mm-dd - Obrigátorio ser maior de 18 anos

password: senha do usuário

password_confirm: confirmação de senha (digite a mesma senha do campo password)

### Respostas
### OK! 200

Essa resposta acontece caso todos dados para cadastro estiverem corretos e irá retornar um token os dados do usuário

### Exemplo de resposta

```
{
   "error":"", 
   "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9yZWdpc3RlciIsImlhdCI6MTYxMzg3NzczMSwibmJmIjoxNjEzODc3NzMxLCJqdGkiOiJVMlQzb1VEV0QxSWhQZzJzIiwic3ViIjoyLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.0t6XikA5kg7TUzSvIkSUX0leEnmd6MO1_UTkNHlRR_A",
   "user":{
      "id":2,
      "name":"teste",
      "email":"teste@gmail.com",
      "balance":"1000",
      "credit":"500",
      "birthdate":"2003-01-01",
      "created_at":"2021-02-21T03:22:11.000000Z",
      "updated_at":"2021-02-21T03:22:11.000000Z"
   }
}
```

### Possiveis erros
### 406 Not Acceptable

essa resposta acontece caso você inseriu algum dado inválido na hora de cadastrar o usuário

### Exemplo de resposta

```
{
   "error":"O valor informado para o campo email já está em uso."
}
```
ou
```
{
  "error": "Você precisa ter no minimo 18 anos para se cadastrar!"
}
```

### POST /auth/login
este endpoint é responsavel por fazer a autenticação de usuarios

### Parametros
email: email do usuário

password: senha do usuário

### Respostas
### OK! 200

Essa resposta acontece caso o email e senha do usuário estiver correto

### Exemplo de resposta

```
{
   "error":"",   
   "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYxMzg3NzcwMCwibmJmIjoxNjEzODc3NzAwLCJqdGkiOiJIMHc0amtZUDNmQ3BGNjlpIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.b5ZOHGEl2BKIe8gmxPCMNj_9cTrZv7XqkTjRFEfKo3g",
   "user":{
      "id":1,
      "name":"Matheus",
      "email":"matheus@gmail.com",
      "balance":"1000",
      "credit":"500",
      "birthdate":"2003-01-01",
      "created_at":"2021-02-21T03:21:26.000000Z",
      "updated_at":"2021-02-21T03:21:26.000000Z"
   }
}
```

### Possiveis erros
### 406 Not Acceptable

essa resposta acontece caso você envio algum dado errado na hora de fazer login

### Exemplo de resposta

```
{
  "error": "E-Mail e\/ou senha incorretos!"
}
```

### GET /users
este endpoint é responsavel por retornar uma lista de todos usuários ordenado por ordem de cadastro

### Parametros
nenhum

### Respostas
### OK! 200

Essa resposta acontece caso o sistema encontrar 1 ou mais usuários

### Exemplo de resposta

```
{
  "error": "",
  "users": [
    {
      "id": 4,
      "name": "teste",
      "email": "teste2@gmail.com",
      "balance": "1000",
      "credit": "500",
      "birthdate": "2002-12-15",
      "created_at": "2021-02-21T03:37:05.000000Z",
      "updated_at": "2021-02-21T03:37:05.000000Z"
    },
    {
      "id": 3,
      "name": "teste",
      "email": "teste@gmail.com",
      "balance": "1000",
      "credit": "500",
      "birthdate": "2003-01-01",
      "created_at": "2021-02-21T03:33:20.000000Z",
      "updated_at": "2021-02-21T03:33:20.000000Z"
    },
    {
      "id": 1,
      "name": "Matheus",
      "email": "matheus@gmail.com",
      "balance": "650",
      "credit": "500",
      "birthdate": "2003-01-01",
      "created_at": "2021-02-21T03:21:26.000000Z",
      "updated_at": "2021-02-21T03:23:43.000000Z"
    }
  ]
}
```

### Possiveis erros
### OK! 200

essa resposta acontece caso o sistema não encontrar nenhum usuário

### Exemplo de resposta

```
{
  "error": "Nenhum usuário encontrado!"
}
```

### GET /user/{id}
este endpoint é responsavel por retornar um único usuario

### Parametros
o id será enviado na url por exemplo: /user/1

### Respostas
### OK! 200

Essa resposta acontece caso o sistema encontrar o usuario com o id informado

### Exemplo de resposta

```
{
  "error": "",
  "user": {
    "id": 1,
    "name": "Matheus",
    "email": "matheus@gmail.com",
    "balance": "650",
    "credit": "500",
    "birthdate": "2003-01-01",
    "created_at": "2021-02-21T03:21:26.000000Z",
    "updated_at": "2021-02-21T03:23:43.000000Z"
  }
}
```

### Possiveis erros
### 406 Not Acceptable

essa resposta acontece caso o sistema não encontrar nenhum usuário com o id informado

### Exemplo de resposta

```
{
  "error": "Este id não pertence a nenhum usuário"
}
```

### PUT /user/{id}
este endpoint é responsavel por alterar o saldo do usuário

### Parametros
o id será enviado na url por exemplo: /user/1

### Respostas
### OK! 200

Essa resposta acontece caso o saldo for alterado

### Exemplo de resposta

```
{
  "error": "",
  "message": "Saldo alterado com sucesso!"
}
```

### DELETE /user/{id}
este endpoint é responsavel por deletar um usuário

### Parametros
o id será enviado na url por exemplo: /user/1

### Respostas
### OK! 200

Essa resposta acontece caso o usuário for deletado

### Exemplo de resposta

```
{
  "error": ""
}
```

### Possiveis erros
### 406 Not Acceptable

essa resposta acontece caso tentar deletar um usuário com saldo ou movimentações

### Exemplo de resposta

```
{
  "error": "Usuário com saldo ou movimentações não podem ser deletados!"
}
```

### POST /movement
este endpoint é responsavel por fazer uma movimentação

## É necessario estar logado no sistema e informar o seu token para acessar essa rota

### Você pode enviar o token via parametro. Ex:

```
{
 "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJ"
}
```

## Você tambem pode enviar o token pelo header. Ex: 

### "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJ"


### Parametros

type: Este parametro recebe o tipo de movimentação que pode ser "credit", "debit", "reversal-credit", "reversal-debit"

value: Este parametro recebe o valor da movimentação

Função de cada type:

type: "credit" - irá fazer uma movimentação do tipo crédito usando o crédito disponivel do usuário

type: "debit" - irá fazer uma movimentação usando o saldo disponivel na conta do usuário

type: "reversal-credito" - irá estornar um valor de crédito para conta do usuário

type: "reversal-debit" - irá retornar um valor de saldo para conta do usuário

### Respostas
### OK! 200

Essa resposta acontece caso uma movimentação seja feita

### Exemplo de resposta

```
{
  "error": "",
  "message": "Débito usado com sucesso!"
}
```

### Possiveis erros
### 406 Not Acceptable

essa resposta acontece caso o tipo de movimentação não for válido

### Exemplo de resposta

```
{
  "error": "",
  "moviment": "opção inválida"
}
```
ou
### 401 Unauthorized

essa resposta acontece caso não seja enviado um token ou o token está inválido

### Exemplo de resposta

```
{
  "error": "Não autorizado"
}
```


### GET /moves
este endpoint é responsavel por retornas as movimentações e informações de um usuário paginadas

## É necessario estar logado no sistema e informar o seu token para acessar essa rota

### Você pode enviar o token via parametro. Ex:

```
{
 "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJ"
}
```

## Você tambem pode enviar o token pelo header. Ex: 

### "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJ"

### Parametros

nenhum

### Respostas
### OK! 200

Essa resposta acontece a busca for realizada

### Exemplo de resposta

```
{
  "error": "",
  "user": {
    "id": 1,
    "name": "Matheus",
    "email": "matheus@gmail.com",
    "balance": "450",
    "credit": "500",
    "birthdate": "2003-01-01",
    "created_at": "2021-02-21T03:21:26.000000Z",
    "updated_at": "2021-02-21T18:10:42.000000Z",
    "moves": {
      "current_page": 1,
      "data": [
        {
          "id": 2,
          "type": "debit",
          "value": "100",
          "id_user": 1,
          "created_at": "2021-02-21T03:23:43.000000Z",
          "updated_at": "2021-02-21T03:23:43.000000Z"
        },
        {
          "id": 3,
          "type": "debit",
          "value": "100",
          "id_user": 1,
          "created_at": "2021-02-21T18:02:38.000000Z",
          "updated_at": "2021-02-21T18:02:38.000000Z"
        },
        {
          "id": 4,
          "type": "debit",
          "value": "100",
          "id_user": 1,
          "created_at": "2021-02-21T18:10:42.000000Z",
          "updated_at": "2021-02-21T18:10:42.000000Z"
        }
      ],
      "first_page_url": "http:\/\/127.0.0.1:8000\/api\/moves?page=1",
      "from": 1,
      "last_page": 1,
      "last_page_url": "http:\/\/127.0.0.1:8000\/api\/moves?page=1",
      "links": [
        {
          "url": null,
          "label": "&laquo; Anterior",
          "active": false
        },
        {
          "url": "http:\/\/127.0.0.1:8000\/api\/moves?page=1",
          "label": 1,
          "active": true
        },
        {
          "url": null,
          "label": "Próximo &raquo;",
          "active": false
        }
      ],
      "next_page_url": null,
      "path": "http:\/\/127.0.0.1:8000\/api\/moves",
      "per_page": 4,
      "prev_page_url": null,
      "to": 3,
      "total": 3
    }
  }
}
```

### Possiveis erros
### 401 Unauthorized

essa resposta acontece caso não seja enviado um token ou o token está inválido

### Exemplo de resposta

```
{
  "error": "Não autorizado"
}
```

### POST /movement/{id}/delete
este endpoint é responsavel por deletar uma movimentação

## É necessario estar logado no sistema e informar o seu token para acessar essa rota

### Você pode enviar o token via parametro. Ex:

```
{
 "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJ"
}
```

## Você tambem pode enviar o token pelo header. Ex: 

### "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJ"


### Parametros

"id": este parametro recebe o id da movimentação

### Respostas
### OK! 200

Essa resposta caso a movimentação for deletada

### Exemplo de resposta

```
{
  "error": "",
  "message": "Movimentação deletada!"
}
```

### Possiveis erros
### 401 Unauthorized

essa resposta acontece caso não seja enviado um token ou o token está inválido

### Exemplo de resposta

```
{
  "error": "Não autorizado"
}
```

### GET /moves_export
este endpoint é responsavel por retornar todas movimentações em um arquivo .csv



### Parametros

nenhum

### Respostas
### OK! 200

Essa resposta irá retornar o arquivo .csv

### GET /moves30_export
este endpoint é responsavel por retornar todas movimentações dos ultimos 30 dias em um arquivo .csv


### Parametros

nenhum

### Respostas
### OK! 200

Essa resposta irá retornar o arquivo .csv