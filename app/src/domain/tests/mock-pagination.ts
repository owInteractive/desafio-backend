import { faker } from "@faker-js/faker";
import { Paginated } from "../usecases/pagination";

export function mockPagination<T>(data:T[]):Paginated<T> {
  return {
    data,
    pagination: {
      page: faker.datatype.number(),
      perPage: faker.datatype.number(),
      total: faker.datatype.number(),
      totalPages: faker.datatype.number(),
    }
  }
}