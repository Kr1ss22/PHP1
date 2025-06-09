<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontakt – kmustkivi.com</title>
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

        form {
            max-width: 600px;
            margin: 0 auto;
            text-align: left;
        }

        form label {
            margin-top: 10px;
            font-weight: bold;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
                        <a class="nav-link" href="pood.php">Pood</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="kontakt.php">Kontakt</a>
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

    <div class="container mt-5 mb-5">
        <h2 class="text-center">Kontaktivorm</h2>
        <form action="send_message.php" method="POST">
            <label for="name">Nimi:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">E-post:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Sõnum:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit" class="btn btn-primary">Saada</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>kmustkivi.com</p>
        </div>
    </footer>
</body>
</html>
