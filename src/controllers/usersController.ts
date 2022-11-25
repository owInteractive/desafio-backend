import { Request, Response } from "express";
import UserService from "../services/usersServices";
import { users } from '../types/usersTypes';

export default class UserController {

  createUser(request: Request, response: Response) {

    let postBody: users = request.body;
    
    UserService
      .createUser(postBody)
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

  editUser(request: Request, response: Response) {

    let postBody: users = request.body;
    
    UserService
      .editUser(postBody)
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

  deleteUser(request: Request, response: Response) {

    const params: number = Number(request.params.id);
    
    UserService
      .deleteUser(params)
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

  getUser(request: Request, response: Response) {

    const params: number = Number(request.params.id);
    
    UserService
      .getUser(params)
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

  getUsers(request: Request, response: Response) {

    UserService
      .getUsers()
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

  editInitialValue(request: Request, response: Response) {

    let postBody: users = request.body;
    
    UserService
      .editInitialValue(postBody)
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

}
