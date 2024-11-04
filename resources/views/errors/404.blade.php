<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            text-align: center;
        }

        h1 {
            font-size: 8rem;
            color: #90319a;
            margin: 0;
            animation: bounce 1s infinite;
        }

        p {
            font-size: 1.5rem;
            color: #2f3542;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #b06bff;
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #cb47ff;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 5rem;
            }

            p {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>Oops! Halaman yang Anda cari tidak ditemukan.</p>
        <a href="{{ url('/') }}">Kembali ke Beranda</a>
    </div>
</body>
</html>
