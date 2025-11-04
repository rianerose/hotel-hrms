@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
    <div class="card">
        <h2 style="margin-top: 0; margin-bottom: 1.5rem; color: var(--primary);">Add Employee</h2>

        <form action="{{ route('employees.store') }}" method="POST">
            @include('employees._form')
        </form>
    </div>
@endsection
