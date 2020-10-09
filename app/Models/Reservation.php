<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Package;

class Reservation extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','upadted_at'];

    //Each Reservation belongs to a single User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Each Reservation belongs to a single Package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
