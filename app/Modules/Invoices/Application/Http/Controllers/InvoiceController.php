<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Http\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\Http\Requests\InvoiceRequest;
use App\Modules\Invoices\Application\Services\InvoiceInterface;
use App\Modules\Invoices\Domain\DTO\Invoice;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use LogicException;

class InvoiceController extends Controller
{
    public function __construct(private readonly InvoiceInterface $invoiceService)
    {
    }

    public function show(InvoiceRequest $request): JsonResponse
    {
        try {
            $invoice = $this->invoiceService->getByIdWithRelations($request->id);
        } catch (ModelNotFoundException) {
            return $this->notFound('Invoice is not found');
        }

        return response()->json(Invoice::fromModel($invoice));
    }

    public function approve(InvoiceRequest $request): JsonResponse
    {
        try {
            $this->invoiceService->approve($request->id);
        } catch (ModelNotFoundException) {
            return $this->notFound('Invoice is not found');
        } catch (LogicException $e) {
            return $this->badRequest($e->getMessage());
        }

        return response()->json();
    }

    public function reject(InvoiceRequest $request): JsonResponse
    {
        try {
            $this->invoiceService->reject($request->id);
        } catch (ModelNotFoundException) {
            return $this->notFound('Invoice is not found');
        } catch (LogicException $e) {
            return $this->badRequest($e->getMessage());
        }

        return response()->json();
    }

    private function notFound(string $message): JsonResponse
    {
        return response()->json(['error' => $message], Response::HTTP_NOT_FOUND);
    }

    private function badRequest(string $message): JsonResponse
    {
        return response()->json(['error' => $message], Response::HTTP_BAD_REQUEST);
    }
}
