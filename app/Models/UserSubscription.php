<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'subscription_id',
        'date_start',
        'date_end',
    ];
    
    public function user(){
        return $this->belongsTo(App\Models\User::class);
    }
    
    public function subscription(){
        return $this->belongsTo(App\Models\Subscription::class);
    }
    
}
