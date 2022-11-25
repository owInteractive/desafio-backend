import { movements } from "../types/movementsTypes";
import utils from '../functions/utils';
import reportCSV from "../functions/reportCSV";
import { tbMovements, tbUsers } from "../models";
import database from '../database';
database.addModels([tbMovements, tbUsers]);

export default class movementsServices {

  private static _functionsUtils = new utils();
  private static _functionsCSV = new reportCSV();

  public static async associateOperation(infos: movements) {
    return new Promise((resolve, reject) => {
      if (isNaN(infos.idUser)) {
        reject({ http_code: 400, error: 'Id do usuário não foi informado corretamente, por favor, verifique!!' });
      } else {
        tbMovements.create(
          {
            idUser: infos.idUser,
            idTypeOperation: infos.idTypeOperation,
            valueOperation: infos.valueOperation,
          })
          .then(() => {
            resolve({ http_code: 200, results: "Operação realizada com sucesso!" });
          }).catch(() => {
            reject({ http_code: 500, error: "Tivemos dificuldades para inserir a operação, por favor, tente novamente!!" });
          });
      }
    });
  }

  public static async deleteOperation(id: any) {
    return new Promise((resolve, reject) => {
      if (isNaN(id)) {
        reject({ http_code: 400, error: 'Id da operação não foi informada corretamente, por favor, verifique!!' });
      }
      else {
        tbMovements.destroy({ where: { id: id } }).then((rows: number) => {
          if (!rows) {
            reject({ http_code: 404, error: 'Não encontramos operações com esse id, por favor, tente novamente!' });
          }
          resolve({ http_code: 200, results: "Operação excluída com sucesso!" });
        })
          .catch((() => {
            reject({ http_code: 500, error: "Tivemos dificuldades para excluir a operação, por favor, tente novamente!!" });
          }));
      }
    });
  }

  public static async getMovements(idUser: any, offset: any, limit: any) {
    return new Promise((resolve, reject) => {
      tbMovements.findAll(
        {
          include: { model: tbUsers, attributes: ['id', 'name', 'email'] },
          order: [["id", "DESC"]],
          offset: Number(offset),
          limit: Number(limit),
          where: {
            idUser: Number(idUser)
          }
        }).then((results: any) => {
        if (!results.length) {
          reject({ http_code: 404, error: 'Não foram encontrados resultados para a paginação e limites informados!' });
        }
        resolve({ http_code: 200, results: results });
      })
        .catch(() => {
          reject({ http_code: 500, error: 'Tivemos dificuldades para listar as informações, por favor, tente novamente!' });
        });
    });
  }

  public static async getBalanceMovements(idUser: any) {
    return new Promise((resolve, reject) => {
      if (isNaN(idUser)) {
        reject({ http_code: 400, error: 'Id do usuário não foi informado corretamente, por favor, tente novamente!!' });
      } else {
        let query = `select t.*, t1.initialValue from tb_movements as t inner join 
        tb_users as t1 on t.idUser = t1.id where t1.id = :idUser order by t.createdAt desc;`;

        tbMovements.sequelize?.query(query, {
          replacements: {
            idUser: Number(idUser)
          }
        }).then((results: any) => {
          if (results[0].length) {
            let valueBalance = this._functionsUtils.formatMoney(results[0][0].initialValue);
            results[0].forEach((element: movements) => {
              switch (element.idTypeOperation) {
                case 1:
                  valueBalance += this._functionsUtils.formatMoney(element.valueOperation);
                  break;
                case 2:
                  valueBalance -= this._functionsUtils.formatMoney(element.valueOperation);
                  break;
                default:
                  valueBalance += this._functionsUtils.formatMoney(element.valueOperation);
                  break;
              }
            });
            let responseResult = {
              saldo_inicial_R$: this._functionsUtils.formatMoney(results[0][0].initialValue).toFixed(2),
              soma_das_movimentações_R$: valueBalance.toFixed(2)
            };
            resolve({
              http_code: 200,
              results: responseResult
            });
          } else {
            reject({ http_code: 404, error: 'Não encontramos movimentações para esse id, por favor, verifique o id informado' });
          }
        }).catch(() => {
          reject({ http_code: 500, error: 'Tivemos dificuldades para listar as informações, por favor, tente novamente!' });
        });
      }
    });
  }

  public static async reportsMovements(infos: movements) {
    return new Promise((resolve, reject) => {
      if (!infos.filter) {
        reject({ http_code: 400, error: 'Por favor, informe um filtro válido para gerar o relatório!' });
      } else {
        let queryReport = `select t.*, t1.name, t1.email, t1.initialValue, t2.typeOperation, 
        DATE_FORMAT(t.createdAt, '%d/%m/%Y') as createdAt, DATE_FORMAT(t.updatedAt, '%d/%m/%Y') as updatedAt 
        from tb_movements as t inner join tb_users as t1 on t.idUser = t1.id inner 
        join tb_operations as t2 on t.idTypeOperation = t2.id `;
        switch (infos.filter) {
          case 'last':
            queryReport += "where t.createdAt BETWEEN DATE_ADD(CURRENT_DATE, INTERVAL -30 DAY) AND NOW() and t1.id = :idUser;";
            break;
          case 'all':
            queryReport += "where t1.id = :idUser order by t.createdAt desc;";
            break;
          default:
            queryReport += "where DATE_FORMAT(t.createdAt, '%Y-%m') = :date and t1.id = :idUser;";
            break;
        }
        tbMovements.sequelize?.query(queryReport, {
          replacements: {
            date: this._functionsUtils.formatDateMonthYear(infos.filter),
            idUser: Number(infos.idUser)
          }
        }).then(async (results: any) => {
          if (!results[0].length) {
            reject({ http_code: 404, error: 'Não foram encontrados informações para o perído e usuário e informado!' });
          } else {
            let valueBalance = this._functionsUtils.formatMoney(results[0][0].initialValue);
            results[0].forEach((element: movements) => {
              switch (element.idTypeOperation) {
                case 1:
                  valueBalance += this._functionsUtils.formatMoney(element.valueOperation);
                  break;
                case 2:
                  valueBalance -= this._functionsUtils.formatMoney(element.valueOperation);
                  break;
                default:
                  valueBalance += this._functionsUtils.formatMoney(element.valueOperation);
                  break;
              }
            });
            const mountedObjectToCSV = {
              valueBalance: valueBalance.toFixed(2),
              results: results[0]
            };
            await this._functionsCSV.genereateReport(mountedObjectToCSV);
            resolve({ http_code: 200, results: [] });
          }
        }).catch(() => {
          reject({ http_code: 500, error: 'Tivemos dificuldades para listar as informações, por favor, tente novamente!' });
        });
      }
    });
  }

}
