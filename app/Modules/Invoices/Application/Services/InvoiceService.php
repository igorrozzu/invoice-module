<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Services;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Domain\Mappers\ApprovalMapper;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class InvoiceService
 *
 */
class InvoiceService implements InvoiceInterface
{
    /**
     * @param InvoiceRepositoryInterface $invoiceRepository
     * @param ApprovalFacadeInterface $approvalFacade
     * @param ApprovalMapper $approvalMapper
     */
    public function __construct(
        protected InvoiceRepositoryInterface $invoiceRepository,
        protected ApprovalFacadeInterface $approvalFacade,
        protected ApprovalMapper $approvalMapper,
    )
    {
    }

    /**
     * @param string $id
     * @throws ModelNotFoundException
     * @return Invoice
     */
    public function getByIdWithRelations(string $id): Invoice
    {
        return $this->invoiceRepository->getByIdWithRelations($id);
    }

    /**
     * @param string $id
     * @throws ModelNotFoundException
     * @return Invoice
     */
    public function getById(string $id): Invoice
    {
        return $this->invoiceRepository->getById($id);
    }

    /**
     * @param string $id
     * @throws ModelNotFoundException
     * @throws \LogicException
     */
    public function approve(string $id): void
    {
        $invoice = $this->getById($id);
        $dto = $this->approvalMapper->fromInvoice($invoice);
        $this->approvalFacade->approve($dto);
        $this->invoiceRepository->updateStatus($invoice,StatusEnum::APPROVED);
    }

    /**
     * @param string $id
     * @throws ModelNotFoundException
     * @throws \LogicException
     */
    public function reject(string $id): void
    {
        $invoice = $this->getById($id);
        $dto = $this->approvalMapper->fromInvoice($invoice);
        $this->approvalFacade->reject($dto);
        $this->invoiceRepository->updateStatus($invoice,StatusEnum::REJECTED);
    }
}
