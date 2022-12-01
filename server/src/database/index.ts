import { dataSource } from './data-source'

// inicia a comunicação com banco de dados
dataSource.initialize().then(async () => {
    console.log('Start database')
}).catch((error) => {
    console.log(error)
})

