@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <div class="card">
        <div class="actions" style="justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div>
                <h2 style="margin: 0; font-size: 1.4rem; color: var(--primary);">Employees</h2>
                <p style="margin: 0.25rem 0 0; color: rgba(31, 35, 64, 0.7);">Manage hotel staff profiles and employment details.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('employees.create') }}">Add Employee</a>
        </div>

        @if ($employees->isEmpty())
            <div class="empty-state">
                No employees have been added yet.
            </div>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Hire Date</th>
                        <th>Status</th>
                        <th>Hourly Rate</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->department ?: '—' }}</td>
                            <td>{{ $employee->position ?: '—' }}</td>
                            <td>{{ $employee->hire_date->format('M d, Y') }}</td>
                            <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $employee->employment_status) }}</td>
                            <td>₱{{ number_format($employee->hourly_rate, 2) }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-secondary" href="{{ route('employees.edit', $employee) }}">Edit</a>
                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Delete this employee? This will remove related attendance and payroll records.');">
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
                {{ $employees->links() }}
            </div>
        @endif
    </div>
@endsection
