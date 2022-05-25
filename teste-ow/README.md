

<h1 align="center">
     <a href="#"> Teste OW </a>
</h1>

<h4 align="center">
	🚧  Em dev  🚧
</h4>

Tabela de conteúdos
=================
<!--ts-->
   * [Sobre o projeto](#-sobre-o-projeto)
   * [Funcionalidades](#-funcionalidades)
   * [Como executar o projeto](#-como-executar-o-projeto)
     * [Pré-requisitos](#pré-requisitos)
     * [Rodando o Backend (servidor)](#user-content--rodando-o-backend-servidor)
   * [Tecnologias](#-tecnologias)
   * [Autor](#-autor)
   * [Licença](#user-content--licença)
<!--te-->


## 💻 Sobre o projeto


Este Projeto tem como objetivo ser avalidado em teste.

---

## ⚙️ Funcionalidades


- [x] Etapa 1 - Cadastrar Usuários / Endpoint Dos Usuários
- [x] Etapa 2 - Cadastrar Movimentações / Endpoint De Movimentações
- [x] Etapa 3 - Nova Funcionalidades
- [x] Etapa 4 - Diferenciais
---

## 🚀 Como executar o projeto

### Pré-requisitos

antes de começar é necessaria e instalarção do docker [Docker](https://docs.docker.com/engine/install/) e o docker-compose [compose](https://docs.docker.com/compose/install/)


#### 🎲 Rodando o Backend (servidor)

```bash

# execute
$ docker-compose up -d --build

# Instale as dependências caso não o foram
$ docker-compose exec app compose install

# acessando serviço php Ex :
$ docker-compose exec app php artisan serve

# acessando serviço php database :
$ docker-compose exec database <sql>

# acessando serviço nginx :
$ docker-compose exec nginx <comando>

# O php inciará na porta:9000
# O banco inciará na porta:5432
# O servidor inciará na porta:8000 - acesse http://localhost:8000

```

#### 🎲 acesse a docs

``` bash
# basta executar
$ sudo docker-compose exec app php artisan scribe:generate

# acesse http://localhost:8000/api/docs e a documentação estará disponivel.
```

## 🛠 Tecnologias

As seguintes ferramentas foram usadas na construção do projeto:

-   **[PHP](https://www.php.net/)**
-   **[LARAVEL](https://laravel.com/)**
-   **[PGSQL](https://www.postgresql.org/)**

---

## 🦸 Autor

-   **[Matheus](https://github.com/MatheusR1)**


## 📝 Licença

Este projeto esta sobe a licença [MIT](./LICENSE).

Matheus Rocha 👋🏽 [Entre em contato!](https://www.linkedin.com/in/matheus-rocha-724115191/)

---
