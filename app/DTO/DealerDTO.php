<?php

namespace App\DTO;

use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $companyName,
        public readonly string $taxNumber,
        public readonly string $taxOffice,
        public readonly string $phone,
        public readonly string $email,
        public readonly ?string $website,
        public readonly string $address,
        public readonly string $city,
        public readonly string $district,
        public readonly ?string $postalCode,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly ?string $logo,
        public readonly ?string $about,
        public readonly ?array $workingHours,
        public readonly ?array $socialMedia,
        public readonly string $status = 'pending'
    ) {}

    /**
     * Create DTO from Request
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id'),
            companyName: $request->input('company_name'),
            taxNumber: $request->input('tax_number'),
            taxOffice: $request->input('tax_office'),
            phone: $request->input('phone'),
            email: $request->input('email'),
            website: $request->input('website'),
            address: $request->input('address'),
            city: $request->input('city'),
            district: $request->input('district'),
            postalCode: $request->input('postal_code'),
            latitude: $request->input('latitude'),
            longitude: $request->input('longitude'),
            logo: $request->input('logo'),
            about: $request->input('about'),
            workingHours: $request->input('working_hours', []),
            socialMedia: $request->input('social_media', []),
            status: $request->input('status', 'pending')
        );
    }

    /**
     * Create DTO from Model
     */
    public static function fromModel(Dealer $dealer): self
    {
        return new self(
            id: $dealer->id,
            companyName: $dealer->company_name,
            taxNumber: $dealer->tax_number,
            taxOffice: $dealer->tax_office,
            phone: $dealer->phone,
            email: $dealer->email,
            website: $dealer->website,
            address: $dealer->address,
            city: $dealer->city,
            district: $dealer->district,
            postalCode: $dealer->postal_code,
            latitude: $dealer->latitude,
            longitude: $dealer->longitude,
            logo: $dealer->logo,
            about: $dealer->about,
            workingHours: $dealer->working_hours,
            socialMedia: $dealer->social_media,
            status: $dealer->status
        );
    }

    /**
     * Convert to array for database
     */
    public function toArray(): array
    {
        $data = [
            'company_name' => $this->companyName,
            'tax_number' => $this->taxNumber,
            'tax_office' => $this->taxOffice,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'address' => $this->address,
            'city' => $this->city,
            'district' => $this->district,
            'postal_code' => $this->postalCode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'logo' => $this->logo,
            'about' => $this->about,
            'working_hours' => $this->workingHours ? json_encode($this->workingHours) : null,
            'social_media' => $this->socialMedia ? json_encode($this->socialMedia) : null,
            'status' => $this->status,
        ];

        if ($this->id) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}