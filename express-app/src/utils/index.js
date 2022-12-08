// Util Functions


async function validEmail(email) {
    const is_valid = await /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email);
    if (is_valid) {
        return (true)
    }
    return (false)
}

async function exportCsvUserBalance(userObject, transactionsObject) {
    let userHeader = Object.keys(userObject);
    userHeader = '"' + userHeader.join('","') + '"' + "\r";
    let userValues = Object.values(userObject);
    userValues = '"' + userValues.join('","') + '"' + "\n\r";

    let transactionHeader = [
        "id",
        "operation_type",
        "amount",
        "short_date",
        "comment",
        "deleted",
        "createdAt",
        "updatedAt",
        "userID"];
    transactionHeader = '"' + transactionHeader.join('","') + '"' + "\r";
    let transactionValues = "";
    transactionsObject.forEach(element => {
        transactionValues += '"' + [
            element.id,
            element.operation_type,
            element.amount,
            element.short_date,
            element.comment,
            element.deleted,
            element.createdAt,
            element.updatedAt,
            element.user_id,
        ].join('","') + '"' + "\r";
    });
    return "User Info: \r" + userHeader + userValues + "Transactions Info:" + "\r" + transactionHeader + transactionValues + "\r\n";
}

function getAge(dateIsoString) {
    const today = new Date();
    const birthDate = new Date(dateIsoString);
    let age = today.getFullYear() - birthDate.getFullYear();
    const m = today.getMonth() - birthDate.getMonth();

    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    return age;
}

const utils = {
    validEmail,
    exportCsvUserBalance,
    getAge
}

module.exports = utils;
