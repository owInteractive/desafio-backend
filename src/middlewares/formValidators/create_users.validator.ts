import { NextFunction, Request, Response } from "express";
import { body, CustomValidator, validationResult } from "express-validator";
import utils from '../../functions/utils';
import { tbUsers } from "../../models/tbUsers";
import { Op } from "sequelize";


const checkIfEmailExists: CustomValidator = async (value, { req }) => {
  await tbUsers.findAll({
    where: { [Op.and]: [{ email: value }, { id: { [Op.ne]: req.body.id } }] },
    attributes: ['email']
  }).then((user: any) => {
    if (user.length) {
      return Promise.reject('O email já existe, por favor, utilize outro!');
    }
  });
};

const checkAgeUser: CustomValidator = (value) => {
  const functions = new utils();
  let age = functions.userAge(value);
  let minimumAge = 18;
  if (age < minimumAge) {
    return Promise.reject('É necessário ter mais de 18 anos para se cadastrar!');
  }
  return true;

};

export const createUserFormValidator = [
  body('name').notEmpty(),
  body('email').notEmpty().custom(checkIfEmailExists),
  body('birthday').notEmpty().custom(checkAgeUser),
  body('openingBalance').notEmpty(),

  async (req: Request, res: Response, next: NextFunction) => {
    const errors: any = validationResult(req);

    if (!errors.isEmpty())
      return res.status(422).json({ errors: errors.array() });

    next();
  }
];