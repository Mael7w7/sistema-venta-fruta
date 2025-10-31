<?php if (!isset($pageTitle)) {
  $pageTitle = 'FruTamboExport';
} ?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/styles.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-white border-bottom navbar-sticky">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary d-flex align-items-center gap-2" href="/">
        <img src="/assets/imgs/logo.jpg" alt="FruTamboExport" style="height:36px; width:auto;" />
        <span class="d-none d-sm-inline">FruTamboExport</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="/#inicio">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="/#productos">Productos</a></li>
          <li class="nav-item"><a class="nav-link" href="/#nosotros">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="/#contacto">Contáctanos</a></li>
          <li class="nav-item"><a class="nav-link" href="/#ubicacion">Ubicación</a></li>
          <li class="nav-item"><a class="nav-link" href="/#intranet">Intranet</a></li>
          <li class="nav-item"><a class="nav-link text-primary" href="/login.php">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>