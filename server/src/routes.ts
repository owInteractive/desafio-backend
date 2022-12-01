import { Router } from "express";

import { UserController } from "./controllers/UserController";

const router = Router();

const createUserController = new UserController();

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

export { router };
