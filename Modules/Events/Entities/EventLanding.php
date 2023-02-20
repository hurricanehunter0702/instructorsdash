<?php

namespace Modules\Events\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLanding extends Model
{
    use HasFactory;

    protected $table = 'calendar_setting';

    protected $dates = [
        'created_at',
        'updated_at',
    ];
  
    protected $fillable = [
        'user_id',
        'bg_color',
        'title',
        'description',
        'keywords'
    ];
}
