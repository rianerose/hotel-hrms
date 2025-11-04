<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | {{ config('app.name') }}</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(51, 56, 160, 0.95), rgba(252, 198, 29, 0.85));
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
        }

        .card {
            width: min(420px, 92vw);
            background: var(--light);
            border-radius: 18px;
            padding: 2.25rem;
            box-shadow: 0 24px 48px rgba(31, 35, 64, 0.22);
        }

        h1 {
            margin: 0 0 0.25rem;
            color: var(--primary);
            font-size: 1.75rem;
            text-align: center;
        }

        p.subtitle {
            margin: 0 0 2rem;
            text-align: center;
            color: rgba(31, 35, 64, 0.65);
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.35rem;
            color: var(--primary);
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 0.9rem;
            border-radius: 10px;
            border: 1px solid rgba(51, 56, 160, 0.35);
            background: rgba(255, 255, 255, 0.95);
            font-size: 1rem;
            transition: border 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(252, 198, 29, 0.35);
        }

        .field {
            margin-bottom: 1.25rem;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            color: rgba(31, 35, 64, 0.75);
        }

        .btn-primary {
            background: var(--primary);
            color: var(--light);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(51, 56, 160, 0.25);
        }

        .error {
            color: #ef4444;
            font-size: 0.9rem;
            margin-top: 0.35rem;
        }

        footer {
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(31, 35, 64, 0.6);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>{{ config('app.name', 'Hotel HRMS') }}</h1>
    <p class="subtitle">Sign in with your administrator credentials to continue.</p>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="actions">
            <label class="remember">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Remember me
            </label>
        </div>

        <button type="submit" class="btn-primary">Log In</button>
    </form>

    <footer>
        &copy; {{ date('Y') }} Hotel HR Management System
    </footer>
</div>
</body>
</html>
