# Desafio Back-End

- Criar um arquivo .env no diretório raiz seguindo o template .env.example
- Configurar o banco de dados
- Rodar o comando no terminal php artisan migrate
- Após essa etapa ir até a tabela "methods" e acrescentar 2 informações
- Setar o id 1 com o nome credit
- Setar o id 2 com o nome debit

## Subindo o Projeto

- Rodar o comando php -S localhost:8000 -t public

## Ferramentas utilizadas

- Lumen 5.8
- Swagger

## Endpoint para pegar o relatório em CSV

- localhost:8000/export/{id}/{month}-{year}

## Lembretes

- Assim que baixar o projeto lembrar do composer install
- Não esquecer de subir o servidor na porta 8000 por causa da collection do Insomnia
