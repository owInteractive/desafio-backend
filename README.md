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


### Endpoint De Movimentações


## Observações
Não implementei a roda de gerar o CSV por conta da falta de tempo, se necessário e com mais tempo posso também fazer essa rota facilmente.