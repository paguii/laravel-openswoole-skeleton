<?php

namespace App\Domain\Repositories;


use App\Domain\Entities\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * Retrieve all users with pagination.
     * 
     * @param array $columns
     * @param int $page
     * @param int $size
     * 
     * @return LengthAwarePaginator
     */
    public function all(array $columns, int $page, int $size): LengthAwarePaginator;

    /**
     * Find a user by their ID
     * 
     * @param int $id
     * 
     * @return User|null
     */
    public function find(int $id): ?User;

    /**
     * Find a user by their name
     * 
     * @param string $name
     * 
     * @return User|null
     */
    public function findByName(string $name): ?User;

    /**
     * Find a user by their UUID
     * 
     * @param string $uuid
     * 
     * @return User|null
     */
    public function findByUuid(string $uuid): ?User;

    /**
     * Find a user by their email
     * 
     * @param string $email
     * 
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find users by various filters with pagination.
     * 
     * @param array $filters
     * @param int $page
     * @param int $size
     * 
     * @return LengthAwarePaginator
     */
    public function findByFilters(array $filters, int $page, int $size): LengthAwarePaginator;

    /**
     * Create a new user.
     * 
     * @param array $data
     * 
     * @return User
     */
    public function create(array $data): User;

    /**
     * Update an existing user.
     * 
     * @param User $user
     * 
     * @return bool
     */
    public function update(User $user): bool;

    /**
     * Delete a user by their ID.
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function delete(int $id): bool;
}
