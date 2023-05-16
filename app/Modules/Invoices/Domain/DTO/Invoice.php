<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\DTO;

use App\Modules\Invoices\Domain\Models\Invoice as InvoiceModel;
use App\Modules\Invoices\Domain\Models\InvoiceProductLine;
use Illuminate\Support\Collection;

readonly class Invoice
{
    public function __construct(
        public string $invoiceNumber,
        public string $invoiceDate,
        public string $dueDate,
        public Company $company,
        public Company $billedCompany,
        /**@var Collection<Product> */
        public Collection $products,
        public int $totalPrice,
    ) {}

    public static function fromModel(InvoiceModel $invoice): self
    {
        /**@var Collection $productLines */
        $productLines = $invoice->productLines->map(fn(InvoiceProductLine $line) => Product::fromModel($line));
        $totalPrice = $productLines->reduce(fn(float $total, Product $product) => $total + $product->total, 0);
        return new static(
            $invoice->number,
            (string) $invoice->date,
            (string) $invoice->due_date,
            Company::fromModel($invoice->company),
            BilledCompany::fromModel($invoice->billedCompany),
            $invoice->productLines->map(fn(InvoiceProductLine $line) => Product::fromModel($line)),
            (int) $totalPrice
        );
    }
}
