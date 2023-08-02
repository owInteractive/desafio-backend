<?php 
namespace App\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;

Interface CrudInterface{

    public function getAll(): Paginator;
    public function getById(int $id): object|null;
    public function create(array $id): object|null;

}