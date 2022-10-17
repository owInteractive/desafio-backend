import request from 'supertest'
import { describe, test } from 'vitest'
import app from '../config/app'

describe('Body Parser Middleware', () => {
  test('Should parse body as json', async () => {
    const bodyMock = {
      name: 'Guilherme'
    }
    app.post('/test_body_parser', (req, res) => {
      return res.send(req.body)
    })

    await request(app)
      .post('/test_body_parser')
      .send(bodyMock)
      .expect(bodyMock)
  })
})
