# Desafio Back-End - OW Interactive 20/21 - Gabriel Scaranello

## Rodando o Projeto

> Obs: será necessário ter o [Docker](https://www.docker.com/) e o [Git](https://git-scm.com/) instalado para continuar

- Clone o projeto:
  ```bash
  git clone https://github.com/gabrielscaranello/desafio-backend.git
  ```
- Entre na pasta `ow-interactive` dentro do projeto clonado:
  ```bash
  cd desafio-backend/ow-interactive
  ```
- Faça uma cópia do arquivo `.env.example` para `.env`:
  ```bash
  cp .env.example .env
  ```
- Configure usuário, senha e nome do banco de dados:

  ```dotenv
  DB_DATABASE=ow-challenge
  DB_USERNAME=ow-challenge
  DB_PASSWORD=secret
  ```

  > O Docker está configurado por padrão com MySql, caso prefira utilizar outro banco de dados deve ser alterado o arquivo `docker-compose.yml`

- Rode o projeto em Docker:
  ```bash
  docker-compose up -d
  ```
- Instale as dependências do projeto:
  ```bash
  docker-compose exec app composer install
  ```
- Gere a chave de aplicação e JWT:
  ```bash
  docker-compose exec app php artisan key:generate
  docker-compose exec app php artisan jwt:secret
  ```
- Rode as migrations:
  ```bash
  docker-compose exec app php artisan migrate
  ```
- Rode todas seeders para teste, incluindo os tipos de operação:
  ```bash
  docker-compose exec app php artisan db:seed
  ```
  Ou insira apenas os registros de tipos de operação:
  ```bash
  docker-compose exec app php artisan db:seed --class=MovimentTypeSeeder
  ```
- Fim!! O projeto estará rodando em `localhost:8000`.

---

[Documentação da API](./API-DOCS.md)

## Todo

- [x] Adicionar docker
- [x] Explicação de como rodar o projeto
- [x] Documentação da API
- [ ] Adicionar gerenciamento de cache
