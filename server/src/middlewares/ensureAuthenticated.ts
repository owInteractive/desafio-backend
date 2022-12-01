import { Request, Response, NextFunction, request } from "express";
import { verify } from "jsonwebtoken";

interface IPayload {
  sub: string;
}

export function ensureAuthenticated(
  request: Request,
  response: Response,
  next: NextFunction
) {
  // Receber o token
  const authToken = request.headers.authorization;

  // Validar se token está preenchido
  if (!authToken) {
    return response.status(401).end();
  }

  const [, token] = authToken.split(" ");

  try {
    // Validar se token é válido
    const { sub } = verify(
      token,
      process.env.NODE_SECRET || ''
    ) as IPayload;

    // Recuperar informações do usuário
    request.id = parseInt(sub);

    return next();
  } catch (err) {
    return response.status(401).json(JSON.parse(`{"error":"Usuário não está logado!"}`));
  }
}