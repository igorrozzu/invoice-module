<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\Invoice;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class InvoiceRepositoryInterface
 *
 */
interface InvoiceRepositoryInterface
{
    /**
     * @param string $id
     * @throws ModelNotFoundException
     * @return Invoice
     */
    public function getByIdWithRelations(string $id): Invoice;

    /**
     * @param string $id
     * @throws ModelNotFoundException
     * @return Invoice
     */
    public function getById(string $id): Invoice;

    /**
     * @param Invoice $invoice
     * @param StatusEnum $status
     * @return void
     */
    public function updateStatus(Invoice $invoice, StatusEnum $status): void;
}
