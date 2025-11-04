@extends('layouts.app')

@section('title', 'Record Attendance')

@section('content')
    <div class="card">
        <h2 style="margin-top: 0; margin-bottom: 1.5rem; color: var(--primary);">Record Attendance</h2>

        <form action="{{ route('attendance-records.store') }}" method="POST">
            @include('attendance_records._form')
        </form>
    </div>
@endsection
