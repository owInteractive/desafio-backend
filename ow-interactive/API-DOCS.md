# Desafio Back-End - OW Interactive 20/21 - Gabriel Scaranello

## API DOC

> Obs: foi utilizado o [Insomnia](https://insomnia.rest/download) para testes de API  
> Obs 2: o arquivo de importação do Insomnia se encontra na raiz do projeto Laravel com o nome `Insomnia.yml`

## Descrição

- Todos os exemplos de API estão no arquivo exportado do Insomnia
- A Api utiliza autenticação JWT para realizar chamadas, exceto a API de registro de usuário
- Após registrar o usuário, chamadar a API de login, será gerado um token de acesso
- Copie o token gerado, edite as variáveis de ambiente do Insomnia colocando o token novo
- Todas rodas de movimento tem acesso autorizado agora e será possivel fazer todo o precesso de movimentação

## Rotas Admin

> Para manter uma maior segurança na aplicação, rotas responsáveis por listagem de usuários e exclusão do mesmo não estão disponíveis para todos os usuários, apenas para usuários que possuem a função de administrador.

- Por padrão existe o usuário `admin@test.com` com senha `secret` que deve estar logado para executar as ações listadas acima
- Caso não tenha executado as seeders com dados de teste, este usuário pode ser criado rodando este comando:
  ```bash
  docker-compose exec app php artisan db:seed --class=UserAdminTableSeeder
  ```
