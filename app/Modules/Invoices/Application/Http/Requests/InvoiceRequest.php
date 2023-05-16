<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class InvoiceRequest
 *
 * @property string $id
 */
class InvoiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|uuid',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
