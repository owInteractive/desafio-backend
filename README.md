
# Desafio - Back end Ow Interactive

## Sobre o projeto

Desenvolvi uma API em node com typescript utilizando express
e sequelize para atender a demanda solicitada no desafio. Abaixo,
explicarei como inicia-la e fazer todos os testes necessários.


## Tecnologias utilizadas

- [x]  Node
- [x]  Nodemon
- [x]  Javascript
- [x]  Typescript
- [x]  Express
- [x]  Sequelize
- [x]  Jest
- [x]  Mysql
- [x]  Postman

## Resumo sobre as tecnologias utilizadas

Utilizei o sequelize como ORM e o Mysql 8 como banco de dados. 

Abaixo os links para baixa-los, caso necessário:

https://hub.docker.com/_/mysql
https://yarnpkg.com/package/sequelize-cli

Estou enviando no projeto, o dump do banco de dados, o arquivo se encontra
no seguinte diretório: 

```/src/docs/mysql/dump-desafio-back-end-202211250040.tar``` 


O sequelize cli é especialmente importante para que seja possível realizar
as migrations, bem como, os seeders no banco de dados. 
Abaixo link explicando como utiliza-lo:

https://sequelize.org/docs/v6/other-topics/migrations/

Para realizar as requisições de testes para a API, utilizei o 
postman. O arquivo de configuração .json com todas as informações 
sobre os requests encontram se no seguinte diretório: 

```/src/docs/postman/ow-postman_collection.json``` 

## Subindo uma instância do Mysql

Nesse ponto, é de suma importância que o banco esteja ativo e operando, 
podendo ser através de migrations e seeders enviados 
ou através do restore do dump enviado. 

Dentro do arquivo ```.env``` encontrará as informações relacionadas
ao banco de dados, caso utilize alguma informação diferente das que 
estão lá, é necessário realizar a mudança nesse arquivo. 
 
## Iniciando em modo desenvolvimento

Para iniciar em modo desenvolvimento, basta seguir os passos abaixo:

- Dentro do diretório raiz do projeto, rodar o seguinte comando: 

   ```yarn install```

- O comando acima fará com que todas as dependências necessárias sejam instaladas corretamente. 

- Após instalar todas as dependências, basta rodar o comando abaixo:
    
    ```yarn developer```

- O comando acima irá iniciar a aplicação em modo de desenvolvimento e irá transpilar os arquivos .TS para .JS para o seguinte diretório: /dist
- O comando acima, também será responsável por observar as mudanças nos arquivos .TS e atualizar os arquivos .JS no diretório /dist. 

## Utilização de containers docker (necessário o docker e o compose instalados)

- Dentro do diretório raiz do projeto, rodar o seguinte comando (caso ainda não tenha instalado as dependências): 
   
    ```yarn install```

- O comando acima irá realizar as instalações das dependências para desenvolvimento local na máquina host. Em produção, não há necessidade, bastando modificar o Dockerfile para realizar a instalação. É útil rodar o comando para não duplicar a pasta node_modules em desenvolvimento. Já em produção, esse comando pode ser ignorado, pois o próprio docker file fará a instalação da node_modules.

- Após realizar a instalação, rodar o seguinte comando:
   
    ```docker compose up```

- O comando acima irá fazer o download das imagens, node e mysql e iniciará os containers com as respectivas imagens e informações do repositório.

- Após realizar as instalações, bem como, iniciar os containers, é necessário realizar as migrations e seeders ou restaurar o dump enviado do mysql. Todo o mapamento das configurações foram realizadas para atender a criação e utilização dos containers.

## Fazendo requisições

Após seguir os passos anteriores, a api estará disponível  na porta 3050
e o banco de dados disponível em localhost.
Basta realizar as requisições através do postman. 
O arquivo postman.json enviado é especialmente útil, pois já tem todas 
as requisições mapeadas. 

## Pontuações importantes sobre endpoint de relatório de movimentações CSV

O endpoint /movements/reportsMovements é um endpoint onde 
se espera que seja passado três parâmetros diferentes, sendo eles: 

- All (irá listar todos os dados, independete da data)
- Last (irá listar todos os dados dos últimos 30 dias)
- 11/2022 (data composta por mês e ano, irá lista somente as movimentações relacionadas ao período informado).

No postman, para realizar o download do arquivo, é necessário clicar na opção: 
send and download, presente na seta ao lado do botão Send. Isso 
fará com que seja solicitado o download do arquivo .csv conforme solicitado 
na descrição do desafio. 

## Realizando testes 

Para escrever os testes, utilizei o JEST e o super test.

Os testes podem ser encontrados no seguinte diretório: 

```src/tests```

Conforme solicitado no desafio, escrevi 3 testes simples de requisições
aos endpoints dos usuários: getUsers, getUser e deleteUser.

Para rodar os testes, basta abrir um novo terminal na raiz do projeto e rodar 
o seguinte comando: 

```yarn test```



## Agradecimentos

Agradeço pela oportunidade de realizar o teste e me coloco a disposição
para qualquer dúvida. Fiz o teste com muito carinho e atendendo a 
todas as solicitações realizadas no escopo do desafio. 

Obrigado e contem comigo!!

## Autor

- [@danielverdan](https://github.com/DanielVerdan)

## 🚀 Sobre mim

Sou um cara apaixonado por tecnologia e que sempre acreditou que a mesma poderia mudar o mundo. O que de fato ficou evidenciado nos últimos anos, visto o turbilhão de informações e avanços tecnológicos que tivemos. 
Encontrei no desenvolvimento de sistemas a oportunidade de transformar a vida das pessoas através de sistemas que consigam auxilia-las em seus processos diários, de forma fácil e prática. 
Ao longos dos anos na minha jornada, conheci diversas pessoas que foram responsáveis por moldar meu desenvolvimento na área de tecnologia e pelas quais tenho grande apreço. 
Sempre fui um grande adepto do desenvolvimento web e procurei me especializar através de cursos, palestras e livros sobre o assunto.
Hoje possuo vasta experiência em desenvolvimento web, utilizando as mais diversas tecnologias presentes no mercado. 

Me disponho a estar sempre em busca de conhecer coisas novas e ter excelentes relacionamentos.
Hoje possuo vasta experiência no desenvolvimento web, trabalhando em alta performance com as mais diversas e atuais tecnologias existentes no mercado.  

Acredito que com conhecimento e experiência alinhados, não há nada que não se possa ser feito na área da tecnologia.

"Nada é tão bom que não possa melhorar e nem tão ruim que não possa piorar, os extremos nunca serão alcançados."