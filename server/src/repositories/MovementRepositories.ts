import { dataSource } from "../database/data-source";
import { Movement } from "../entities/Movement";

export const MovementRepositories = dataSource.getRepository(Movement)