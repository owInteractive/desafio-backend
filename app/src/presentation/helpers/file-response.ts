import { FileResponse } from '../protocols/file-response'

export class FileResponseGenerator {
   generate(
    request: FileResponseGenerator.Request
  ): FileResponseGenerator.Response {
    const { data, ...info } = request
    const buffer = Buffer.from(data)

    return {
      data: buffer,
      ...info,
    }
  }
}

export namespace FileResponseGenerator {
  export type Request = {
    data: string
    name: string
    ext: string
    mimetype?: string
    size?: number
  }

  export type Response = FileResponse
}
