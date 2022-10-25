# Desafio Back-End 

# Como executar o projeto
>### Configurações de ambiente
>```bash
># Copie o .env.example para .env
>cp .env.example .env
>```

>Depois, coloque as suas variáveis de ambiente:
>```bash
># Ambiente que o NODE está rodando
>NODE_ENV=
>
># Porta que a aplicação rodará (o padrão é a 3000)
>PORT=
>
># Dados do banco de dados
>DB_HOST=
>DB_PORT=
>DB_USER=
>DB_PASS=
>DB_NAME=
>DB_DIALECT= # O padrão é sqlite:memory
>```

>### Rode as migrations
>```bash
># Cria o banco de dados
>npx sequelize db:create
>
># Cria as tableas
>npx sequelize db:migrate
>```

>### Iniciar o servidor
>  ```bash
>  # Entre na pasta do projeto
>  cd app
>
>  # Instale as dependências
>  npm install
>
>  # Execute a aplicação utilizando
>  npm run start
>
>  ```

# Testes automatizados
A aplicação está com mais de `90%` de cobertura de testes, para conseguir rodar ps testes, os comandos são:
``` bash
# Testes unitários
npm run test:unit

# Testes de integração
npm run test:integration

# Todos os testes
npm run test

# Gerar cobertura de testes
npm run test:coverage
```

# Documentação da API
A documentação se encontra na url: `http://localhost:3000/` 