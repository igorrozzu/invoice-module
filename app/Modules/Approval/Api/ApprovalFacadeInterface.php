<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api;

use App\Modules\Approval\Api\Dto\ApprovalDto;

interface ApprovalFacadeInterface
{
    public function approve(ApprovalDto $dto): true;

    public function reject(ApprovalDto $dto): true;
}
