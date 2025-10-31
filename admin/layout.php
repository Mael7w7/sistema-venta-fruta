<?php require __DIR__.'/_auth.php'; ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel - FruTamboExport</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/styles.css">
  <style>
    .modal-backdrop {
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1040;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }
    .modal {
      z-index: 1050;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow-x: hidden;
      overflow-y: auto;
      outline: 0;
      pointer-events: auto;
    }
    .modal-dialog {
      margin: 1.75rem auto;
      pointer-events: auto;
    }
    .modal-content {
      position: relative;
      background-color: #fff;
      border-radius: 0.5rem;
      pointer-events: auto;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-dark bg-success navbar-sticky">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1">
        <span class="fw-semibold">Panel Administrativo</span>
      </span>
      <div class="d-flex align-items-center gap-4">
        <img src="/assets/imgs/logo.jpg" alt="FruTamboExport" style="height:40px; width:auto;" class="rounded-2" />
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="main-content py-4 animate-fade-in">
      <?php // content injected by children ?>
      <?= $content ?? '' ?>
    </div>
    
    <!-- Contenedor para modales -->
    <div id="modalsContainer">
      <?php include __DIR__ . '/modals.php'; ?>
    </div>
    
    <div class="admin-sidebar-right animate-slide-in">
      <div class="card card-minimal h-100">
        <div class="list-group list-group-flush">
            <?php
            $current_page = basename($_SERVER['PHP_SELF']);
            function isActive($page) {
                global $current_page;
                return $current_page === $page ? 'active' : '';
            }
            ?>
            <a class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= isActive('index.php') ?>" href="/admin/index.php">
              <i class="bi bi-grid"></i> Dashboard
              <?php if (isActive('index.php')): ?>
                <span class="ms-auto"><i class="bi bi-chevron-right"></i></span>
              <?php endif; ?>
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= isActive('clientes.php') ?>" href="/admin/clientes.php">
              <i class="bi bi-people"></i> Clientes
              <?php if (isActive('clientes.php')): ?>
                <span class="ms-auto"><i class="bi bi-chevron-right"></i></span>
              <?php endif; ?>
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= isActive('productos.php') ?>" href="/admin/productos.php">
              <i class="bi bi-box-seam"></i> Productos
              <?php if (isActive('productos.php')): ?>
                <span class="ms-auto"><i class="bi bi-chevron-right"></i></span>
              <?php endif; ?>
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= isActive('ventas.php') ?>" href="/admin/ventas.php">
              <i class="bi bi-receipt"></i> Ventas
              <?php if (isActive('ventas.php')): ?>
                <span class="ms-auto"><i class="bi bi-chevron-right"></i></span>
              <?php endif; ?>
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= isActive('reportes.php') ?>" href="/admin/reportes.php">
              <i class="bi bi-bar-chart"></i> Reportes
              <?php if (isActive('reportes.php')): ?>
                <span class="ms-auto"><i class="bi bi-chevron-right"></i></span>
              <?php endif; ?>
            </a>
            
            <div class="border-top my-3"></div>
            
            <div class="list-group-item d-flex align-items-center gap-2">
              <i class="bi bi-person-circle"></i>
              <span><?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?></span>
            </div>
            
            <a class="list-group-item list-group-item-action d-flex align-items-center gap-2 text-danger" href="/logout.php">
              <i class="bi bi-box-arrow-right"></i> Salir
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
  // Añadir animación a las cards cuando aparecen en el viewport
  document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card-minimal');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-scale-in');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    cards.forEach(card => observer.observe(card));
  });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


