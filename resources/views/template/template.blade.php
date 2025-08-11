<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistema de Votação Eletrônica</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="styles.css">

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-vote-yea me-2"></i>URNA IFRN
        </a>
        <div class="navbar-nav ms-auto">
            <button class="btn btn-outline-light btn-sm" onclick="logout()">
                <i class="fas fa-sign-out-alt me-1"></i>Sair
            </button>
        </div>
    </div>
</nav>

<div class="container mt-4">
@yield('content')
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>

</body>
</html>
