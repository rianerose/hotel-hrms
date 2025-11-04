@extends('layouts.app')

@section('title', 'Generate Payroll')

@section('content')
    <div class="card">
        <h2 style="margin-top: 0; margin-bottom: 1.5rem; color: var(--primary);">Generate Payroll</h2>
        <p style="margin-top: -0.5rem; margin-bottom: 1.5rem; color: rgba(31, 35, 64, 0.65);">Payroll is calculated from approved attendance records within the selected period.</p>

        <form action="{{ route('payrolls.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div>
                    <label for="employee_id">Employee</label>
                    <select id="employee_id" name="employee_id" required>
                        <option value="">Select employee</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>{{ $employee->full_name }}</option>
                        @endforeach
                    </select>
                    @error('employee_id')
                    <small style="color: #ef4444;">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label for="period_start">Period Start</label>
                    <input id="period_start" type="date" name="period_start" value="{{ old('period_start', $defaultStart) }}" required>
                    @error('period_start')
                    <small style="color: #ef4444;">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label for="period_end">Period End</label>
                    <input id="period_end" type="date" name="period_end" value="{{ old('period_end', $defaultEnd) }}" required>
                    @error('period_end')
                    <small style="color: #ef4444;">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label for="deductions">Deductions (optional)</label>
                    <input id="deductions" type="number" min="0" step="0.01" name="deductions" value="{{ old('deductions', 0) }}">
                    @error('deductions')
                    <small style="color: #ef4444;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="actions" style="margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Generate</button>
                <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
