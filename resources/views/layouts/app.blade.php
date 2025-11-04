<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <style>
        :root {
            --primary: #3338A0;
            --accent: #FCC61D;
            --light: #FFFFFF;
            --background: #f5f6ff;
            --text: #1f2340;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        header {
            background: var(--primary);
            color: var(--light);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        nav {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        nav a {
            padding: 0.5rem 1rem;
            border-radius: 999px;
            transition: background 0.2s ease, color 0.2s ease;
            font-weight: 500;
        }

        nav a.active,
        nav a:hover,
        nav a:focus {
            background: var(--accent);
            color: var(--primary);
        }

        main {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: var(--light);
            border-radius: 16px;
            box-shadow: 0 12px 24px rgba(51, 56, 160, 0.12);
            padding: 1.75rem;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--light);
        }

        table th,
        table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e1e5ff;
            text-align: left;
        }

        table thead th {
            background: rgba(51, 56, 160, 0.08);
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--light);
            box-shadow: 0 6px 18px rgba(51, 56, 160, 0.25);
        }

        .btn-secondary {
            background: rgba(51, 56, 160, 0.08);
            color: var(--primary);
        }

        .btn-danger {
            background: #ef4444;
            color: var(--light);
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(51, 56, 160, 0.25);
        }

        .form-grid {
            display: grid;
            gap: 1.25rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: var(--primary);
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.7rem 0.85rem;
            border: 1px solid rgba(51, 56, 160, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(252, 198, 29, 0.35);
        }

        .actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .alert {
            padding: 0.85rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .alert-success {
            background: rgba(252, 198, 29, 0.15);
            color: var(--primary);
            border: 1px solid rgba(252, 198, 29, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: rgba(31, 35, 64, 0.6);
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 0.45rem 0.8rem;
            border-radius: 6px;
            border: 1px solid rgba(51, 56, 160, 0.3);
            color: var(--primary);
            font-weight: 600;
            min-width: 2.2rem;
            text-align: center;
        }

        .pagination li a:hover {
            background: var(--accent);
            color: var(--primary);
            border-color: transparent;
        }

        .pagination li span[aria-current="page"] {
            background: var(--primary);
            color: var(--light);
            border-color: transparent;
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            color: rgba(31, 35, 64, 0.6);
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            main {
                padding: 1.5rem;
            }

            .card {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>
<header>
    <h1>{{ config('app.name', 'Hotel HRMS') }}</h1>
    <nav>
        <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">Employees</a>
        <a href="{{ route('attendance-records.index') }}" class="{{ request()->routeIs('attendance-records.*') ? 'active' : '' }}">Attendance</a>
        <a href="{{ route('payrolls.index') }}" class="{{ request()->routeIs('payrolls.*') ? 'active' : '' }}">Payroll</a>
    </nav>
    @auth
        <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <div style="color: rgba(255, 255, 255, 0.9); font-weight: 600;">
                {{ auth()->user()->name }}
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-secondary" style="background: rgba(255,255,255,0.12); color: var(--light); border: 1px solid rgba(255,255,255,0.25);">Log out</button>
            </form>
        </div>
    @endauth
</header>

<main>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

<footer>
    &copy; {{ date('Y') }} Hotel HR Management System
</footer>
</body>
</html>
