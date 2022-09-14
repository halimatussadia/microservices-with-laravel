<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const ACTIVE   = 'active';
    public const INACTIVE = 'inactive';


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function getImageAttribute($value)
    {
        if($value){
            return Storage::url('/product/'.$value);
        }
        return null;
    }
}
