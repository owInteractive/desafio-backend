![Logo OW Interactive](https://github.com/owInteractive/desafio-backend/raw/master/media/logo.jpg "OW Interactive")

# Desafio Back-End - OW Interactive 21/22

## Como rodar o projeto?
É possível rodar esse projeto manualmente com seu banco de dados. 

Renomeie o arquivo .env.example para .env e configure no arquivo .env as variaveis ambientes para configurar com o próprio banco mysql. 
As váriaveis necessárias são: NODE_SECRET para criação e verificação do token de autenticação, HOST que é o Ip do banco, o USERNAMEDB que é o nome do usuário do banco, PASSWORD a senha do banco, DATABASE o nome do banco e PORTDB que é a porta do banco.

##### Para rodar o projeto manualmente siga os comandos abaixo:
`cd server`
`npm i`
`npm run start`

#### Teste
Para rodar o teste é necessário a aplicação estar rodando, para que seja possivel verificar a autenticação de um email.
`npm run test`

## Requisições

### Endpoint Dos Usuários

**GET**
`/users`

**GET**
`/users/$user_id`

**POST**
`/users`

```curl
{
  "name": string,
  "email": string,
  "birthday": date (YYYY-MM-DD),
  "opening_balance": float
}
```

**DELETE**
`/users/$user_id`

**PATCH**
`/users/$user_id`

```curl
{
    "opening_balance": float
}
```

### Endpoint De Movimentações

**GET**
`/movimentacoes/$user_id`

**GET**
`/movimentacoes/balanco/$user_id`

**POST**
`/movimentacoes/export/$user_id`

```curl
{
  "filter": enum('last','monthly','all'),
  "monthly?": "12/2022",
}
```

**POST**
`/movimentacoes`

```curl
{
  ""user_id": int,
  "operation": enum('credito','debito','estorno'),
  "value": float
}
```

**DELETE**
`/movimentacoes/$movimentacoes_id`

## Observações
O arquivo `insomnia.json` contém a collection de requisições que podem ser importadas no Insomnia.

![Cachorro programando](https://github.com/owInteractive/desafio-backend/raw/master/media/dog.webp "Cachorro programando")
