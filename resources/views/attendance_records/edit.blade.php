@extends('layouts.app')

@section('title', 'Edit Attendance')

@section('content')
    <div class="card">
        <h2 style="margin-top: 0; margin-bottom: 1.5rem; color: var(--primary);">Edit Attendance</h2>

        <form action="{{ route('attendance-records.update', $attendanceRecord) }}" method="POST">
            @method('PUT')
            @include('attendance_records._form')
        </form>
    </div>
@endsection
