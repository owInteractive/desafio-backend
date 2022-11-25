const supertest = require("supertest");

require("dotenv").config();
const dotenv = require("dotenv");
dotenv.config();

const url = 'http://localhost:3050';
const token = 'Bearer ' + process.env.TOKEN;

describe("Users", () => {
  it("response list users", (done) => {
    supertest(url)
      .get("/users/getUsers")
      .set("authorization", token)
      .expect(200)
      .then((response: any) => {
        // console.log(response.body);
        done();
      })
      .catch((error: string | undefined) => {
        // console.log(error);
        done();
        throw new Error(error);
      });
  });
  it("response user", (done) => {
    supertest(url)
      .get("/users/getUser/1")
      .set("authorization", token)
      .expect(200)
      .then((response: any) => {
        // console.log(response.body);
        done();
      })
      .catch((error: string | undefined) => {
        // console.log(error);
        done();
        throw new Error(error);
      });
  });
  it("failed delete user", (done) => {
    supertest(url)
      .delete("/users/deleteUser/1")
      .set("authorization", token)
      .expect(422)
      .then((response: any) => {
        // console.log(response.body);
        done();
      })
      .catch((error: string | undefined) => {
        // console.log(error);
        done();
        throw new Error(error);
      });
  });
});


