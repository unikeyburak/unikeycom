<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface DealerRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get active dealers
     */
    public function getActiveDealers(int $perPage = 15): LengthAwarePaginator;

    /**
     * Get dealers by city
     */
    public function getByCity(string $city, int $perPage = 15): LengthAwarePaginator;

    /**
     * Search dealers
     */
    public function searchDealers(string $query, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get distinct cities
     */
    public function getDistinctCities(): Collection;

    /**
     * Get pending dealers
     */
    public function getPendingDealers(): Collection;

    /**
     * Find dealer by tax number
     */
    public function findByTaxNumber(string $taxNumber): ?object;

    /**
     * Find dealer by email
     */
    public function findByEmail(string $email): ?object;
}