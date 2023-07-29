<?php

// ~\courier-backend\app\Models\Courier.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'DOB',
        'phone',
        'status',
        'DOJ',
        'level',
        'branch_id',
    ];
}
