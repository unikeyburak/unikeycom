<?php

namespace App\Repositories;

use App\Models\Dealer;
use App\Contracts\DealerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DealerRepository extends BaseRepository implements DealerRepositoryInterface
{
    /**
     * Constructor
     */
    public function __construct(Dealer $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active dealers
     */
    public function getActiveDealers(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('status', 'active')
            ->orderBy('company_name')
            ->paginate($perPage);
    }

    /**
     * Get dealers by city
     */
    public function getByCity(string $city, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('status', 'active')
            ->where('city', $city)
            ->orderBy('company_name')
            ->paginate($perPage);
    }

    /**
     * Search dealers
     */
    public function searchDealers(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('company_name', 'like', "%{$query}%")
                  ->orWhere('city', 'like', "%{$query}%")
                  ->orWhere('district', 'like', "%{$query}%")
                  ->orWhere('address', 'like', "%{$query}%");
            })
            ->orderBy('company_name')
            ->paginate($perPage);
    }

    /**
     * Get distinct cities
     */
    public function getDistinctCities(): Collection
    {
        return $this->model
            ->where('status', 'active')
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');
    }

    /**
     * Get pending dealers
     */
    public function getPendingDealers(): Collection
    {
        return $this->model
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Find dealer by tax number
     */
    public function findByTaxNumber(string $taxNumber): ?object
    {
        return $this->model
            ->where('tax_number', $taxNumber)
            ->first();
    }

    /**
     * Find dealer by email
     */
    public function findByEmail(string $email): ?object
    {
        return $this->model
            ->where('email', $email)
            ->first();
    }
}