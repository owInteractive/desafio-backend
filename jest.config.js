/** @type {import('ts-jest').JestConfigWithTsJest} */
module.exports = {
  moduleFileExtensions: ["js", "jsx", "ts", "tsx", "json", "node"],
  preset: 'ts-jest',
  testEnvironment: 'node',
  roots: ["<rootDir>/src"],
  testTimeout: 20000
};