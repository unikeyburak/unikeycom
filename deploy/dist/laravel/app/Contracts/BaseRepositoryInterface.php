<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    /**
     * Get all records
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get all records with pagination
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    /**
     * Find record by ID
     */
    public function find(int $id, array $columns = ['*'], array $relations = []): ?Model;

    /**
     * Find record by ID or fail
     */
    public function findOrFail(int $id, array $columns = ['*'], array $relations = []): Model;

    /**
     * Find record by attributes
     */
    public function findBy(array $attributes, array $columns = ['*'], array $relations = []): ?Model;

    /**
     * Find records by attributes
     */
    public function findManyBy(array $attributes, array $columns = ['*'], array $relations = []): Collection;

    /**
     * Create new record
     */
    public function create(array $attributes): Model;

    /**
     * Update record by ID
     */
    public function update(int $id, array $attributes): bool;

    /**
     * Delete record by ID
     */
    public function delete(int $id): bool;

    /**
     * Count records
     */
    public function count(array $criteria = []): int;

    /**
     * Check if record exists
     */
    public function exists(array $criteria): bool;

    /**
     * Get query builder
     */
    public function query();

    /**
     * Begin database transaction
     */
    public function beginTransaction(): void;

    /**
     * Commit database transaction
     */
    public function commit(): void;

    /**
     * Rollback database transaction
     */
    public function rollback(): void;
}