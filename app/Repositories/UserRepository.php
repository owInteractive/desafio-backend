<?php 

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class UserRepository implements CrudInterface
{
    
    public function getAll(?int $perPage = 50):Paginator
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
    public function desc()
    {
        return User::paginate(50)->sortBy([['created_at', 'desc']]);
    }
}