<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\DTO;

use App\Modules\Invoices\Domain\Models\Company as CompanyModel;

readonly class BilledCompany extends Company
{
    public function __construct(
        string $name,
        string $streetAddress,
        string $city,
        string $zipCode,
        string $phone,
        public string $emailAddress
    ) {
        parent::__construct($name, $streetAddress, $city, $zipCode, $phone);
    }

    public static function fromModel(CompanyModel $company): self
    {
        return new static(
            $company->name,
            $company->street,
            $company->city,
            $company->zip,
            $company->phone,
            $company->email
        );
    }
}
