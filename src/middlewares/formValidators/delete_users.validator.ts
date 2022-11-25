import { NextFunction, Request, Response } from "express";
import { param, CustomValidator, validationResult } from "express-validator";
import { tbMovements } from "../../models/tbMovements";

const checkIfMovementsAndBalance: CustomValidator = async value => {
  await tbMovements.findAll({ where: { idUser: value }}).then((values: any) => {
    if (values.length) {
      return Promise.reject('Não é possível excluir o usuário pois o mesmo possui movimentações e saldo!');
    }
  });
};

export const deleteUserFormValidator = [
  
  param('id').notEmpty().custom(checkIfMovementsAndBalance),

  async (req: Request, res: Response, next: NextFunction) => {
    const errors: any = validationResult(req);

    if (!errors.isEmpty())
      return res.status(422).json({ errors: errors.array() });

    next();
  }
];