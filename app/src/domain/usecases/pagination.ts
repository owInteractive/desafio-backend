export type GetPaginatedParams = {
  page: number;
  perPage: number;
}

export type Paginated<T> = {
  data: T[];
  pagination: {
    page: number;
    perPage: number;
    total: number;
    totalPages: number;
  }
}