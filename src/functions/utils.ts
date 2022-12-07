export default class Utils {

  formatNumber(number:any){
    return number.autoIncrement ? ((number.format + (Number(number.number) + 1)).slice(-number.format.length)) : ((number.format + (Number(number.number))).slice(number.format.length));
  }
  
  formatDateMonthYear(date:any) {
    if(date !== 'last' && date !== 'all'){
      const month = date.toString().slice(0, 2);
      const year = date.toString().slice(3, 8);
      const dateFormated = `${year}-${month}`;
      console.log(dateFormated);      
      return dateFormated;
    }
  }
  
  formatDate(date:any) {
    let dArr = date.split("-");
    const formatedDate = dArr[2] + "/" + dArr[1] + "/" + dArr[0].substring(0, 4);
    return formatedDate;
  }

  
  formatMoney(valor:any) {
    return Number(valor.replace(/[^0-9\.]+/g, ""));
  }
  
  userAge(dtBirth:any) {
    let currentDate = new Date();
    let currentYear = currentDate.getFullYear();
    let yearNascParts = dtBirth.split('-');
    let yearNasc = yearNascParts[0];
    let monthNasc = yearNascParts[1];
    let dayNasc = yearNascParts[2];
    let age = currentYear - yearNasc;
    let currentMonth = currentDate.getMonth() + 1;
    if (currentMonth < monthNasc) {
      age--;
    } else {
      if (currentMonth == monthNasc) {
        if (new Date().getDate() < dayNasc) {
          age--;
        }
      }
    }
    return age;
  }
  
}