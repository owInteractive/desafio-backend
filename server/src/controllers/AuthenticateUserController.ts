import { Request, Response } from "express";
import { AuthenticateUserService } from "../services/AuthenticateUserService";

class AuthenticateUserController {
  async handle(request: Request, response: Response) {
    const { email } = request.body;
    
    const authenticateUserService = new AuthenticateUserService();

    let user = await authenticateUserService.execute({
        email
    });

    return response.json(user);
  }

  async getInfo(request: Request, response: Response) {
    
    const { id } = request
    const authenticateUserService = new AuthenticateUserService();

    const user = await authenticateUserService.getLoginInfo(id)

    return response.json(user);
  }
                                                                                                                                                                                                                                                                                                                                                                                                   
}

export { AuthenticateUserController };