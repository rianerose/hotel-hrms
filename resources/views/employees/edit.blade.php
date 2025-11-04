@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <div class="card">
        <h2 style="margin-top: 0; margin-bottom: 1.5rem; color: var(--primary);">Edit Employee</h2>

        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @method('PUT')
            @include('employees._form')
        </form>
    </div>
@endsection
