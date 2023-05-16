<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Services;

use App\Modules\Invoices\Domain\Models\Invoice;

/**
 *
 */
interface InvoiceInterface
{
    /**
     * @param string $id
     * @return Invoice|null
     */
    public function getById(string $id): ?Invoice;

    /**
     * @param string $id
     * @return Invoice
     */
    public function getByIdWithRelations(string $id): Invoice;

    /**
     * @param string $id
     * @return void
     */
    public function approve(string $id): void;

    /**
     * @param string $id
     * @return void
     */
    public function reject(string $id): void;
}
