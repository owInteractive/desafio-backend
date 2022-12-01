import { Router } from "express";

import { UserController } from "./controllers/UserController";
import { MovementController } from "./controllers/MovementController";
import { AuthenticateUserController } from "./controllers/AuthenticateUserController";
import { ensureAuthenticated } from "./middlewares/ensureAuthenticated";

const router = Router();

const createUserController = new UserController();
const createMovementController = new MovementController();
const authenticateUserController = new AuthenticateUserController();

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
router.patch(
  "/users/:id",
  createUserController.updateUser
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
router.get(
  "/movimentacoes/balanco/:id",
  createMovementController.getMovementBalance
);
router.post(
  "/movimentacoes/export/:id",
  createMovementController.exportMovement
);
router.delete(
  "/movimentacoes/:id",
  createMovementController.deleteMovement
);



// rota de autenticação
router.post(
  "/auth",
  authenticateUserController.handle
);
router.get(
  "/auth",
  ensureAuthenticated,
  authenticateUserController.getInfo
);

export { router };
