@extends('layouts.app')

@section('title', 'Payroll')

@section('content')
    <div class="card">
        <div class="actions" style="justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="margin: 0; font-size: 1.4rem; color: var(--primary);">Payroll Overview</h2>
                <p style="margin: 0.25rem 0 0; color: rgba(31, 35, 64, 0.7);">Review generated payroll summaries for each employee.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('payrolls.create') }}">Generate Payroll</a>
        </div>

        <form method="GET" action="{{ route('payrolls.index') }}" class="card" style="margin: 0 0 1.5rem 0; padding: 1.25rem;">
            <div class="form-grid">
                <div>
                    <label for="employee_filter">Employee</label>
                    <select id="employee_filter" name="employee_id">
                        <option value="">All</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @selected(($filters['employee_id'] ?? '') == $employee->id)>{{ $employee->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="period_start">Period Start</label>
                    <input id="period_start" type="date" name="period_start" value="{{ $filters['period_start'] ?? '' }}">
                </div>
                <div>
                    <label for="period_end">Period End</label>
                    <input id="period_end" type="date" name="period_end" value="{{ $filters['period_end'] ?? '' }}">
                </div>
            </div>
            <div class="actions" style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        @if ($payrolls->isEmpty())
            <div class="empty-state">
                No payroll records found for the selected filters.
            </div>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Period</th>
                        <th>Hours Worked</th>
                        <th>Gross Pay</th>
                        <th>Deductions</th>
                        <th>Net Pay</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payrolls as $payroll)
                        <tr>
                            <td>{{ $payroll->employee->full_name }}</td>
                            <td>{{ $payroll->period_start->format('M d, Y') }} – {{ $payroll->period_end->format('M d, Y') }}</td>
                            <td>{{ number_format($payroll->hours_worked, 2) }}</td>
                            <td>₱{{ number_format($payroll->gross_pay, 2) }}</td>
                            <td>₱{{ number_format($payroll->deductions, 2) }}</td>
                            <td><strong>₱{{ number_format($payroll->net_pay, 2) }}</strong></td>
                            <td>
                                <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" onsubmit="return confirm('Delete this payroll record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $payrolls->links() }}
            </div>
        @endif
    </div>
@endsection
