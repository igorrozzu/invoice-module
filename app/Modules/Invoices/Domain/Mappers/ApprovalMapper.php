<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Mappers;

use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Domain\Models\Invoice;
use Ramsey\Uuid\Uuid;

class ApprovalMapper
{
    public function fromInvoice(Invoice $invoice): ApprovalDto
    {
        return new ApprovalDto(Uuid::fromString($invoice->id), $invoice->status, $invoice::class);
    }
}
