import { Request, Response } from 'express'
import { Controller } from '@/presentation/protocols'
import { FileResponseGenerator } from '@/presentation/helpers/file-response'
import { PassThrough } from 'stream'

export function adaptRoute(controller: Controller) {
  return async function (req: Request, res: Response): Promise<void> {
    const httpRequest: any = {
      ...(req.body || {}),
      ...(req.params || {}),
      ...(req.query || {}),
    }
    try {
      const httpResponse = await controller.handle(httpRequest)
      const isFile = httpResponse.body?.data instanceof Buffer
      if (httpResponse.statusCode >= 200 && httpResponse.statusCode <= 299) {
        if (isFile) {
          handleFile(httpResponse.body, res)
          return
        } else {
          res.status(httpResponse.statusCode).json(httpResponse.body)
          return
        }
      } 

      res.status(httpResponse.statusCode).json({
        error: httpResponse.body.message,
      })
    } catch (error) {
      res.status(500).json({
        error: error.message,
      })
    }
  }
}

export function handleFile(file: FileResponseGenerator.Response, res: Response) {
  const readStream = new PassThrough()
  readStream.end(file.data)

  res.set('Content-disposition', `attachment; filename=${file.name}.${file.ext}`)
  res.set('Content-Type', file.mimetype)
  readStream.pipe(res)
}