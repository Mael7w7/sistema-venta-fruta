<?php
// Este archivo contiene los modales para la aplicación
?>

<!-- Modal Crear/Editar Cliente -->
<div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="clienteForm" action="/admin/clientes.php">
        <div class="modal-header">
          <h5 class="modal-title" id="clienteModalLabel">Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input class="form-control" name="nombre" id="nombre" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" id="email" type="email">
          </div>
          <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input class="form-control" name="telefono" id="telefono">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Crear/Editar Producto -->
<div class="modal fade" id="productoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="/admin/productos.php">
        <div class="modal-header">
          <h5 class="modal-title">Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="producto_id">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <select class="form-select" name="nombre" id="producto_nombre" required>
              <option value="">Seleccione un producto...</option>
              <option value="Mango">Mango</option>
              <option value="Palta">Palta</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Precio</label>
            <input class="form-control" name="precio" id="producto_precio" type="number" step="0.01" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Crear/Editar Venta -->
<div class="modal fade" id="ventaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="/admin/ventas.php">
        <div class="modal-header">
          <h5 class="modal-title">Venta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="venta_id">
          <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select class="form-select" name="cliente_id" id="cliente_id" required>
              <option value="">Cliente...</option>
              <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Producto</label>
            <select class="form-select" name="producto_id" id="producto_id" required>
              <option value="">Producto...</option>
              <?php foreach ($productos as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?> - S/ <?= number_format($p['precio'], 2) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input class="form-control" name="cantidad" id="cantidad" type="number" min="1" value="1" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input class="form-control" name="fecha" id="fecha" type="date" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>