import { Router } from "express";
import movementsController from "../controllers/movementsController";
import { createMovementFormValidator } from "../middlewares/formValidators/movements.validator";

import { verifyJWT } from '../middlewares/verifyJWT';

export default class UsersRoutes {
  private _router = Router();
  private _movementsController = new movementsController();

  constructor() {
    this.createRoutes();
  }

  public getRouter(): Router {
    return this._router;
  }

  private createRoutes() {
    this._router.post(
      "/movements/associateOperation", verifyJWT, createMovementFormValidator, this._movementsController.associateOperation
    );
    this._router.delete(
      "/movements/deleteOperation/:id", verifyJWT, this._movementsController.deleteOperation
    );
    this._router.get(
      "/movements/getMovements/:idUser/:offset/:limit", verifyJWT, this._movementsController.getMovements
    );
    this._router.get(
      "/movements/getBalanceMovements/:idUser", verifyJWT, this._movementsController.getBalanceMovements
    );
    this._router.post(
      "/movements/reportsMovements", verifyJWT, this._movementsController.reportsMovements
    );
  }

}
