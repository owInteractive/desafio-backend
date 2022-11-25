import { Request, Response } from "express";
import MovementsService from '../services/movementsService';
import { movements } from '../types/movementsTypes';

export default class UserController {

  associateOperation(request: Request, response: Response) {

    let postBody: movements = request.body;

    MovementsService.
      associateOperation(postBody)
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

  deleteOperation(request: Request, response: Response) {

    const params: number = Number(request.params.id);

    MovementsService.deleteOperation(params)
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

  getMovements(request: Request, response: Response) {

    const { idUser, offset, limit } = request.params;

    MovementsService
      .getMovements(idUser, offset, limit)
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

  getBalanceMovements(request: Request, response: Response) {

    const { idUser } = request.params;

    MovementsService
      .getBalanceMovements(idUser)
      .then((resp: any) => {
        return response.status(resp.http_code).json(resp.results);
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }


  reportsMovements(request: Request, response: Response) {

    const postBody = request.body;

    MovementsService
      .reportsMovements(postBody)
      .then(resp => {
        if(resp){
          const file = `src/docs/reports/report.csv`;
          return response.status(200).download(file);
        }
      })
      .catch((err: any) => {
        return response.status(err.http_code).json({ Atenção: err.error });
      });
  }

}
