<?php $pageTitle = 'FruTamboExport - Inicio';
include __DIR__ . '/includes/header.php'; ?>

<section class="section">
  <div class="container">
    <div class="card card-brand border-0 shadow-lg rounded-4">
      <div class="card-body p-5">
        <div class="row align-items-center g-4">
          <div class="col-lg-7">
            <h1 class="display-5 fw-bold mb-3">FruTamboExport</h1>
            <p class="lead mb-4">Gestione clientes, productos y ventas con una interfaz moderna y ágil. Calidad de exportación con trazabilidad completa.</p>
            <a href="/login.php" class="btn btn-light btn-rounded me-2">Ingresar</a>
            <a href="#secciones" class="btn btn-outline-light btn-rounded">Conocer más</a>
          </div>
          <div class="col-lg-5 text-center">
            <img class="img-fluid rounded-4 shadow" src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=1200&auto=format&fit=crop" alt="Frutas frescas">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="secciones" class="section">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card card-minimal h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="card-title mb-0">Clientes</h5>
              <span class="badge badge-soft">🧑‍💼</span>
            </div>
            <p class="text-muted mb-3">Administra y mantiene tu cartera de clientes.</p>
            <a href="/admin/clientes.php" class="stretched-link">Ir a clientes</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-minimal h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="card-title mb-0">Productos</h5>
              <span class="badge badge-soft">📦</span>
            </div>
            <p class="text-muted mb-3">Catálogo y precios listos para la exportación.</p>
            <a href="/admin/productos.php" class="stretched-link">Ir a productos</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-minimal h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="card-title mb-0">Ventas</h5>
              <span class="badge badge-soft">🧾</span>
            </div>
            <p class="text-muted mb-3">Registra ventas y obtén reportes al instante.</p>
            <a href="/admin/ventas.php" class="stretched-link">Ir a ventas</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="intranet" class="section bg-light-soft">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <h2 class="mb-2">Intranet</h2>
        <p class="mb-3">Acceso privado para gestión de Clientes, Productos, Ventas y Reportes. Disponible solo para usuarios autorizados.</p>
        <a href="/login.php" class="btn btn-primary btn-rounded">Entrar a Intranet</a>
      </div>
      <div class="col-lg-5">
        <div class="card card-minimal">
          <div class="card-body">
            <div class="d-flex justify-content-between"><span class="text-muted">Seguridad</span><span class="badge badge-soft">🔐</span></div>
            <p class="mb-0 mt-2 text-muted">Sesiones, autenticación y control de acceso para el administrador.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>