<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockTest extends Model
{
    protected $fillable = [
        'title',
        'type',
        'questions',
        'duration',
        'subject',
        'class_standard',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'questions' => 'array',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
