# Desafio Backend OW Interactive

    Neste repositório contém os arquivos do desafio-backend da <b>OW Interactive</b>


    Para desenvolver a API Rest, foi utilizado o [Laravel Framework](https://laravel.com/) e no processo de autenticação o [Laravel Passport](https://laravel.com/docs/8.x/passport#introduction) 


    Seguem abaixo os requisitos, procedimentos para instalar do projeto, e observações gerais:


## Requisitos de Ambiente

<ul>
    <li>PHP >= 7.3</li>
    <li>MySql >= 5.7</li>
    <li>Phpmyadmin <small>(Recomendado para criar e acessar banco de dados de forma visual no navegador)</small></li>
    <li>[WampServer](https://www.wampserver.com/en/) <small>(Recomendado pois este faz a instalação do servidor Apache PHP, Mysql, Phpmyadmin)</small></li>
    <li>[Composer](https://getcomposer.org/)</li>
    <li>[Insomnia](https://insomnia.rest/download) <small>(Recomendado para testar a aplicação REST)<small></li>
</ul>

## Como instalar o projeto 

<ul>
    <li>Clone este repositório, e coloque a pasta do projeto na pasta pública do servidor PHP. <br>C:\wamp64\www\* caso utilizar o WampServer ou <br>C:\xampp\htdocs\* caso utilizar o Xamp Server</li>
    <li>Crie um banco de dados para o projeto</li>
    <li>Acesse a pasta do projeto através de algum terminal de comandos, e crie um arquivo .env para a aplicação pelo comando: </li>
    ```
    cp .env.example .env
    ```
    <li>Configure os campos do arquivo .env de acordo com algum editor de texto: </li>
    ```
    APP_URL=http://localhost/desafio-backend/public/ (Url completa do projeto em seu ambiente)
    DB_HOST=127.0.0.1 (com o host banco de dados)
    DB_PORT=3306 (com a porta do host do banco de dados)
    DB_DATABASE=desafio_backend (com o nome do banco de dados)
    DB_USERNAME=root (com o nome do usuário com acesso ao banco de dados) 
    DB_PASSWORD= (com a senha do usuário com acesso ao banco de dados) 
    ```
    <li>Instale as  dependências do LARAVEL pelo comando: </li>
    ```
    composer install
    ```
    <li>Gere a chave da aplicação pelo comando: </li>
    ```
    php artisan key:generate
    ```
    <li>Gere as tabelas do banco de dados executando também as seeders com dados iniciais da aplicação, pelo comando: </li>
    ```
    php artisan migrate -seed
    ```
    <li>Gere as chave do Passport para a autenticação da aplicação funcionar pelo comando: </li>
    ```
    php artisan passport:install
    ```
</ul> 

## Como testar o projeto pelas rotas da Api Rest 

<ul>
    <li>Na raiz desse projeto, existe o arquivo <Insomnia_Importer.json> para você importar no programa Insomnia<li>
    <li>Após importado, conferir a variáveil no Insomnia <base_url_api>, para ele fazer as requisições na URL correta de acordo ao seu ambiente:</li>
    <img src="/public/assets/1.PNG">
    <li>Agora você pode testar todas as rotas de acordo à cada etapa do desafio, seguindo as pastas e cada requisição disponível</li>
    <img src="/public/assets/2.PNG">
<ul>

## Observações

    Para diferenciar rotas públicas e privadas com a autenticação da etapa 4.4 do desafio, foram criadas duas pastas dos mesmos recursos. 
    

    <img src="/public/assets/3.PNG">


    Por exemplo, criei as pastas 'Users - Public' e 'User - Auth'


    Ambas possuem requisições para CRUD de usuários, porém a pasta 'public' somente faz consulta de dados, cadastra, etc, sem levar em consideração o usuário que faz a requisição. Na pasta 'Auth', é criado todo o processo de autenticação baseado em OAuth2 do Laravel Passport. Ou seja, nesta pasta existem rotas para fazer cadastro (signup), login (signin), logout (signout), editar os dados da conta (somente para quando este usuário estiver logado), etc;


    Assim como para os demais recursos, como Movements(Movimentações), Balance(Saldo Inicial), possuem diferenças para consumi-las se forem autenticadas ou não, trazendo dados daquele determinado usuário.



    <b> Não </b> faz necessário configurar o header das requisições autenticadas no Insomnia, pois no arquivo de importação disponibilizado, o token do usuário é recuperado após fazer o login e enviado em toda requisição autenticada.


## Códigos de status HTTP esperados 
<ul>
    <li>200 - Sucesso</li>
    <li>404 - Request não localizado</li>
    <li>422 - Corpo do Request não esta em conformidade esperada</li>
    <li>500 - Erro interno da aplicação ou servidor</li>
</ul>

