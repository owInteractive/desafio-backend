# Desafio Back-End - OW Interactive 21/22

Tabela de conteúdos
=================
<!--ts-->
* [Como executar o projeto](#-Como-executar-o-projeto)
* [Tecnologias](#-Tecnologias)
* [Utilitários](#-Utilitários)
<!--te-->

* [Endpoints Usuários](#-Endpoints-Usuários)
  * [Criar usuário](#Criar-usuário)
  * [Listar usuários](#Listar-todos-os-usuários)
  * [Listar um usuário](#Listar-um-usuário)
  * [Alterar saldo inicial](#Alterar-saldo-inicial)
  * [Excluir usuário](#Excluir-usuário)
  ---
* [Endpoints Transações](#-Endpoints-ransações)
  * [Criar transação](#Criar-transação)
  * [Listar transações](#Listar-transações)
  * [Resumo das transações](#Resumo-das-transações)
  * [Emitir transações em CSV](#Emitir-transações-em-CSV)
  * [Excluir transação](#Excluir-transação)

* [Autor](#-Autor)

---

# 🎲 Como execultar o projeto

```bash

# Clone este repositório
$ git clone git@github.com:tgmarinho/README-ecoleta.git

# Acesse a pasta do projeto no terminal/cmd
$ cd desafio_OWInteractive

# Instale as dependências
$ npm install

# Execute a aplicação em modo de desenvolvimento
$ npm run dev

# O servidor inciará na porta:3333 - acesse http://localhost:3000 

```

## No diretório em seu banco de dado execulte os scripts SQL na seguinte ordem

* ### 1 - Schema.sql

  * > Arquivo localizado em [src/database/schema.sql](#https://github.com/askagi/desafio-backend/blob/master/src/database/Dump.sql)

* ### 2 - Dump.sql

  * > Arquivo localizado em [src/database/dump.sql](#https://github.com/askagi/desafio-backend/blob/master/src/database/schema.sql)

## Para testes deve ser instalado o [Insomnia](https://insomnia.rest/), em seguida baixe a coleção

<p>
  <a href="https://github.com/askagi/desafio-backend/blob/master/src/docs/Insomnia.json" target="_blank"><img src="https://insomnia.rest/images/run.svg" alt="Run in Insomnia"></a>
</p>

---

# Tecnologias

As seguintes ferramentas foram usadas na construção do projeto:

#### **Server**  ([NodeJS](https://nodejs.org/en/))

* **[Express](https://expressjs.com/)**
* **[KnexJS](http://knexjs.org/)**
* **[dotENV](https://github.com/motdotla/dotenv)**
* **[csv-writer](https://www.npmjs.com/package/csv-writer)**
* **[date-fns](https://date-fns.org/)**
* **[mariadb](https://mariadb.org/)**
* **[mysql2](https://www.npmjs.com/package/mysql2)**
* **[yup](https://www.npmjs.com/package/yup)**

> Veja o arquivo  [package.json]([https://github.com/tgmarinho/README-ecoleta/blob/master/server/package.json](https://github.com/askagi/desafio-backend/blob/master/package.json))

#### [](https://github.com/tgmarinho/Ecoleta#utilit%C3%A1rios)**Utilitários**

* Editor:  **[Visual Studio Code](https://code.visualstudio.com/)**
* Markdown:  **[Hackmd](https://hackmd.io/)**
* Teste de API:  **[Insomnia](https://insomnia.rest/)**
* Modelagem para banco de dados :  **[Sqldbm](https://sqldbm.com/)**

---

# Usuários

## Criar usuário

### `POST` `/users`

* **Requisição**
  * **Body**

    ```typescript
    // Interface
    {
        "name": string,
        "email": string,
        "birthday": date
    }
    ```

* **Exemplo de Retorno**

    ```javascript
    // POST /user
    {
        "name": "Folano de Tal",
        "email": "fulano@email.com",
        "birthday": "1995-08-10"
    }
    ```

---

## Listar todos os usuários

### `GET` `/users`

* **Resposta**
  * listagem de todos so usuários existentes, ordernados por ordem de cadastro decrescente (mais novo para mais antigo)

* #### Exemplo de resposta

    ```javascript
    // HTTP Status 200
    [
        {
    "id": 3,
    "name": "Regiane Teixeira",
    "email": "regianeteixeira@email.com",
    "birthday": "1995-09-06T03:00:00.000Z",
    "created_at": "2022-09-20T17:43:32.000Z",
    "updated_at": "2022-09-21T07:41:43.000Z",
    "opening_balance": 0
    },
    {
    "id": 2,
    "name": "Maria Das Graças",
    "email": "mariadasgraacas@email.com",
    "birthday": "1971-05-30T03:00:00.000Z",
    "created_at": "2022-09-20T06:51:26.000Z",
    "updated_at": null,
    "opening_balance": 0
    },
    {
    "id": 1,
    "name": "José Costa",
    "email": "josecosta@email.com",
    "birthday": "1991-08-10T03:00:00.000Z",
    "created_at": "2022-09-19T22:57:36.000Z",
    "updated_at": null,
    "opening_balance": 300000
    }
    ]

    // nenhum usuário encontrado
    []
    ```

---

## Listar um usuário

### `GET` `/user/:user_id`

* **Requisição**
  * **URL Params** - ID do usuário (passado como parâmetro na rota)

    ```
        GET/user/1
    ```
  
* **Exemplo de Retorno**

    ```javascript
    // GET /user/1
    {
        "id": 1,
        "name": "José Costa",
        "email": "josecosta@email.com",
        "birthday": "1991-08-10T03:00:00.000Z",
        "created_at": "2022-09-19T22:57:36.000Z",
        "updated_at": null,
        "opening_balance": 900000
    }
    ```

---

## Alterar saldo inicial

### `PATCH` `/user/:user_id`

* **Requisição**
  * **Body**

    ```typescript
    // Interface
    {
        opening_balance: number
    }
    ```

  * **URL Params** - ID do usuário (passado como parâmetro na rota)

    ```
        GET/user/1
    ```

* **Exemplo de Retorno**

    ```javascript
    // PATCH /user/1
    {
        "opening_balance": 300000
    }
    ```

## Excluir usuário

### `DELETE` `/user/:user_id`

* **Requisição**
  * **URL Params** - ID do usuário (passado como parâmetro na rota)

    ```
    DELETE/user/1
    ```

---

# Transações

## Criar transação

### `POST` `/transaction/:user_id`

* **Requisição**
  * **Body**

    ```typescript
        // Interface
        {
            type: "debit" | "credit" | "reversal",
            amount: number,
            description?: string
        }
    ```

  * **URL Params** - ID do usuário (passado como parâmetro na rota)

    ```
    POST/transaction/1
    ```

* **Exemplo de Retorno**

    ```javascript
    // POST /transaction/1
    {
        "type": "debit",
        "amount": 1050,
        "description": "Descrição..."
    }
    ```

---

## Listar transações

### `GET` `/transactions/user/:user_id`

* **Requisição**
  * **URL Params** - ID do usuário (passado como parâmetro na rota)

    ```
    GET/transactions/user/1
    ```

  * **URL Query Params** - Paginção: por padão a primeira pagina é 0, cada página retorna no maximo 5 transações (opicional)

    ```
      GET/transaction/user/1?page=1
    ```

* **Exemplo de Retorno**

    ```javascript
    // GET /transaction/user/1

    {
        "id": 1,
        "name": "José Costa",
        "email": "josecosta@email.com",
        "birthday": "1991-08-10T03:00:00.000Z",
        "created_at": "2022-09-19T22:57:36.000Z",
        "updated_at": null,
        "opening_balance": 300000,
        "page": 0,
        "transactions": [
            {
            "id": 25,
            "user_id": 1,
            "type": "reversal",
            "amount": 12000,
            "description": "Compra duplicada de vestido",
            "moment": "2022-09-20T16:56:47.000Z"
            },
            {
            "id": 24,
            "user_id": 1,
            "type": "reversal",
            "amount": 12000,
            "description": "Compra duplicada de vestido",
            "moment": "2022-09-20T16:56:47.000Z"
            },
            {
            "id": 19,
            "user_id": 1,
            "type": "reversal",
            "amount": 12000,
            "description": "Compra duplicada de vestido",
            "moment": "2022-09-20T16:56:46.000Z"
            }
        ]
    }

    ```

---

## Resumo das transações

### `GET` `/transactions/user/:user_id/summary`

* **Requisição**
  * **URL Params** - ID do usuário (passado como parâmetro na rota)

    ```
    GET/transactions/user/1/summary
    ```

* **Exemplo de Retorno**

    ```javascript
    /// GET/transactions/user/1/summary

    {
        "opening_balance": 300000,
        "debit": 4300,
        "credit": 1800,
        "reversal": 228000
    }
    ```

---

## Emitir transações em CSV

### `GET` `/transactions/user/:user_id/csv`

* **Requisição**
  * **URL Params** - ID do usuário (passado como parâmetro na rota)

    ```
    GET/transactions/user/1/csv
    ```

  * **URL Query Params**
    * **filtros para as transações:**

        ```typescript
            {
                last_days: number //Retorna transaçoẽs referente a quantidade de dias informado
                month_year: date //Retorna transações no mês e ano informado. Ex: 02/22
            }
        ```

    * **Exemplos de requisição**

        ```
        GET/transaction/user/1/csv
        ```

        ```
        GET/transaction/user/1/csv?laste_day=30
        ```

        ```
        GET/transaction/user/1/csv?month_year=02/22
        ```

* **Exemplo de Retorno**
  * Retorna uma arquivo no formato CSV com as transações do usuário

---

## Excluir transação

### `DELETE` `/transactions/:transaction_id`

* **Requisição**
  * **URL Params** - ID da transação (passado como parâmetro na rota)

    ```
    DELETE/transactions/1
    ```

---

# 🦸 Autor

<a href="https://github.com/askagi">
 <img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/u/58970300?v=4" width="100px;" alt=""/>
 <br />🎧
 <sub><b>José Costa</b></sub></a> <a href="https://www.linkedin.com/in/josecostasantosjr/" title="Linkedin"></a>
 <br />

[![Linkedin Badge](https://img.shields.io/badge/-José_Costa-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/josecostasantosjr/)](https://www.linkedin.com/in/josecostasantosjr/)
[![Gmail Badge](https://img.shields.io/badge/-josecostasantos.jr@gmail.com-c14438?style=flat-square&logo=Gmail&logoColor=white&link=mailto:josecostasantos.jr@gmail.com)](mailto:josecostasantos.js@gmail.com)

---
