let fs = require('fs');
const ObjectsToCsv = require('objects-to-csv');

export default class ReportCSV {

  async genereateReport(ObjectMountedToCSV: any) {

    const file = 'src/docs/reports/report.csv';

    if (fs.existsSync(file)) {
      fs.unlinkSync(file);
    }

    let infosUser = `Nome,E-mail,Valor inicial, Salto atual\r\n${ObjectMountedToCSV.results[0].name},${ObjectMountedToCSV.results[0].email},${ObjectMountedToCSV.results[0].initialValue}, ${ObjectMountedToCSV.valueBalance}\r\n\r\n`;
    await fs.writeFileSync(file, infosUser);

    let HeaderInfos = "Tipo de operação,Valor da operação,Data de criação,Data de edição\r\n";
    await fs.appendFileSync(file, HeaderInfos);

    const createDataToCVS = new Array();

    ObjectMountedToCSV.results.forEach((element: any) => {
      createDataToCVS.push(
        {
          'Tipo de operação': element.typeOperation,
          'Valor da operação': element.valueOperation,
          Criado: element.createdAt,
          Editado: element.updatedAt
        }
      );
    });
    const reportCSV = new ObjectsToCsv(createDataToCVS);
    await reportCSV.toDisk(file, { append: true });
  }

}