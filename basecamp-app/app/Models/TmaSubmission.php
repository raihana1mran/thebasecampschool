<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TmaSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'file_path',
        'original_filename',
        'tma_marks',
        'practical_marks',
        'admin_remarks',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'tma_marks'    => 'integer',
        'practical_marks' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
