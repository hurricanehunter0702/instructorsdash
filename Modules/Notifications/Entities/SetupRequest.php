<?php

namespace Modules\Notifications\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class SetupRequest extends Model
{
    protected $fillable = [
        "user_id",
        "amount",
        "payment_method"
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
