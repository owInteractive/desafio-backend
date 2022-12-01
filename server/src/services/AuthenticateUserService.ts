import { sign } from "jsonwebtoken";

import { UsersRepositories } from "../repositories/UsersRepositories";

interface IAuthenticateRequest {
  email: string;
}

class AuthenticateUserService {

  // função que obtem o token de autenticação
  async execute({ email }: IAuthenticateRequest) {

    // Verificar se email existe
    let user = await UsersRepositories.findOneBy({
      email,
    });

    if (!user) {
      return JSON.parse('{"error":"Usuário não existe!"}') 
    }

    // Gerar token
    const token = sign(
      {
        id: user.id,
      },
        process.env.NODE_SECRET || "",
      {
        subject: user.id+'',
        expiresIn: "60s",
      }
    );

    return {token:token};
  }

  // obtem as informações de usuário
  async getLoginInfo(id: number){
    
    const user = await UsersRepositories.findOne({
      where: {
        id: id
      }
    });

    if (!user) {
      return JSON.parse(`{"error":"Usário não encontrado."}`) 
    }
    return user 
  }
}

export { AuthenticateUserService };