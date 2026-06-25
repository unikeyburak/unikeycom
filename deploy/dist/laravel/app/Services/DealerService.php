<?php

namespace App\Services;

use App\Contracts\DealerRepositoryInterface;
use App\DTO\DealerDTO;
use App\Models\Dealer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class DealerService
{
    /**
     * Constructor
     */
    public function __construct(
        private DealerRepositoryInterface $dealerRepository
    ) {}

    /**
     * Get active dealers
     */
    public function getActiveDealers(int $perPage = 15, ?string $city = null, ?string $search = null): LengthAwarePaginator
    {
        // Şehir filtresi
        if ($city) {
            return $this->dealerRepository->getByCity($city, $perPage);
        }
        
        // Arama
        if ($search) {
            return $this->dealerRepository->searchDealers($search, $perPage);
        }
        
        // Tüm aktif bayiler
        return $this->dealerRepository->getActiveDealers($perPage);
    }

    /**
     * Get distinct cities
     */
    public function getCities(): Collection
    {
        return Cache::remember('dealer_cities', 3600, function () {
            return $this->dealerRepository->getDistinctCities();
        });
    }

    /**
     * Get dealer by ID
     */
    public function getDealerById(int $id): ?Dealer
    {
        return $this->dealerRepository->find($id);
    }

    /**
     * Create dealer application
     */
    public function createDealerApplication(DealerDTO $dto): Dealer
    {
        // Check if dealer already exists
        $existingDealer = $this->dealerRepository->findByTaxNumber($dto->taxNumber);
        if ($existingDealer) {
            throw new \Exception('Bu vergi numarası ile kayıtlı bir bayi bulunmaktadır.');
        }
        
        $existingDealer = $this->dealerRepository->findByEmail($dto->email);
        if ($existingDealer) {
            throw new \Exception('Bu e-posta adresi ile kayıtlı bir bayi bulunmaktadır.');
        }
        
        // Create dealer with pending status
        $dealerData = $dto->toArray();
        $dealerData['status'] = 'pending';
        
        $dealer = $this->dealerRepository->create($dealerData);
        
        // Clear cache
        Cache::forget('dealer_cities');
        
        return $dealer;
    }

    /**
     * Update dealer
     */
    public function updateDealer(int $id, DealerDTO $dto): bool
    {
        $result = $this->dealerRepository->update($id, $dto->toArray());
        
        if ($result) {
            // Clear cache
            Cache::forget('dealer_cities');
        }
        
        return $result;
    }

    /**
     * Approve dealer
     */
    public function approveDealer(int $id, int $approvedBy): bool
    {
        $result = $this->dealerRepository->update($id, [
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => $approvedBy
        ]);
        
        if ($result) {
            Cache::forget('dealer_cities');
        }
        
        return $result;
    }

    /**
     * Suspend dealer
     */
    public function suspendDealer(int $id, string $reason): bool
    {
        $result = $this->dealerRepository->update($id, [
            'status' => 'suspended',
            'suspension_reason' => $reason,
            'suspended_at' => now()
        ]);
        
        if ($result) {
            Cache::forget('dealer_cities');
        }
        
        return $result;
    }

    /**
     * Activate dealer
     */
    public function activateDealer(int $id): bool
    {
        $result = $this->dealerRepository->update($id, [
            'status' => 'active',
            'suspension_reason' => null,
            'suspended_at' => null
        ]);
        
        if ($result) {
            Cache::forget('dealer_cities');
        }
        
        return $result;
    }

    /**
     * Get pending dealers
     */
    public function getPendingDealers(): Collection
    {
        return $this->dealerRepository->getPendingDealers();
    }
}