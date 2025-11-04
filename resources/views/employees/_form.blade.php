@csrf

<div class="form-grid">
    <div>
        <label for="first_name">First Name</label>
        <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $employee->first_name ?? '') }}" required>
        @error('first_name')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="last_name">Last Name</label>
        <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $employee->last_name ?? '') }}" required>
        @error('last_name')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" required>
        @error('email')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="phone">Phone</label>
        <input id="phone" type="text" name="phone" value="{{ old('phone', $employee->phone ?? '') }}">
        @error('phone')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="department">Department</label>
        <input id="department" type="text" name="department" value="{{ old('department', $employee->department ?? '') }}">
        @error('department')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="position">Position</label>
        <input id="position" type="text" name="position" value="{{ old('position', $employee->position ?? '') }}">
        @error('position')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="hire_date">Hire Date</label>
        <input id="hire_date" type="date" name="hire_date" value="{{ old('hire_date', $employee->hire_date?->format('Y-m-d')) }}" required>
        @error('hire_date')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="hourly_rate">Hourly Rate</label>
        <input id="hourly_rate" type="number" min="0" step="0.01" name="hourly_rate" value="{{ old('hourly_rate', $employee->hourly_rate ?? '') }}" required>
        @error('hourly_rate')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="employment_status">Employment Status</label>
        <select id="employment_status" name="employment_status" required>
            @foreach ($employmentStatuses as $status)
                <option value="{{ $status }}" @selected(old('employment_status', $employee->employment_status ?? 'active') === $status)>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
        </select>
        @error('employment_status')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>

    <div style="grid-column: 1 / -1;">
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3">{{ old('address', $employee->address ?? '') }}</textarea>
        @error('address')
        <small style="color: #ef4444;">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="actions" style="margin-top: 1.5rem;">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
</div>
