<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttendanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $employees = Employee::orderBy('last_name')->orderBy('first_name')->get();

        $attendanceRecords = AttendanceRecord::with('employee')
            ->when($request->integer('employee_id'), function ($query, $employeeId) {
                $query->where('employee_id', $employeeId);
            })
            ->when($request->date('start_date'), function ($query, $startDate) {
                $query->whereDate('attendance_date', '>=', $startDate);
            })
            ->when($request->date('end_date'), function ($query, $endDate) {
                $query->whereDate('attendance_date', '<=', $endDate);
            })
            ->orderByDesc('attendance_date')
            ->orderBy('employee_id')
            ->paginate(10)
            ->withQueryString();

        return view('attendance_records.index', [
            'attendanceRecords' => $attendanceRecords,
            'employees' => $employees,
            'filters' => $request->only(['employee_id', 'start_date', 'end_date']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $employees = Employee::orderBy('last_name')->orderBy('first_name')->get();
        $attendanceRecord = new AttendanceRecord();

        return view('attendance_records.create', compact('employees', 'attendanceRecord'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules(null, $request));

        AttendanceRecord::create($data);

        return redirect()
            ->route('attendance-records.index')
            ->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceRecord $attendanceRecord): View
    {
        $employees = Employee::orderBy('last_name')->orderBy('first_name')->get();

        return view('attendance_records.edit', compact('attendanceRecord', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceRecord $attendanceRecord): RedirectResponse
    {
        $data = $request->validate($this->rules($attendanceRecord, $request));

        $attendanceRecord->update($data);

        return redirect()
            ->route('attendance-records.index')
            ->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceRecord $attendanceRecord): RedirectResponse
    {
        $attendanceRecord->delete();

        return redirect()
            ->route('attendance-records.index')
            ->with('success', 'Attendance record removed successfully.');
    }

    private function rules(?AttendanceRecord $attendanceRecord = null, ?Request $request = null): array
    {
        $request ??= request();
        $employeeId = $request->input('employee_id');

        return [
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'attendance_date' => [
                'required',
                'date',
                Rule::unique('attendance_records', 'attendance_date')
                    ->where(fn ($query) => $employeeId ? $query->where('employee_id', $employeeId) : $query)
                    ->ignore($attendanceRecord?->id),
            ],
            'check_in' => ['nullable', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i'],
            'status' => ['required', 'in:present,absent,on_leave'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
