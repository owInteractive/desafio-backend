import { NextFunction, Request, Response } from "express";
import { body, validationResult } from "express-validator";

export const createMovementFormValidator = [
  body('idUser').notEmpty(),
  body('idTypeOperation').notEmpty().isNumeric(),
  body('valueOperation').notEmpty().isNumeric(),

  async (req: Request, res: Response, next: NextFunction) => {
    const errors: any = validationResult(req);

    if (!errors.isEmpty())
      return res.status(422).json({ errors: errors.array() });

    next();
  }
];