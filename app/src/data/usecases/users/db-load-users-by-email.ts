import {  LoadUsersByEmailRepository } from '@/data/protocols/database/users';
import {  LoadUsersByEmail } from '@/domain/usecases/users';

export class DbLoadUsersByEmail implements LoadUsersByEmail {
    constructor(
        private readonly loadUsersByEmailRepository: LoadUsersByEmailRepository,
    ) {}
    async loadByEmail(params: LoadUsersByEmail.Params): Promise<LoadUsersByEmail.Result> {
        return this.loadUsersByEmailRepository.loadByEmail(params);
    }
}