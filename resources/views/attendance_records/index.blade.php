@extends('layouts.app')

@section('title', 'Attendance Records')

@section('content')
    <div class="card">
        <div class="actions" style="justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="margin: 0; font-size: 1.4rem; color: var(--primary);">Attendance</h2>
                <p style="margin: 0.25rem 0 0; color: rgba(31, 35, 64, 0.7);">Track employee attendance and working hours.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('attendance-records.create') }}">Record Attendance</a>
        </div>

        <form method="GET" action="{{ route('attendance-records.index') }}" class="card" style="margin: 0 0 1.5rem 0; padding: 1.25rem;">
            <div class="form-grid">
                <div>
                    <label for="filter_employee">Employee</label>
                    <select id="filter_employee" name="employee_id">
                        <option value="">All</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" @selected(($filters['employee_id'] ?? '') == $employee->id)>{{ $employee->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="start_date">Start Date</label>
                    <input id="start_date" type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div>
                    <label for="end_date">End Date</label>
                    <input id="end_date" type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}">
                </div>
            </div>
            <div class="actions" style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('attendance-records.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        @if ($attendanceRecords->isEmpty())
            <div class="empty-state">
                No attendance records found for the selected filters.
            </div>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee</th>
                        <th>Status</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Hours Worked</th>
                        <th>Notes</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($attendanceRecords as $record)
                        <tr>
                            <td>{{ $record->attendance_date->format('M d, Y') }}</td>
                            <td>{{ $record->employee->full_name }}</td>
                            <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $record->status) }}</td>
                            <td>{{ $record->check_in ? \Carbon\Carbon::createFromFormat('H:i', $record->check_in)->format('h:i A') : '—' }}</td>
                            <td>{{ $record->check_out ? \Carbon\Carbon::createFromFormat('H:i', $record->check_out)->format('h:i A') : '—' }}</td>
                            <td>{{ number_format($record->hours_worked, 2) }}</td>
                            <td>{{ $record->notes ? \Illuminate\Support\Str::limit($record->notes, 50) : '—' }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-secondary" href="{{ route('attendance-records.edit', $record) }}">Edit</a>
                                    <form action="{{ route('attendance-records.destroy', $record) }}" method="POST" onsubmit="return confirm('Delete this attendance record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $attendanceRecords->links() }}
            </div>
        @endif
    </div>
@endsection
