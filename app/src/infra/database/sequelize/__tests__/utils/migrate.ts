import { sequelizeConnection } from '../../helpers';

export function migrate() {
    return sequelizeConnection.sync({ force: true })
  }
  