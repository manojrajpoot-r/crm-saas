<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page Not Found</title>
    <style>
        body{
            margin:0;
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,#141e30,#243b55);
            font-family: 'Segoe UI', sans-serif;
            color:#fff;
        }
        .box{
            text-align:center;
            padding:50px;
            background:#ffffff12;
            border-radius:14px;
            backdrop-filter: blur(10px);
            box-shadow:0 15px 40px rgba(0,0,0,.4);
            width:420px;
        }
        h1{
            font-size:72px;
            margin:0;
            color:#ff4d4d;
        }
        h3{
            margin:10px 0;
        }
        p{
            opacity:.85;
            margin-bottom:25px;
        }
        a{
            display:inline-block;
            padding:10px 24px;
            background:#ff4d4d;
            color:#fff;
            text-decoration:none;
            border-radius:6px;
            transition:.3s;
        }
        a:hover{
            background:#e63b3b;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>404</h1>
        <h3>Page Not Found</h3>
        <p>
            The page you are looking for doesn’t exist or has been moved.
        </p>
        <a href="{{ url('/') }}">Go to Home</a>
    </div>
</body>
</html>
