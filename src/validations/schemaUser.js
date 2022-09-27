const yup = require('./config');

const schemaCreateUser = yup.object().shape({
    name: yup.string().required(),
    email: yup.string().email().required(),
    birthday: yup.date().required()
});

const schemaUpdateOpeningBalance = yup.object().shape({
    opening_balance: yup.number().integer().required()
});



module.exports = {
    schemaCreateUser,
    schemaUpdateOpeningBalance
};