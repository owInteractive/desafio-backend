import request from 'supertest'
import { describe, test } from 'vitest'
import app from '../config/app'

describe('CORS Middleware', () => {
  test('Should enable CORS', async () => {
    app.get('/test_cors', (req, res) => {
      return res.send()
    })

    await request(app)
      .post('/test_cors')
      .expect('Access-Control-Allow-Origin', '*')
      .expect('Access-Control-Allow-Methods', '*')
      .expect('Access-Control-Allow-Headers', '*')
  })
})
