<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'start_time', 'end_time'];

    protected $dates = ['start_time', 'end_time'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->start_time)->format('d/m/y');
    }
}
