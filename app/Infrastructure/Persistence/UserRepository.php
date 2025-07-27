<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function all(array $columns, int $page, int $size): LengthAwarePaginator
    {
        return User::paginate($size, $columns, 'page', $page);
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user): bool
    {
        return $user->save();
    }

    public function delete(int $id): bool
    {
        return User::destroy($id);
    }

    public function findByName(string $name): ?User
    {
        return User::where('name', $name)->first();
    }

    public function findByUuid(string $uuid): ?User
    {
        return User::where('uuid', $uuid)->first();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByFilters(array $filters, int $page, int $size): LengthAwarePaginator
    {
        $query = User::query();

        if (!empty($filters['name'])) {
            $query->whereRaw("name LIKE ?", ['%' . $filters['name'] . '%']);
            unset($filters['name']);
        }

        if (!empty($filters['email'])) {
            $query->whereRaw("slug LIKE ?", ['%' . $filters['email'] . '%']);
            unset($filters['email']);
        }

        return $query->paginate($size, ['*'], 'page', $page);
    }
}
