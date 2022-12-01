const supertest = require("supertest");

const url = 'http://localhost:3333';

describe('test auth', () => {
    it('check if email exist', async () => {
      let resp = await supertest(url)
      .post("/auth")
      .send({ email: 'teste@teste.com' })
      .then((response) => {
        if(response.text.includes('token'))
          return true
        else
          return false
      })
      .catch((error) => {
        throw new Error(error);
      })
      expect(resp).toBe(true)
    })
    
})