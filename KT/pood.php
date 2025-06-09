<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pood – kmustkivi.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .navbar {
            background-color: #e9ecef;
        }
        .navbar-brand {
            margin-left: 20px;
            color: #000;
        }
        .navbar-nav {
            margin-right: 20px;
        }
        .navbar-nav .nav-link {
            color: #000;
            margin-right: 20px;
        }
        .navbar-nav .nav-item:last-child .nav-link {
            margin-right: 0;
        }
        .bi-bag {
            color: #000;
        }
        footer {
            background-color: #f8f9fa;
            padding: 60px 0;
            margin-top: 20px;
        }
        footer p {
            margin: 0;
            text-align: left;
            margin-left: 20px;
        }
        .navbar .container-fluid, footer .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand p-2" href="index1.php">kmustkivi.com</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index1.php">Avaleht</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="pood.php">Pood</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontakt.php">Kontakt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                    <li class="nav-item text-center mt-2">
                        <i class="bi bi-bag"></i>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5 text-center">
        <h2>Pood</h2>
        <p>Siin on pood!</p>
    </div>

    <footer>
        <div class="container">
            <p>kmustkivi.com</p>
        </div>
    </footer>
</body>
</html>
