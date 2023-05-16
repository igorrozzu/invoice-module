<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\DTO;

use App\Modules\Invoices\Domain\Models\Company as CompanyModel;

readonly class Company
{
    public function __construct(
        public string $name,
        public string $streetAddress,
        public string $city,
        public string $zipCode,
        public string $phone
    ) {}

    public static function fromModel(CompanyModel $company): self
    {
        return new static(
            $company->name,
            $company->street,
            $company->city,
            $company->zip,
            $company->phone
        );
    }
}
