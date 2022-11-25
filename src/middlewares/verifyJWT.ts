import { NextFunction, Request, Response } from 'express';
import * as jwt from "jsonwebtoken";


export const verifyJWT = [
  async (request: Request, response: Response, next: NextFunction) => {

    let token: any = request.headers["authorization"];

    if (token) {
      token = token.replace(/^Bearer\s/, "");
      if (!token) {
        return response.status(401).json({
          Conexão: "Recusada",
          Atenção: "Você não enviou o token de segurança, por favor, tente novamente!!",
        });
      }
      jwt.verify(token, process.env.SECRET, function (err: any, decoded: any) {
        if (err) {
          return response.status(401).json({
            Conexão: "Recusada",
            Atenção: "O token de segurança enviado é inválido, por favor, verifique!",
          });
        }
        next();
      });
    } else {
      return response.status(401).json({
        Conexão: "Recusada",
        Atenção: "Você não enviou o token de segurança, por favor, tente novamente!",
      });
    }
  }
  
];


