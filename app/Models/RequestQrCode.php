<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestQrCode extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = [
        'qr_code',
        'retreat_request_id',
        'is_read',
    ];

    public function retreatRequest()
    {
        return $this->belongsTo(RetreatRequest::class);
    }
}
