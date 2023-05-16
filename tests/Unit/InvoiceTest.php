<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Application\Services\InvoiceInterface;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    private const TEST_UUID = '7caa3f30-787d-4b65-ba75-791f5dd895e1';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutEvents();
    }

    /**
     * @return void
     */
    public function testInvoiceApproval()
    {
        $invoice = new Invoice(['id' => self::TEST_UUID, 'status' => StatusEnum::DRAFT]);

        $this->mock(InvoiceRepositoryInterface::class, function (MockInterface $mock) use ($invoice) {
            $mock->shouldReceive('getById')->withArgs([self::TEST_UUID])->andReturn($invoice)->once();
            $mock->shouldReceive('updateStatus')->withArgs([$invoice, StatusEnum::APPROVED])->once();
        });

        $service = $this->getService();
        $service->approve(self::TEST_UUID);
    }

    public function testInvoiceRejection()
    {
        $invoice = new Invoice(['id' => self::TEST_UUID, 'status' => StatusEnum::DRAFT]);

        $this->mock(InvoiceRepositoryInterface::class, function (MockInterface $mock) use ($invoice) {
            $mock->shouldReceive('getById')->withArgs([self::TEST_UUID])->andReturn($invoice)->once();
            $mock->shouldReceive('updateStatus')->withArgs([$invoice, StatusEnum::REJECTED])->once();
        });

        $service = $this->getService();
        $service->reject(self::TEST_UUID);
    }

    public function testDoubleInvoiceApproval()
    {
        $invoice1 = new Invoice(['id' => self::TEST_UUID, 'status' => StatusEnum::DRAFT]);
        $invoice2 = new Invoice(['id' => self::TEST_UUID, 'status' => StatusEnum::APPROVED]);

        $this->mock(InvoiceRepositoryInterface::class, function (MockInterface $mock) use ($invoice1, $invoice2) {
            $mock->shouldReceive('getById')->withArgs([self::TEST_UUID])->andReturns($invoice1, $invoice2)->twice();
            $mock->shouldReceive('updateStatus')->withArgs([$invoice1, StatusEnum::APPROVED])->once();
        });
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('approval status is already assigned');

        $service = $this->getService();
        $service->approve(self::TEST_UUID);
        $service->approve(self::TEST_UUID);
    }

    public function testDoubleInvoiceRejection()
    {
        $invoice1 = new Invoice(['id' => self::TEST_UUID, 'status' => StatusEnum::DRAFT]);
        $invoice2 = new Invoice(['id' => self::TEST_UUID, 'status' => StatusEnum::REJECTED]);

        $this->mock(InvoiceRepositoryInterface::class, function (MockInterface $mock) use ($invoice1, $invoice2) {
            $mock->shouldReceive('getById')->withArgs([self::TEST_UUID])->andReturns($invoice1, $invoice2)->twice();
            $mock->shouldReceive('updateStatus')->withArgs([$invoice1, StatusEnum::REJECTED])->once();
        });
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('approval status is already assigned');

        $service = $this->getService();
        $service->reject(self::TEST_UUID);
        $service->reject(self::TEST_UUID);
    }

    public function testInvoiceApprovalAfterRejection()
    {
        $invoice = new Invoice(['id' => self::TEST_UUID, 'status' => StatusEnum::REJECTED]);

        $this->mock(InvoiceRepositoryInterface::class, function (MockInterface $mock) use ($invoice) {
            $mock->shouldReceive('getById')->withArgs([self::TEST_UUID])->andReturns($invoice)->once();
            $mock->shouldReceive('updateStatus')->never();
        });
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('approval status is already assigned');

        $service = $this->getService();
        $service->approve(self::TEST_UUID);
    }

    public function testInvoiceRejectionAfterApproval()
    {
        $invoice = new Invoice(['id' => self::TEST_UUID, 'status' => StatusEnum::APPROVED]);

        $this->mock(InvoiceRepositoryInterface::class, function (MockInterface $mock) use ($invoice) {
            $mock->shouldReceive('getById')->withArgs([self::TEST_UUID])->andReturns($invoice)->once();
            $mock->shouldReceive('updateStatus')->never();
        });
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('approval status is already assigned');

        $service = $this->getService();
        $service->reject(self::TEST_UUID);
    }

    /**
     * @return InvoiceInterface
     */
    private function getService(): InvoiceInterface
    {
        return app(InvoiceInterface::class);
    }
}
