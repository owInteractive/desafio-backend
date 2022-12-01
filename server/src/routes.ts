import { Router } from "express";

import { UserController } from "./controllers/UserController";
import { MovementController } from "./controllers/MovementController";

const router = Router();

const createUserController = new UserController();
const createMovementController = new MovementController();

// rotas do usuário
router.post(
  "/users",
  createUserController.createUser
);
router.get(
  "/users",
  createUserController.listUser
);
router.get(
  "/users/:id",
  createUserController.getUserBy
);
router.delete(
  "/users/:id",
  createUserController.deleteUser
);


// rotas das movimentações
router.post(
  "/movimentacoes",
  createMovementController.createMovement
);
router.get(
  "/movimentacoes/:id",
  createMovementController.getMovementBy
);
router.post(
  "/movimentacoes/export/:id",
  createMovementController.exportMovement
);
router.delete(
  "/movimentacoes/:id",
  createMovementController.deleteMovement
);

export { router };
