<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Model instance
     */
    protected Model $model;

    /**
     * Constructor
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Get all records with pagination
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }

    /**
     * Find record by ID
     */
    public function find(int $id, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->with($relations)->find($id, $columns);
    }

    /**
     * Find record by ID or fail
     */
    public function findOrFail(int $id, array $columns = ['*'], array $relations = []): Model
    {
        return $this->model->with($relations)->findOrFail($id, $columns);
    }

    /**
     * Find record by attributes
     */
    public function findBy(array $attributes, array $columns = ['*'], array $relations = []): ?Model
    {
        $query = $this->model->with($relations);
        
        foreach ($attributes as $field => $value) {
            $query->where($field, $value);
        }
        
        return $query->first($columns);
    }

    /**
     * Find records by attributes
     */
    public function findManyBy(array $attributes, array $columns = ['*'], array $relations = []): Collection
    {
        $query = $this->model->with($relations);
        
        foreach ($attributes as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }
        
        return $query->get($columns);
    }

    /**
     * Create new record
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * Update record by ID
     */
    public function update(int $id, array $attributes): bool
    {
        $record = $this->find($id);
        
        if (!$record) {
            return false;
        }
        
        return $record->update($attributes);
    }

    /**
     * Delete record by ID
     */
    public function delete(int $id): bool
    {
        $record = $this->find($id);
        
        if (!$record) {
            return false;
        }
        
        return $record->delete();
    }

    /**
     * Count records
     */
    public function count(array $criteria = []): int
    {
        $query = $this->model->query();
        
        foreach ($criteria as $field => $value) {
            $query->where($field, $value);
        }
        
        return $query->count();
    }

    /**
     * Check if record exists
     */
    public function exists(array $criteria): bool
    {
        $query = $this->model->query();
        
        foreach ($criteria as $field => $value) {
            $query->where($field, $value);
        }
        
        return $query->exists();
    }

    /**
     * Get query builder
     */
    public function query()
    {
        return $this->model->query();
    }

    /**
     * Begin database transaction
     */
    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    /**
     * Commit database transaction
     */
    public function commit(): void
    {
        DB::commit();
    }

    /**
     * Rollback database transaction
     */
    public function rollback(): void
    {
        DB::rollBack();
    }
}