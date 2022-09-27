const yup = require('./config');

const schemaCreateTransaction = yup.object().shape({
    type: yup.string().required(),
    amount: yup.number().integer().required(),
    description: yup.string()
});

module.exports = {
    schemaCreateTransaction,
};