<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerApplication extends Model
{
    protected $fillable = [
        'user_id',
        'shop_name',
        'whatsapp_number',
        'ktp_image_path',
        'ktp_nik',
        'ktp_name',
        'ktp_dob',
        'ktp_address',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
