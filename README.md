# Documentação da API

## Como rodar o projeto?
É possível rodar esse projeto manualmente com seu banco de dados ou usar o arquivo docker-compose que está na pasta docker.
Para saber mais sobre: [Docker Compose](https://docs.docker.com/compose/).

Para rodar o projeto localmente usando o docker-compose eu coloquei um Makefile para facilitar o processo, por tanto na raiz do projeto rode:

`make up` -> Para gerar toda a aplicação, migrations e rodar o servidor node.

Isso ira criar roda a rede necessária para a execução do processo, após isso você já pode executar as requisições.

Você também pode rodar o projeto manualmente rodando a API através dos comandos abaixo:

`cd app`<br>
`node ace build`<br>
`cd build`<br>
`npm install --production`<br>
`node server.js`<br>

Obs: Para isso você precisa ter seu próprio banco SQL e Redis rodando localmente.

## Requisições

### Endpoint Dos Usuários

Users:

<strong style="color:green">GET</strong><br>
`/users`

<strong style="color:green">GET</strong><br>
`/users/$user_id`

<strong style="color:blue">POST</strong><br>
`/users`

```curl
{
  "name": string,
  "email": string,
  "birthday": date (YYYY-MM-DD),
  "balance": float
}
```

<strong style="color:red">DELETE</strong><br>
`/users/$user_id`

<strong style="color:orange">PUT</strong><br>
`/users`

```curl
{
    "user_id": integer,
    "balance": float
}
```

### Endpoint De Movimentações

Transactions

<strong style="color:green">GET</strong><br>
`/transactions/$user_id?type=$type`
$type = enum('credit','debt','reversal')

<strong style="color:green">GET</strong><br>
`/transactions/$user_id/all`

<strong style="color:blue">POST</strong><br>
`/transactions`

```curl
{
  "type": enum('credit','debt','reversal'),
  "value": float,
  "user_id": integer
}
```

<strong style="color:red">DELETE</strong><br>
`/transactions`

```curl
{
    "transaction_id": integer
}
```

## Observações
Não implementei a roda de gerar o CSV por conta da falta de tempo, se necessário e com mais tempo posso também fazer essa rota facilmente.

Também não consegui implementar a solução de cache por conta do tempo, se necessário também consigo implementar, pois, já temos a aplicação configurada para usar o servidor Redis do docker-compose file.

O arquivo `postman.json` contém a collection de requisições que podem ser importadas no Postman.