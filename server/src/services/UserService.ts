  
import { UsersRepositories } from "../repositories/UsersRepositories";

interface IUserRequest {
  id?: number;
  name: string;
  email: string;
  birthday: Date;
}

class CreateUserService {

  // função que cria um usuário caso ele não exista
  async execute({ name, email, birthday }: IUserRequest) {
    
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

    const user = UsersRepositories.create({
      name,
      email,
      birthday
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

    const res = await UsersRepositories.delete(id);

    if(res.affected === 1){
      return JSON.parse(`{"data":"${user.name}"}`);
    }else{
      return JSON.parse(`{"error":"Usuário não deletado."}`);
    }
  }
}

export { CreateUserService, ListUserService, DeleteUserService };
