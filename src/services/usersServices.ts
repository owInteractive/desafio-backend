import { users } from "../types/usersTypes";
import { tbUsers } from "../models";
import database from '../database';
database.addModels([tbUsers]);

export default class usersServices {

  public static async createUser(infosUser: users) {
    return new Promise((resolve, reject) => {
      tbUsers.create(
        {
          name: infosUser.name,
          email: infosUser.email,
          birthday: infosUser.birthday,
          initialValue: infosUser.initialValue
        })
        .then(() => {
          resolve({ http_code: 200, results: "Usuário inserido com sucesso!" });
        }).catch(() => {
          reject({ http_code: 500, error: "Tivemos dificuldades para inserir o usuário, por favor, tente novamente!!" });
        });
    });
  }

  public static async editUser(infosUser: users) {
    return new Promise((resolve, reject) => {
      if (isNaN(infosUser.id)) {
        reject({ http_code: 400, results: 'Id do usuário não foi informado corretamente, por favor, verifique!!' });
      } else {
        tbUsers.update({
          name: infosUser.name,
          email: infosUser.email,
          birthday: infosUser.birthday,
          initialValue: infosUser.initialValue,
          updatedAt: new Date(),
        },
        {
          where: {
            id: infosUser.id
          }
        }).then(() => {
          resolve({ http_code: 200, results: "Usuário editado com sucesso!" });
        }).catch(() => {
          reject({ http_code: 500, error: "Tivemos dificuldades para editar o usuário, por favor, tente novamente!!" });
        });
      }
    });
  }

  public static async deleteUser(id: any) {
    return new Promise((resolve, reject) => {
      if (isNaN(id)) {
        reject({ http_code: 400, error: 'Id do usuário não foi informado corretamente, por favor, verifique!!' });
      }
      else {
        tbUsers.destroy({ where: { id: id } }).then((rows: number) => {
          if (!rows) {
            reject({ http_code: 404, error: 'Usuário não foi encontrado, por favor, verifique o id e tente novamente!' });
          }
          resolve({ http_code: 200, results: "Usuário excluído com sucesso!" });
        })
          .catch(() => {
            reject({ http_code: 500, error: "Tivemos dificuldades para excluir o usuário, por favor, tente novamente!!" });
          });
      }
    });
  }

  public static async getUser(id: any) {
    return new Promise((resolve, reject) => {
      if (isNaN(id)) {
        reject({ http_code: 400, results: 'Id do usuário não foi informado corretamente, por favor, verifique!!' });
      } else {
        tbUsers.findAll({ where: { id: id } }).
          then((results: any) => {
            if (!results.length) {
              reject({ http_code: 404, error: 'Usuário não foi encontrado, por favor, verifique o id e tente novamente!!' });
            }
            resolve({ http_code: 200, results: results });
          })
          .catch(() => {
            reject({ http_code: 500, error: "Tivemos dificuldades para buscar o usuário, por favor, tente novamente!!" });
          });
      }
    });
  }

  public static async getUsers() {
    return new Promise((resolve, reject) => {
      tbUsers.findAll({ order: [["createdAt", "DESC"]] })
        .then((results: any) => {
          resolve({ http_code: 200, results: results });
        })
        .catch(error => {
          console.log(error);
          reject({ http_code: 500, error: "Tivemos dificuldades para buscar os usuários, por favor, tente novamente!!" });
        });
    });
  }

  public static async editInitialValue(infosUser: users) {
    return new Promise((resolve, reject) => {
      if (isNaN(infosUser.id)) {
        reject({ http_code: 400, error: 'Id do usuário não foi informado corretamente, por favor, verifique!!' });
      } else {
        tbUsers.update({
          initialValue: infosUser.initialValue,
        },
        {
          where: {
            id: infosUser.id
          }
        }).then(() => {
          resolve({ http_code: 200, results: "Saldo inicial editado com sucesso!" });
        }).catch(() => {
          reject({ http_code: 500, error: "Tivemos dificuldades para editar o saldo inicial, por favor, tente novamente!!" });
        });
      }
    });
  }

}
