import { Movement, Operations } from "../entities/Movement";
import { MovementRepositories } from "../repositories/MovementRepositories";
import { UsersRepositories } from "../repositories/UsersRepositories";
import { Parser } from 'json2csv';
import { Between } from "typeorm";

interface IMovementeRequest {
  id?: number;
  user_id: number;
  operation: Operations;
  value: number;
}

type Filter = 'all' | 'last' | 'monthly'

function isOperation(operation: string): operation is Operations {
  return ['debito', 'credito', 'estorno'].indexOf("operation") !== -1;
}

class CreateMovementService {
  // função que cria uma movimentação para um usuário caso ele exista
  async execute({ user_id, operation, value }: IMovementeRequest) {
    
    if (!user_id) {
      return JSON.parse(`{"error":"Id do usuáiro não passado."}`);
    }

    const userAlreadyExists = await UsersRepositories.findOne({
      where:{
        id: user_id
      }
    });

    if (!userAlreadyExists) {
      return JSON.parse(`{"error":"Usuário não existe."}`);
    }

    if(isOperation(operation)){
      return JSON.parse(`{"error":"Operação não existe."}`);
    }

    const movement = MovementRepositories.create({
      operation,
      user_id: userAlreadyExists,
      value
    });

    await MovementRepositories.save(movement);

    return movement;
  }
}

class ListMovementService {
  // função que lista as movimentações de usuário caso ele exista
  async getMovementBy(id: number){

    let movement = await MovementRepositories.find({
      relations: ['user_id'],
      select: ['id', 'operation', 'created_at', 'updated_at'],
      where: {
        user_id: {
          id:id
        }
      }
    });

    if (!movement) {
      return JSON.parse(`{"error":"Não existe movimentações para o usuário ${id}."}`)
    }

    return movement;
  }
  // função que lista as movimentações de usuário caso ele exista
  async getMovementBalance(id: number){

    let movement = await MovementRepositories.find({
      relations: ['user_id'],
      where: {
        user_id: {
          id:id
        }
      }
    });

    if (!movement) {
      return JSON.parse(`{"error":"Não existe movimentações para o usuário ${id}."}`)
    }

    let balance = movement[0].user_id.opening_balance
    movement.forEach((mov:Movement) => {
      if(mov.operation === 'credito' || mov.operation === 'debito'){
        balance -= mov.value
      }else{
        balance += mov.value
      }
    })

    return {
      balance: balance
    };
  }
}

class ExportMovementService {
  // função que lista as movimentações de usuário caso ele exista
  async execute(id: number, filter:Filter, monthly?: string){

    if(filter !== 'all' && filter !== 'last' && filter !== 'monthly'){
      return JSON.parse(`{"error":"Filtro incorreto."}`)
    }

    let dateIni = new Date("01/01/2022")
    let dateEnd = new Date()

    // obtem o ultimo mês ou um mês especifico ou todas as movimentações
    if(filter === 'last') {
      dateIni = new Date(new Date().setDate(dateEnd.getDate() - 30));
    } else if(filter === 'monthly' && monthly !== undefined) {
      let date = monthly.split('/')
      dateIni = new Date(parseInt(date[1]), parseInt(date[0])-1);
      dateEnd = new Date(parseInt(date[1]), parseInt(date[0]));
    }

    let movement = await MovementRepositories.find({
      relations: ['user_id'],
      where: {
        user_id: {
          id:id
        },
        created_at: Between(dateIni, dateEnd)
      }
    });

    if (!movement) {
      return JSON.parse(`{"error":"Não existe movimentações para o usuário ${id}."}`)
    }

    try {
      const fields = [
        {
          label: 'Operação',
          value: 'operation'
        },
        {
          label: 'Valor',
          value: 'value'
        },
        {
          label: 'Id',
          value: 'id'
        },
      ];
      const headerfields = [
        {
          label: 'Nome',
          value: 'name'
        },
        {
          label: 'Email',
          value: 'email'
        },
        {
          label: 'Saldo Inicial',
          value: 'opening_balance'
        },
      ];

      // campos das movimmentações
      const parser = new Parser({ fields: fields});
      let csv = parser.parse(movement);

      // cabeçalho
      const parser2 = new Parser({ fields: headerfields});
      let csv2 = parser2.parse(movement[0].user_id);

      return csv2+'\n\n\n'+csv;
    } catch (err) {
      return JSON.parse(`{"error": "${err}"}}`);
    }
  }
}

class DeleteMovementService {
  // função que deleta um usuário caso ele exista
  async execute(id: number) {
    const movement = await MovementRepositories.findOne({
      where: {
        id: id
      }
    });

    if (!movement) {
      return JSON.parse(`{"error":"Usuário não existe."}`);
    }

    const res = await MovementRepositories.delete(id);

    if(res.affected === 1){
      return JSON.parse(`{"data":"${movement.operation}"}`);
    }else{
      return JSON.parse(`{"error":"Usuário não deletado."}`);
    }
  }
}

export { CreateMovementService, ListMovementService, ExportMovementService, DeleteMovementService };
