import { Request, Response } from "express";
import { CreateMovementService, DeleteMovementService, ExportMovementService, ListMovementService } from "../services/MovementService";

class MovementController {

  // função que cria uma movimentação de um usuário
  async createMovement(request: Request, response: Response) {
    const { operation, user_id, value } = request.body;

    const createMovementService = new CreateMovementService();
    
    const movement = await createMovementService.execute({
      operation,
      user_id,
      value
    });

    return response.json(movement);
  }

  // função que exporta uma movimentação de um usuário
  async exportMovement(request: Request, response: Response) {
    const { id } = request.params
    const { filter, monthly } = request.body;
    
    const exportMovementsService = new ExportMovementService();

    const movement = await exportMovementsService.execute(parseInt(id), filter, monthly);

    if(movement.error)
      return response.status(500).json(movement);
    else{
      return response.attachment("movimentacoes.csv").status(200).send(movement)
    }
  }

  // função que lista as movimentações de um usuário
  async getMovementBy(request: Request, response: Response) {
    const { id } = request.params

    const listMovementsService = new ListMovementService();

    const Movement = await listMovementsService.getMovementBy(parseInt(id));

    return response.json(Movement);
  }

  // função que retorna a soma das movimentações de um usuário
  async getMovementBalance(request: Request, response: Response) {
    const { id } = request.params

    const listMovementsService = new ListMovementService();

    const Movement = await listMovementsService.getMovementBalance(parseInt(id));

    return response.json(Movement);
  }

  // função que deleta uma movimentação de um usuário
  async deleteMovement(request: Request, response: Response){
    const { id } = request.params
    
    const deleteMovementService = new DeleteMovementService();

    const Movement = await deleteMovementService.execute(parseInt(id));

    return response.json(Movement);
  }
}

export { MovementController};