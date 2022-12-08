const test = require('tape')
const request = require('supertest')

let userID = 1; // Alter it user ID code for run other times

test("Test New Create User [OK]", (t) => {
    request("http://localhost:3000")
        .post("/api/user")
        .send({ name: "User Test", email: "test@test.com", birthday: "1994-02-27" })
        .end(function (err, res) {
            console.log(res.body);
            t.assert(res.status == 201);
            t.assert(res.body.status == 201);
            t.assert(res.body.message == "User created with Sucessfully");
            t.end();
        });
});

test("Test Fetch User by ID [OK]", (t) => {
    request("http://localhost:3000")
        .get("/api/user?userID=" + userID)
        .end(function (err, res) {
            console.log(res.body);
            t.assert(res.status == 200);
            t.assert(res.body.status == 200);
            t.end();
        });
});

test("Test Fetch All Users [OK]", (t) => {
    request("http://localhost:3000")
        .get("/api/user")
        .end(function (err, res) {
            console.log(res.body);
            t.assert(res.status == 200);
            t.assert(res.body.status == 200);
            t.end();
        });
});

test("Test Delete User [OK]", (t) => {
    request("http://localhost:3000")
        .delete("/api/user?userID=" + userID)
        .end(function (err, res) {
            console.log(res.body);
            t.assert(res.status == 410);
            t.end();
        });
});
