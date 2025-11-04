@csrf

<div class="form-grid">
    <div>
        <label for="employee_id">Employee</label>
        <select id="employee_id" name="employee_id" required>
            <option value="">Select employee</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" @selected(old('employee_id', $attendanceRecord->employee_id ?? '') == $employee->id)>
                    {{ $employee->full_name }}
                </option>
            @endforeach
        </select>
        @error('employee_id')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="attendance_date">Date</label>
        <input id="attendance_date" type="date" name="attendance_date" value="{{ old('attendance_date', isset($attendanceRecord->attendance_date) ? $attendanceRecord->attendance_date->format('Y-m-d') : '') }}" required>
        @error('attendance_date')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="check_in">Check In (HH:MM)</label>
        <input id="check_in" type="time" name="check_in" value="{{ old('check_in', $attendanceRecord->check_in ?? '') }}">
        @error('check_in')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="check_out">Check Out (HH:MM)</label>
        <input id="check_out" type="time" name="check_out" value="{{ old('check_out', $attendanceRecord->check_out ?? '') }}">
        @error('check_out')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="status">Status</label>
        <select id="status" name="status" required>
            @foreach (['present', 'absent', 'on_leave'] as $status)
                <option value="{{ $status }}" @selected(old('status', $attendanceRecord->status ?? 'present') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
            @endforeach
        </select>
        @error('status')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div style="grid-column: 1 / -1;">
        <label for="notes">Notes</label>
        <textarea id="notes" name="notes" rows="3">{{ old('notes', $attendanceRecord->notes ?? '') }}</textarea>
        @error('notes')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="actions" style="margin-top: 1.5rem;">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('attendance-records.index') }}" class="btn btn-secondary">Cancel</a>
</div>
