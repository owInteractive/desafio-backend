# Desafio Back-End - OW Interactive 21/22

### Como rodar o projeto?

##### Para executar o projeto será necessário que esteja pré instalado e configurado as ferramentos docker e docker-compose para realizar a conteinerização da aplicação, existe também a exigencia de utilização de duas portas TCP para subir a aplicação web em Node.js com Express na porta 3000 e o banco de dados Mysql na porta 3306.

```bash
# clone o projeto a partir da raiz desse pull request
git clone git@github.com:MichaelDeMattos/desafio-backend.git
cd desafio-backend
git checkout develop
cd express-app
docker-compose up
```
### Notas:

##### O docker-compose irá se incarregar instalar e configurar todas dependencias necessárias para o projeto. Após esse processo propositalmente a aplicação vai levar em média mais ou menos 15 a 20 segundos para ficar "on". Pois conforme o comando abaixo eu realizo um sleep de 15 segundos antes de iniciar aplicação em Node.js com Express para garantir que o serviço do banco de dados estara ativo quando esta aplicação estiver pronta para ser executada.

```bash
# arquivo docker-compose.yml
command: sh -c "echo Waiting to Database per 15 seconds && sleep 15 && npm start"
```

### Testes
##### Para execução dos testes certifique-se de que a aplicação esteja rodando via docker-compose, dessa forma abra um novo terminal dentro do mesmo diretório da aplicação e execute o comando abaixo:

```bash
npm test
```

### Documentação dos Endpoint
##### Toda a coleção/documentação pertinente ao consumo dos Endpoint desenvolvidos estão contidos path: express-app/postman/express-app.postman_collection.json e podem ser importadas no app Postman.
