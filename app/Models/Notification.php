<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'notifiable_id',
        'notifiable_type',
        'data',
        'read_at',
    ];
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'id' => 'string',
    ];
    public function notifiable()
    {
        return $this->morphTo();
    }
    public function getIsReadAttribute()
    {
        return $this->read_at != null;
    }
    public function scopeFilter($query)
    {
        if (request()->has('sort')) {
            $query->orderBy(request()->sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        return $query;
    }
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }
}
