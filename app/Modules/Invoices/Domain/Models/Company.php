<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * Class Company
 *
 * @property string $id;
 * @property string $name;
 * @property string $street;
 * @property string $city;
 * @property string $zip;
 * @property string $phone;
 * @property string $email;
 * @property Carbon|null $created_at;
 * @property Carbon|null $updated_at;
 *
 */
class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
}
