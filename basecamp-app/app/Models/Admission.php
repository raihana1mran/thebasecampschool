<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'user_id',
        'course_type',
        'status',
        'full_name',
        'father_name',
        'mother_name',
        'gender',
        'date_of_birth',
        'aadhaar_number',
        'address',
        'previous_qualification',
        'mobile_number',
        'email',
        'documents',
        'payment_id',
        'reference_number',
    ];

    protected function casts(): array
    {
        return [
            'documents' => 'array',
            'date_of_birth' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
