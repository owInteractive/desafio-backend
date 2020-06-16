# Desafio Back-End - OW Interactive 20/21

## Sobre a OW Interactive
Fazemos parte do universo digital, focada em criar e desenvolver experiências interativas, integrando planejamento, criatividade e tecnologia. Conheça mais sobre nós em: [OW Interactive - Quem somos](http://www.owinteractive.com/quem-somos/).

## Vagas
Para saber mais sobre as vagas acesse: [OW Interactive - Vagas](http://www.owinteractive.com/vagas/).

## Pré-requisitos
- Lógica de programação;
- Banco de dados;
- Conhecimentos sobre REST, HTTP e API's;
- Conhecimentos sobre Git.

## Orientações e Sugestões
- Código bem documentado, legível e limpo;
- Fazer uma API simples e objetiva;
- Adicionar ao README instruções claras para rodar o projeto, caso não conseguirmos rodar o projeto será desconsiderado o desafio;
- Documentar os endpoints;
- Caso seja usado Postman, Imsominia, Swagger e etc.Para montar o exemplos da API adicionar ao repósitorio o arquivo gerado pelo programa e especificar qual programa foi usado;
- Os arquivos (CSV, XLS, JSON, XML) etc, que são necessários para o desenvolvimento estão disponíveis no repositório.


## Diferenciais
- Utilizar o [Laravel (PHP)](https://laravel.com/docs/7.x) ou [Adonis/JS (Node)](https://adonisjs.com/docs/4.1/installation);
- Utilizar o [Docker](https://www.docker.com/get-started) para conteinerização da aplicação;
- Pensar em desempenho e escalabilidade, quando for uma quantidade muito grande de dados como o sistema se comportaria;
- Criar testes.

## Desafio

### Etapa 1 - Cadastrar Usuários / Endpoint dos usuários
- Criar um endpoint onde é cadastrado um usuário (Sem autenticação).
 - Esses usuários devem ter obrigátoriamente os seguintes dados modelados, caso você ache necessário outros campos fique a vontade.
  - name | string (Nome)
  - email | string (E-mail)
  - birthday | date (Data de aniversário)
  - created_at | datetime (Criado Em)
  - updated_at | datetime (Atualizado Em)
- Criar um endpoint para listagem desses usuários, ordernados por ordem de cadastro;
- Criar um endpoint para listar um único usuário através do seu id;
- Criar um endpoint para excluir um usuário através do seu id.

### Etapa 2 - Cadastrar Movimentações / Endpoint de movimentações
Nessa etapa você precisará criar a modelagem e lógica para implementar as seguintes funcionalidades.
- Criar um endpoint ou endpoint`s onde é possível associar uma operação de débito, crédito ou estorno para o usuário;
- Criar um endpoint onde seja possível visualizar toda a movimentação do usuários mais as suas informações pessoais;
- Criar um endpoint onde seja possível excluir uma movimentação relacionada a um usuário.

### Etapa 3
- Adicionar dentro do usuário um campo para saldo inicial, e criar um endpoint para alterar esse valor;
- Criar um endpoint com a soma de todas as movimentações (débito, crédito e estorno) mais o saldo inicial do usuário;
- No endpoint que exclui um usuário, adicionar a funcionalidade que agora não será mais possível excluir um usuário que tenha qualquer tipo de movimentação ou saldo;
- No endpoint que cadastra usuário, adicionar a funcionalidade que apenas maiores de 18 anos podem criar uma conta.

### Etapa 4
- Criar validações com base na Request;
- Utilizar cache para otimizar as consultas e buscas.

## Conclusão
Crie um Fork e submeta um Pull Request ao Github com o seu desafio. Após isso envie um e-mail para [letsrock@owinteractive.com](mailto:letsrock@owinteractive.com), com o assunto [DESAFIO BACK-END] com o link para o seu desafio, sua apresentação e currículo anexado em formato PDF.
Caso tenha alguma sugestão sobre o teste ela é bem vinda, fique a vontade para envia-la junto ao e-mail.
Obrigado por participar e muita boa sorte 😀.