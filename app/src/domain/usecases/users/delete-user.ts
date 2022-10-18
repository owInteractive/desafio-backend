export interface DeleteUser {
  delete(params: DeleteUser.Params): Promise<void>
}

export namespace DeleteUser {
  export type Params = { userId: string | number }
}
