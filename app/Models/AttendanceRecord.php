<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in' => 'datetime:H:i:s',
        'check_out' => 'datetime:H:i:s',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function hoursWorked(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->attendance_date || !$this->check_in || !$this->check_out) {
                return 0.0;
            }

            $start = $this->attendance_date->copy()->setTimeFrom($this->check_in);
            $end = $this->attendance_date->copy()->setTimeFrom($this->check_out);

            if ($end->lessThanOrEqualTo($start)) {
                $end = $end->addDay();
            }

            return round($start->floatDiffInHours($end), 2);
        });
    }
}
