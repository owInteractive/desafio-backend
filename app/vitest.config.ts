import { defineConfig } from 'vitest/config'
import tsconfigPaths from 'vitest-tsconfig-paths'

export default defineConfig({
    test: {
        coverage: {
            include: ['src/**/*.ts'],
            provider: 'istanbul'
        }
    },
    plugins: [tsconfigPaths()],
})
