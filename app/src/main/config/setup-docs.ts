import express, { Express } from 'express'
import { resolve } from 'path'

export function setupDocs(app: Express): void {
  app.use('/', express.static(resolve(__dirname, '../docs/html/')))
}
