// Parsing .env file
require('dotenv').config();

// Interface to load env variables
interface Config {
    PORT: number;
    DB_HOST: string;
    DB_USER: string;
    DB_PASS: string;
    DB_NAME: string;
}

const getConfig = (): Config => {
    const parsed = process.env;
    return {
        PORT: parsed.PORT ? parseInt(parsed.PORT) : undefined,
        DB_HOST: parsed.DB_HOST,
        DB_USER: parsed.DB_USER,
        DB_PASS: parsed.DB_PASSWORD,
        DB_NAME: parsed.DB_NAME,
    };
}


// Throw error if any env variable is missing or invalid
const getSanitzedConfig = (config: Config): Config => {
    for (const [key, value] of Object.entries(config)) {
        if (value === undefined) {
            throw new Error(`Missing key ${key} in config.env`);
        }
    }
    return config as Config;
};

const config = getConfig();

const sanitizedConfig = getSanitzedConfig(config);

export default sanitizedConfig;