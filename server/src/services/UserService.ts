  
import { Movement } from "../entities/Movement";
import { MovementRepositories } from "../repositories/MovementRepositories";
import { UsersRepositories } from "../repositories/UsersRepositories";

interface IUserRequest {
  id?: number;
  name: string;
  email: string;
  birthday: Date;
  opening_balance: number;
}

class CreateUserService {
  // função que cria um usuário caso ele não exista
  async execute({ name, email, birthday, opening_balance }: IUserRequest) {
    
    if (!email) {
      return JSON.parse(`{"error":"Email incorreto."}`);
    }

    const userAlreadyExists = await UsersRepositories.findOneBy({
      email,
    });

    if (userAlreadyExists) {
      return JSON.parse(`{"error":"Usuário já existe."}`);
    }

    // converte uma string para o tipo de dados de data
    birthday = new Date(birthday)
    
    // verifica se a data é maior de 18 anos
    let age = new Date().getFullYear() - birthday.getFullYear();;
    if(age < 18){
      return JSON.parse(`{"error":"Não é possível cadastrar usuário com menos de 18 anos."}`);
    }

    const user = UsersRepositories.create({
      name,
      email,
      birthday,
      opening_balance
    });

    // await UsersRepositories.save(user);

    return {user:''};
  }
}

class UpdateUserService {
  // função que cria um usuário caso ele não exista
  async execute(id:number, opening_balance: number) {
    
    const userAlreadyExists = await UsersRepositories.findOneBy({
      id,
    });

    if (!userAlreadyExists) {
      return JSON.parse(`{"error":"Usuário não existe."}`);
    }

    const user = UsersRepositories.create({
      ...userAlreadyExists, 
      opening_balance:opening_balance
    });

    await UsersRepositories.save(user);

    return user;
  }
}

class ListUserService {

  // função que lista todos os usuários ordenando do mais novo pro mais velho
  async execute() {
    
    const users = await UsersRepositories.find({
      order: {
        created_at: 'DESC'
      }
    });

    return users;
  }

  // função que lista um usuário caso ele exista
  async getUserBy(id: number){

    let user = await UsersRepositories.findOne({
      where: {
        id: id
      }
    });

    if (!user) {
      return JSON.parse(`{"error":"Usuário não existe."}`)
    }

    return user;
  }
}

class DeleteUserService {
  // função que deleta um usuário caso ele exista
  async execute(id: number) {
    const user = await UsersRepositories.findOne({
      where: {
        id: id
      }
    });

    if (!user) {
      return JSON.parse(`{"error":"Usuário não existe."}`);
    }

    const movement = await MovementRepositories.find({
      relations: ['user_id'],
      where: {
        user_id:{
          id: user.id
        }
      }
    })

    let balance = user.opening_balance 
    movement.forEach((mov:Movement) => {
      if(mov.operation === 'credito' || mov.operation === 'debito'){
        balance -= mov.value
      }else{
        balance += mov.value
      }
    })

    if(balance > 0 || movement.length > 0){
      return JSON.parse(`{"error":"Não é possível excluir usuário."}`);
    }

    const res = await UsersRepositories.delete(id);

    if(res.affected === 1){
      return JSON.parse(`{"data":"${user.name}"}`);
    }else{
      return JSON.parse(`{"error":"Usuário não deletado."}`);
    }
  }
}

export { CreateUserService, ListUserService, DeleteUserService, UpdateUserService };
