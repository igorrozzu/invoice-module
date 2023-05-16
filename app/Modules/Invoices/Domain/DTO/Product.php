<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\DTO;

use App\Modules\Invoices\Domain\Models\InvoiceProductLine as InvoiceProductLineModel;

readonly class Product
{
    public function __construct(
        public string $name,
        public int $quantity,
        public int $unitPrice,
        public int $total,
    ) {}

    public static function fromModel(InvoiceProductLineModel $productLine): self
    {
        return new static(
            $productLine->product->name,
            $productLine->quantity,
            $productLine->product->price,
            $productLine->quantity * $productLine->product->price
        );
    }
}
