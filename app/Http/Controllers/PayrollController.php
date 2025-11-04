<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $payrolls = Payroll::with('employee')
            ->when($request->integer('employee_id'), fn ($query, $employeeId) => $query->where('employee_id', $employeeId))
            ->when($request->date('period_start'), fn ($query, $start) => $query->whereDate('period_start', '>=', $start))
            ->when($request->date('period_end'), fn ($query, $end) => $query->whereDate('period_end', '<=', $end))
            ->orderByDesc('period_end')
            ->orderBy('employee_id')
            ->paginate(10)
            ->withQueryString();

        $employees = Employee::orderBy('last_name')->orderBy('first_name')->get();

        return view('payrolls.index', [
            'payrolls' => $payrolls,
            'employees' => $employees,
            'filters' => $request->only(['employee_id', 'period_start', 'period_end']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $employees = Employee::orderBy('last_name')->orderBy('first_name')->get();

        $defaultStart = Carbon::now()->startOfMonth()->toDateString();
        $defaultEnd = Carbon::now()->endOfMonth()->toDateString();

        return view('payrolls.create', [
            'employees' => $employees,
            'defaultStart' => $defaultStart,
            'defaultEnd' => $defaultEnd,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
            'deductions' => ['nullable', 'numeric', 'min:0'],
        ]);

        $employee = Employee::findOrFail($validated['employee_id']);
        $periodStart = Carbon::parse($validated['period_start'])->startOfDay();
        $periodEnd = Carbon::parse($validated['period_end'])->endOfDay();

        $attendanceRecords = AttendanceRecord::where('employee_id', $employee->id)
            ->whereBetween('attendance_date', [$periodStart->toDateString(), $periodEnd->toDateString()])
            ->where('status', 'present')
            ->get();

        $hoursWorked = $attendanceRecords->sum(fn (AttendanceRecord $record) => $record->hours_worked);
        $grossPay = round($hoursWorked * (float) $employee->hourly_rate, 2);
        $deductions = isset($validated['deductions']) ? (float) $validated['deductions'] : 0.0;
        $netPay = max($grossPay - $deductions, 0);

        Payroll::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'period_start' => $periodStart->toDateString(),
                'period_end' => $periodEnd->toDateString(),
            ],
            [
                'hours_worked' => $hoursWorked,
                'gross_pay' => $grossPay,
                'deductions' => $deductions,
                'net_pay' => $netPay,
            ]
        );

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Payroll generated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll): RedirectResponse
    {
        $payroll->delete();

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Payroll deleted successfully.');
    }
}
