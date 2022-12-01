import { Request, Response } from "express";
import { CreateUserService, DeleteUserService, ListUserService, UpdateUserService } from "../services/UserService";

class UserController {
  // função que cria um usuário
  async createUser(request: Request, response: Response) {
    const { name, email, birthday } = request.body;

    const createUserService = new CreateUserService();
    
    const user = await createUserService.execute({
      name,
      email,
      birthday
    });

    if(user.error){
      return response.status(200).json(user)
    }else{
      return response.status(201).json(user);
    }
  }

  // função que lista todos os usuários existentes
  async listUser(request: Request, response: Response) {
    
    const listUsersService = new ListUserService();

    const user = await listUsersService.execute();

    return response.json(user);
  }

  // função que atualiza o saldo inicial usuário
  async updateUser(request: Request, response: Response) {
    const { opening_balance } = request.body;
    const { id } = request.params

    const updateUserService = new UpdateUserService();
    
    const user = await updateUserService.execute(
      parseInt(id),
      opening_balance
    );

    if(user.error){
      return response.status(200).json(user)
    }else{
      return response.status(201).json(user);
    }
  }

  // função que pega um id de um usuário para mostrar
  async getUserBy(request: Request, response: Response) {
    const { id } = request.params

    const listUsersService = new ListUserService();
    let user = await listUsersService.getUserBy(parseInt(id));
    
    if(user.error){
      return response.status(200).json(user)
    }else{
      return response.status(201).json(user);
    }
  }

  // função que pega um id para excluir um usuário
  async deleteUser(request: Request, response: Response){
    const { id } = request.params
    
    const deleteUserService = new DeleteUserService();
    const user = await deleteUserService.execute(parseInt(id));
    
    return response.status(200).json(user);
  }
}

export { UserController};