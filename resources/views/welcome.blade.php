<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Routes</h2>
    <ul>
            <li>
                <a href="{{ route('admin.register') }}">
                    Admin Register
                </a>
            </li>
            <li>
                <a href="{{ route('admin.login') }}">
                    Admin Login
                </a>
            </li>
            <li>
                <a href="{{ route('user.register') }}">
                    User Register
                </a>
            </li>
            <li>
                <a href="{{ route('user.login') }}">
                    User Login
                </a>
            </li>

    </ul>
    
</body>
</html>