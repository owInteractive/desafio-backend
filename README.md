- Navege até a pasta application e altere o nome do arquivo de .env.production para .env, poderá utilizar o comando: cp .env.production .env
- Navege até a pasta application/docker e execute o comando: sudo docker-compose up --build -d
- Após fazer o build do docker será necessário entrar dentro do container chamado: ow-interactive-php-fpm, utilizando o comando: sudo docker exec -it ow-interactive-php-fpm bash
- Execute os comandos
    - composer install
    - chown -R www-data:www-data bootstrap/cache
    - chown -R www-data:www-data storage
    - php artisan optimize
    - php artisan migrate --seed
    - php artisan storage:link
    - php artisan passport:install
- Após o último comando do passport, você verá na tela escrito algo como:
<br>Encryption keys generated successfully.<br>
Personal access client created successfully.<br>
Client ID: 1<br>
Client secret: UsdKm1XJBbzK640V7QLTlkSFwuBsF0peUcRkk6k1<br>
Password grant client created successfully.<br>
Client ID: 2<br>
Client secret: jOeJSSRmuCfElqP7jrM8SaIMz2SS466ZCuDSsHnf<br>
- Salve a ultima "Client secret", nesse caso é "jOeJSSRmuCfElqP7jrM8SaIMz2SS466ZCuDSsHnf", porém quando rodar o seu comando será outra key.
- php artisan l5-swagger:generate
- Chegou a hora do test! Rode o comando: composer test (espero que passe, aqui deu certo viu? rs)

- Após essa sequência de comandos, será criado um usuário padrão caso não queria criar um.
<br>Usuário: yves.cl@live.com<br>
Senha: 123456

- Não é necessário de autenticação para criar um outro usuário.
- Acesse a documentação pelo link: http://localhost:7777/api/documentation
- Clique no botão "Authorize" e coloque as credenciais que você salvou.
<br>username: yves.cl@live.com (ou algum e-mail que você tenha cadastrado)<br>
password: 123456 (ou senha correspondente ao e-mail cadastrado)<br>
client credentials location: Authorization header<br>
client_id: 2<br>
client_secret: jOeJSSRmuCfElqP7jrM8SaIMz2SS466ZCuDSsHnf (client secret que você salvou)<br>
- Após isso, você ficará autenticado no sistema e poderá acessar as outras rotas.<br>

- Caso seja necessário o jSON do Swagger é este: http://localhost:7777/docs/api-docs.json

**Caso aconteça algum erro de permissão, entre novamente no container e utilize os comandos**
- chown -R www-data:www-data bootstrap/cache
- chown -R www-data:www-data storage
