import { mergeConfig } from 'vite'
import { defineConfig } from 'vitest/config'
import vitestConfig from './vitest.config'

export default mergeConfig(vitestConfig, defineConfig({
    test: {
        include: ['src/**/*.spec.ts'],
    }
}))
