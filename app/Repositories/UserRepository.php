<?php 

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class UserRepository implements CrudInterface
{
    
    public function getAll(int $perPage = 10):Paginator
    {
        return User::paginate($perPage);
    }
    public function getById(int $id):User
    {
        return User::findOrFail($id);
    }
    public function create(array $data):User
    {
        return User::create($data);
    }
}