<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Product extends Model {
    use Notifiable;

    protected $table = 'products';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'stripe_product_id', 'stripe_price_id', 'name', 'price', 'description' ,
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}