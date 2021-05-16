# Desafio Backend OW Interactive

Neste repositório contém os arquivos do desafio-backend da <b>OW Interactive</b>

Para desenvolver a API Rest, foi utilizado o [Laravel Framework](https://laravel.com/) e no processo de autenticação o [Laravel Passport](https://laravel.com/docs/8.x/passport#introduction)

Seguem abaixo os requisitos e procedimentos para instalar do projeto, e observações gerais:


## Requisitos de Ambiente

PHP >= 7.3

MySql >= 5.7

Phpmyadmin (Recomendado para criar e acessar banco de dados de forma visual no navegador)
    
[WampServer](https://www.wampserver.com/en/) (Recomendado pois este faz a instalação do servidor Apache PHP, Mysql, Phpmyadmin)

[Composer](https://getcomposer.org/)
    
[Insomnia](https://insomnia.rest/download) (Recomendado como client para testar a aplicação Rest)

## Como instalar o projeto 

<ul>
    <li>Clone este repositório, e coloque a pasta do projeto na pasta pública do servidor PHP. 'C:\wamp64\www\*' caso utilizar o WampServer, 'C:\xampp\htdocs\*' caso utilizar o Xamp Server</li>
    <li>Crie um banco de dados Mysql para o projeto</li>
    <li>Acesse a pasta do projeto através de algum terminal de comandos, e crie um arquivo .env para a aplicação pelo comando: </li>
</ul>

    cp .env.example .env     
<ul>
    <li>Configure os campos do arquivo .env de acordo com algum editor de texto: </li>
</ul>

    APP_URL=http://localhost/desafio-backend/public/ (Url completa do projeto em seu ambiente)
    DB_HOST=127.0.0.1 (com o host banco de dados)
    DB_PORT=3306 (com a porta do host do banco de dados)
    DB_DATABASE=desafio_backend (com o nome do banco de dados)
    DB_USERNAME=root (com o nome do usuário com acesso ao banco de dados) 
    DB_PASSWORD= (com a senha do usuário com acesso ao banco de dados) 
 <ul>
    <li>Instale as  dependências do LARAVEL pelo comando: </li>
 </ul> 
 
    composer install    
    
<ul>
    <li>Gere a chave da aplicação pelo comando: </li>
</ul>
    
    php artisan key:generate

<ul>  
    <li>Gere as tabelas do banco de dados executando também as seeders com dados iniciais da aplicação, pelo comando: </li>
</ul>    
    
    php artisan migrate -seed
      
<ul>   
    <li>Gere as chave do Passport para a autenticação da aplicação funcionar pelo comando: </li>
</ul>  

    php artisan passport:install

## Como testar o projeto pelas rotas da Api Rest 

<ul>
    <li>Na raiz desse projeto, existe o arquivo 'Insomnia_Importer.json' para você importar no programa Insomnia</li>
    <li>Após importado, conferir a variável no Insomnia 'base_url_api', para ele fazer as requisições na URL correta de acordo ao seu ambiente:</li>
    <img src="/public/assets/1.PNG">
    <li>Agora você pode testar todas as rotas de acordo à cada etapa do desafio, seguindo as pastas e cada requisição disponível</li>
    <img src="/public/assets/2.PNG">
</ul>

## Observações

Para diferenciar rotas públicas e privadas com a autenticação da etapa 4.4 do desafio, foram criadas duas pastas para os mesmos recursos.    

Por exemplo, criei as pastas 'Users - Public' e 'User - Auth'

Ambas possuem requisições para CRUD de usuários, porém a pasta 'public' somente faz consulta de dados, cadastra, etc, sem levar em consideração o usuário que faz a requisição. Na pasta 'Auth', é criado todo o processo de autenticação baseado em OAuth2 do Laravel Passport. Ou seja, nesta pasta existem rotas para fazer cadastro (signup), login (signin), logout (signout), editar os dados da conta (somente para quando este usuário estiver logado), etc

Assim como para os demais recursos, como Movements(Movimentações), Balance(Saldo Inicial), possuem diferenças para consumi-las se forem autenticadas ou não, trazendo dados daquele determinado usuário.

<b>Não</b> faz necessário configurar o header das requisições autenticadas no Insomnia, pois no arquivo de importação disponibilizado, o token do usuário é recuperado após fazer o login e enviado em toda requisição autenticada.

<img src="/public/assets/3.PNG">


## Códigos de status HTTP esperados 
<ul>
    <li>200 - Sucesso</li>
    <li>404 - Request não localizado</li>
    <li>422 - Corpo do Request não esta em conformidade esperada</li>
    <li>500 - Erro interno da aplicação ou servidor</li>
</ul>

