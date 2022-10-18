import { Request, Response } from 'express'
import { Controller } from '@/presentation/protocols'

export function adaptRoute (controller: Controller) {
  return async function (req: Request, res: Response): Promise<void> {
    const httpRequest: any = {
      ...(req.body || {}),
      ...(req.params || {}),
      ...(req.query || {})
    }
    try {
      const httpResponse = await controller.handle(httpRequest)
      if (httpResponse.statusCode >= 200 && httpResponse.statusCode <= 299) {
        res.status(httpResponse.statusCode).json(httpResponse.body)
        return
      }

      res.status(httpResponse.statusCode).json({
        error: httpResponse.body.message
      })
    } catch (error) {
      res.status(500).json({
        error: error.message
      })
    }
  }
}
