<?php

declare(strict_types=1);

namespace App\Modules\Product\Infraestructure\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    /**
     *  @var string
     * */
    protected $table = 'products';
    /**
     *  @var string
     * */
    protected $primaryKey = 'uuid';
    /**
     *  @var bool
     * */
    public $incrementing = false;
    /**
     *  @var string
     * */
    protected $keyType = 'string';
    /**
     *  @var array<int, string>
     * */
    protected $fillable = [
        'uuid',
        'sku',
        'name',
        'description',
        'price',
        'category',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
