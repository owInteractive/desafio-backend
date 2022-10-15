import { defineConfig } from 'vitest/config'
import tsconfigPaths from 'vitest-tsconfig-paths'

export default defineConfig({
    test: {},
    plugins: [tsconfigPaths()],
})
