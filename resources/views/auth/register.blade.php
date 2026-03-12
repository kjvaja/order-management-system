<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial;
        }

        .register-card {
            width: 420px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        .brand-bar {
            background: #000;
            color: #ffc107;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .btn-theme {
            background: #ffc107;
            border: none;
            font-weight: 600;
            color: black;
        }

        .btn-theme:hover {
            background: #ffca2c;
        }

        a {
            color: #ffc107;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <div class="card register-card">

        <div class="brand-bar">
            Order Management
        </div>

        <div class="card-body p-4">

            <h4 class="text-center mb-4">Register</h4>

            <form method="POST" action="{{ route('register') }}">

                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="d-grid mb-3">
                    <button class="btn btn-theme">
                        Register
                    </button>
                </div>

                <div class="text-center">
                    Already have an account?
                    <a href="{{ route('login') }}">Login</a>
                </div>

            </form>

        </div>

    </div>

</body>

</html>