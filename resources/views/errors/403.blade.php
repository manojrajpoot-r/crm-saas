<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Restricted</title>
    <style>
        body{
            margin:0;
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
            font-family: 'Segoe UI', sans-serif;
            color:#fff;
        }
        .card{
            background:#ffffff15;
            backdrop-filter: blur(10px);
            padding:40px;
            border-radius:12px;
            text-align:center;
            width:420px;
            box-shadow:0 10px 30px rgba(0,0,0,.4);
        }
        h1{
            font-size:64px;
            margin:0;
            color:#ff4d4d;
        }
        h3{
            margin:10px 0;
        }
        p{
            opacity:.9;
            margin-bottom:25px;
        }
        a{
            display:inline-block;
            padding:10px 22px;
            background:#ff4d4d;
            color:#fff;
            text-decoration:none;
            border-radius:6px;
        }
        a:hover{
            background:#e63b3b;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>403</h1>
        <h3>Access Restricted</h3>
        <p>
            {{ $exception->getMessage() ?: 'This tenant is not active or access is restricted.' }}
        </p>
        <a href="{{ url('index') }}">Go to Home</a>
    </div>
</body>
</html>
