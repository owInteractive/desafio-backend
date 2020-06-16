![Logo OW Interactive](https://github.com/owInteractive/desafio-backend/raw/master/media/logo.jpg "OW Interactive")

# Desafio Back-End - OW Interactive 20/21

## Sobre a OW Interactive
Fazemos parte do universo digital, focada em criar e desenvolver experiências interativas, integrando planejamento, criatividade e tecnologia.

Conheça mais sobre nós em: [OW Interactive - Quem somos](http://www.owinteractive.com/quem-somos/).

## Sobre a Vaga
Esse desafio é destinado todos os níveis e não é exigido que você consiga realizar esse desafio por completo.

Sua avaliação será dada pelas etapas que conseguir entregar.

Para saber mais sobre as vagas acesse: [OW Interactive - Vagas](http://www.owinteractive.com/vagas/).

Caso você tenha caido aqui por curiosidade sinta-se a vontade para enviar o desafio e aplicar para alguma vaga de backend.

## Pré-requisitos
- Lógica de programação;
- Conhecimentos sobre Banco de dados;
- Conhecimentos sobre REST, HTTP e API's;
- Conhecimentos sobre Git;

## Requisitos Obrigatórios
- Utilizar a linguagem [PHP](https://www.php.net/) ou [NodeJS](https://nodejs.org)
- Código bem documentado, legível e limpo;
- Fazer uma API simples e objetiva em REST, com o retorno em JSON;
- Adicionar ao README instruções claras para rodar o projeto, caso não conseguirmos rodar o projeto será desconsiderado o desafio;
- Caso seja usado [Postman](https://www.php.net/), [Insomnia](https://insomnia.rest/), [Swagger](https://swagger.io/) e etc.Para montar o exemplos da API adicionar ao repósitorio o arquivo gerado pelo programa e especificar qual o arquivo e programa devem ser usados;
- Em qualquer caso de erro ou  não encontrada a API deve retorna uma resposta condizente com o problema apresentado, por exemplo um retorno 500 ou 404;

## Diferenciais
- Utilizar o [Laravel (PHP)](https://laravel.com/docs/7.x) ou [Adonis/JS (Node)](https://adonisjs.com/docs/4.1/installation);
- Utilizar o [Docker](https://www.docker.com/get-started) para conteinerização da aplicação;
- Pensar em desempenho e escalabilidade, quando for uma quantidade muito grande de dados como o sistema se comportaria;
- Criar testes;
- Utilizar apenas as ferramentas do framework caso use um, evitando criar dependência de outros pacotes ou bibliotecas;

## Desafio

### Etapa 1 - Cadastrar Usuários / Endpoint Dos Usuários
Nessa etapa daremos algumas premissas que devem ser seguidas.

- Criar um endpoint onde é cadastrado um usuário.
  - Esses usuários devem ter obrigátoriamente os seguintes dados modelados, caso você ache necessário outros campos fique a vontade.
    - **name** | string (Nome)
    - **email** | string (E-mail)
    - **birthday** | date (Data de aniversário)
    - **created_at** | datetime (Criado Em)
    - **updated_at** | datetime (Atualizado Em)
- Criar um endpoint para listagem desses usuários, ordernados por ordem de cadastro;
- Criar um endpoint para listar um único usuário através do seu id;
- Criar um endpoint para excluir um usuário através do seu id.

### Etapa 2 - Cadastrar Movimentações / Endpoint De Movimentações
Nessa etapa você precisará criar a modelagem e lógica para implementar as funcionalidades abaixo:

- Criar um endpoint ou endpoint`s onde é possível associar uma operação de débito, crédito ou estorno para o usuário;
- Criar um endpoint onde seja possível visualizar toda a movimentação (páginada) do usuários mais as suas informações pessoais;
- Criar um endpoint onde seja possível excluir uma movimentação relacionada a um usuário;
- Criar um endpoint onde é retornado um arquivo no formato (csv) com 3 tipos de filtros para as movimentações:
  - Últimos 30 dias;
  - Passando o mês e ano por exemplo: 06/20;
  - Todo as movimentações;

### Etapa 3 - Nova Funcionalidades
Nessa etapa serão itens onde veremos como você pensou e como chegou ao resultado final.

- Adicionar dentro do usuário um campo para saldo inicial, e criar um endpoint para alterar esse valor;
- Criar um endpoint com a soma de todas as movimentações (débito, crédito e estorno) mais o saldo inicial do usuário;
- No endpoint que exclui um usuário, adicionar a funcionalidade que agora não será mais possível excluir um usuário que tenha qualquer tipo de movimentação ou saldo;
- No endpoint que cadastra usuário, adicionar a funcionalidade que apenas maiores de 18 anos podem criar uma conta;
- No endpoint que exporta o arquivo CSV criar um cabeçalho com os dados do cliente e o seu saldo atual;

### Etapa 4 -Itens Não Obrigatórios
- Criar validações com base na Request;
- Utilizar cache para otimizar as consultas e buscas;
- Criar Seeders ou Inicializadores de dados para o usuários e suas movimentações;
- Criar os métodos baseados em algum método de autênticação.
- Documentação dos endpoint`s;

## Conclusão
Crie um Fork e submeta uma Pull Request ao Github com o seu desafio. Após isso envie um e-mail para [letsrock@owinteractive.com](mailto:letsrock@owinteractive.com), com o assunto [DESAFIO BACK-END] com o link para o seu desafio, sua apresentação e currículo anexado em formato PDF.

Caso tenha alguma sugestão sobre o teste ela é bem vinda, fique a vontade para envia-la junto ao e-mail.

E fique a vontade para usar os programas e ferramentas que se sentir bem, lembrando que aqui somos team [VS Code](https://code.visualstudio.com/) rs.

Obrigado por participar e boa sorte 😀

![Cachorro programando](https://github.com/owInteractive/desafio-backend/raw/master/media/dog.webp "Cachorro programando")
