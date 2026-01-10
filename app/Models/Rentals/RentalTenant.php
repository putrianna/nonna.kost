<?php

namespace App\Models\Rentals;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalTenant extends Model
{
    use SoftDeletes;
}
