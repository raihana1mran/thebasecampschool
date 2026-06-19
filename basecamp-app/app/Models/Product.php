<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'category',
        'file_urls',
        'preview_url',
        'download_limit',
    ];

    protected function casts(): array
    {
        return [
            'file_urls' => 'array',
        ];
    }
}
