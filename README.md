# Teste Ow - Backend
Olá seja bem vindo ao repositorio do teste!

## Instalação do projeto
Primeiro faça clone ou baixe o projeto e coloque a pasta do projeto dentro da seu  localhost. 
- Se estiver usando XAMPP como no meu caso, localhost é a pasta htdocs. 
- Pegue o script do banco que esta junto do projeto e importe para o seu gerenciador de banco de dados
- Caso seu banco tenha alguma senha, informa a senha no arquivo banco.php, linha 7 na pasta db-classes.

## Uso Geral 
- TODAS as requisições vão ter uma base URL, que é o caminho de onde esta localizada sua pasta. Exemplo: ``localhost/ow/index.php``
- TODAS as requisições recebem um parametro chamado ``action``, nesse parametro você especifica qual tipo de ação você quer fazer.

### Exemplo:

```
localhost/ow/index.php?action=get-all-user
```

### Os valores possiveis para action são:
```
insert-user - Inserir um usario
get-all-user - Pegar todos os usuarios
get-user - Pegar um unico usuario 
update-user - Alterar as informações de um usario
delete-user - Deletar um usuario

insert-finance - Inserir uma movimentação financeira a um usuario
get-finance - Pegar um movimentação financeira de um usuario
delete-finance - Deletar uma movimentação financeira de um usuario
sum-finance - Somar toda a movimentação financeira e o saldo inicial do usuario

update-inicial-balance - Alterar o saldo inicial de um usuario
create-csv - Cria um arquivo CSV com toda a movimentação financeira do usuario
```

<!-- INSERT USER -->
## Insert-User
- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - user_name - Nome do usuairo
    - user_email - Email do usuario
    - user_birthday - Data de nascimento do usuario
    - initial_balance - Saldo inicial do usuario



Exemplo
 ```
{
    "user_name": "João Vitor",
    "user_email": "vitorjoao39207@gmail.com",
    "user_birthday": "24-12-2003",
    "initial_balance": "10,00"
}
 ```

Resposta
 ```
{
    "usuario inserido"
}
 ```


- Validações:
    - user_name 
        - Não pode ser vazio
    - user_email 
        - Não pode ser vazio
    - user_birthday
         - Não pode ser vazio 
         - Não pode criar cadastro caso tenho menos de 18 anos de idade.
    - initial_balance 
        - Sem validações
        

<!-- GET ALL USER -->

## Get-All-User
Nessa request não é necessario passar nada do corpo da requisição. Apenas passe como valor do parametro action ``get-all-user``

### Resposta
 ```
{
    "id": 1,
    "user_name": "João",
    "user_email": "vitorjoao39207@gmail.com",
    "user_birthday": "24-12-2003",
    "created_at": "28-03-2023",
    "updated_at": "",
    "initial_balance": "10,00"
},
{
    "id": 2,
    "user_name": "Leticia",
    "user_email": "leticia@gmail.com",
    "user_birthday": "01-01-2004",
    "created_at": "28-03-2023",
    "updated_at": "29-03-2023",
    "initial_balance": "0"
}
 ```

<!-- GET USER -->
## Get-User
- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - id - id do usuario que deseja consultar

 ```
{

    "id": 1

}
 ```
 Resposta
 ```
{
    "id": 1,
    "user_name": "João",
    "user_email": "vitorjoao39207@gmail.com",
    "user_birthday": "24-12-2003",
    "created_at": "28-03-2023",
    "updated_at": "",
    "initial_balance": "10,00"
}
 ```

- Validações:
    - id
        - Não pode ser vazio
        
        
<!-- UPDATE USER -->
## Update-user
Especifique o id do usuario que você quer editar, junto com as informações que deseja editar.

- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - id - id do usuario que sera alterado
    - user_name - Nome do usuairo
    - user_email - Email do usuario
    - user_birthday - Data de nascimento do usuario

 ```
{
    "id": 1,
    "user_name": "Leticia Silva",
    "user_email": "letiicasilva@gmail.com",
    "user_birthday": "01-01-2004"
}
 ```
 Resposta
 ```
{
    "Usuario editado com sucesso!"
}
 ```
- Validações:
    - id
        - id do usuario não pode ser vazio
    - user_name 
        - Não pode ser vazio
    - user_email 
        - Não pode ser vazio
    - user_birthday
        - Não pode ser vazio 

<!-- DELETE USER -->

## Delete-user
- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - id - id do usuario que sera apagado

 ```
{
     "id": 13
}
 ```
  Resposta
 ```
{
    "Usuario apagado com sucesso!"

}
 ```

 - Validações:
    - id
        - id do usuario não pode ser vazio




<!-- INSERT USER -->
## insert-finance
- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - user_id - id do usuario que recebera uma movimentação financeira
    - operation_type - Tipo de operação desejada. Digite o numero da operação que deseja
        - 1 Debito
        - 2 Credito
        - 3 Extorno
    - operation_value - Valor da operação

Exemplo
 ```
{
    "user_id": 2,
    "operation_type": 2,
    "operation_value": "4000"
}
 ```

Resposta
 ```
{
    "Operação Inserida"
}
 ```


- Validações:
    - user_id
        - Não pode ser vazio
    - operation_type 
        - Não pode ser vazio
    - operation_value 
        - Sem validação
  

## get-finance
- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - user_id - id do usuario que você deseja pegar as movimentações financeiras
   
Exemplo
 ```
{
    "user_id": 2,
}
 ```

Resposta
 ```
{
    {
    "user": {
        "id": 1,
        "user_name": "João",
        "user_email": "vitorjoao39207@gmail.com",
        "user_birthday": "24-12-2003",
        "created_at": "28-03-2023",
        "updated_at": "",
        "initial_balance": "10,00"
    },
    "Finance": [
        {
            "id": 7,
            "operation_name": "Debito",
            "operation_value": "12,50",
            "user_id": 1,
            "finance_create_at": ""
        },
        {
            "id": 8,
            "operation_name": "Debito",
            "operation_value": "10,50",
            "user_id": 1,
            "finance_create_at": ""
        },
        {
            "id": 9,
            "operation_name": "Debito",
            "operation_value": "10,50",
            "user_id": 1,
            "finance_create_at": ""
        }
    ]
}
}
 ```

- Validações:
    - user_id
        - Não pode ser vazio

        
<!-- INSERT USER -->
## delete-finance
- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - finance_id - id da financia que você deseja apagar
  

Exemplo
 ```
{
    "finance_id": 16
}
 ```

Resposta
 ```
{
    "Movimentação apagada com sucesso!"
}
 ```


- Validações:
    - finance_id
        - Não pode ser vazio
 
<!-- INSERT USER -->
## sum-finance
- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - user_id - id do usuario que sera somado as financias é o saldo inicial
  

Exemplo
 ```
{
    "user_id": 2
}
 ```

Resposta
 ```
{
  "A soma de todas as moviementações foi de: 4,000.00"
}
 ```


- Validações:
    - user_id
        - Não pode ser vazio
 
<!-- INSERT USER -->
## update-initial-balance
- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - user_id - id do usuario que sera somado as financias é o saldo inicial
  

Exemplo
 ```
{
    "user_id": 2,
    "initial_balance": ""
}
 ```

Resposta
 ```
{
  "Saldo inicial editado com sucesso"
}
 ```


- Validações:
    - user_id
        - Não pode ser vazio
    - initial_balance
        - Sem validação


## create-csv
- Nessa request você tem que passar como corpo da requisição, as seguintes informações 
    - user_id - id do usuario você deseja que seja criado o arquivos csv 

Exemplo
 ```
{
    "user_id": 2
}
 ```

Resposta
 ```
{
    7;Debito;12,50;1;
    8;Debito;10,50;1;
    9;Debito;10,50;1;
}
 ```


- Validações:
    - user_id
        - Não pode ser vazio
    

