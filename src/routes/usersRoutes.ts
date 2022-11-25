import { Router } from "express";
import usersController from "../controllers/usersController";
import { createUserFormValidator } from "../middlewares/formValidators/create_users.validator";
import { deleteUserFormValidator } from "../middlewares/formValidators/delete_users.validator";

import { verifyJWT } from '../middlewares/verifyJWT';

export default class UsersRoutes {
  private _router = Router();
  private _usersController = new usersController();

  constructor() {
    this.createRoutes();
  }

  public getRouter(): Router {
    return this._router;
  }

  private createRoutes() {
    this._router.post(
      "/users/createUser", verifyJWT, createUserFormValidator, this._usersController.createUser
    );
    this._router.put(
      "/users/editUser", verifyJWT, createUserFormValidator, this._usersController.editUser
    );
    this._router.delete(
      "/users/deleteUser/:id", verifyJWT, deleteUserFormValidator, this._usersController.deleteUser
    );
    this._router.get(
      "/users/getUser/:id", verifyJWT, this._usersController.getUser
    );
    this._router.get(
      "/users/getUsers", verifyJWT, this._usersController.getUsers
    );
    this._router.put(
      "/users/editInitialValue", verifyJWT, this._usersController.editInitialValue
    );
  }

}
