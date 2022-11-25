import { Router } from "express";
const routes = Router();

import UsersRoutes from "./usersRoutes";
import MovementsRoutes from "./movementsRoutes";

const usersRoutes = new UsersRoutes();
const movementsRoutes = new MovementsRoutes();

routes.use("/", usersRoutes.getRouter());
routes.use("/", movementsRoutes.getRouter());


export default routes;
