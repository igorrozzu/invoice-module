<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\Invoice;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class InvoiceRepository
 *
 */
class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * @param Invoice $invoice
     */
    public function __construct(private readonly Invoice $invoice)
    {
    }

    /**
     * @param string $id
     * @throws ModelNotFoundException
     * @return Invoice
     */
    public function getByIdWithRelations(string $id): Invoice
    {
        return $this->query()->with(['company', 'billedCompany', 'productLines.product'])->findOrFail($id);
    }

    /**
     * @param string $id
     * @throws ModelNotFoundException
     * @return Invoice
     */
    public function getById(string $id): Invoice
    {
        return $this->query()->findOrFail($id);
    }

    public function updateStatus(Invoice $invoice, StatusEnum $status): void
    {
        $invoice->status = $status;
        $invoice->save();
    }

    private function query(): Builder
    {
        return $this->invoice->newQuery();
    }
}
