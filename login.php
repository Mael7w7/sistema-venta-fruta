<?php session_start();
if (isset($_SESSION['user'])) {
    header('Location: /admin/index.php');
    exit;
}
$pageTitle = 'Login - FruTamboExport';
include __DIR__ . '/includes/header.php'; ?>

<section class="section">
    <div class="container" style="max-width:480px;">
        <h2 class="mb-4">Iniciar sesión</h2>
        <?php if (isset($_GET['error'])): ?>
            <?php
            $map = [
                'db' => 'Error de conexión a la base de datos.',
                'query' => 'Error al consultar usuarios.',
                'creds' => 'Credenciales inválidas o usuario sin rol admin.'
            ];
            $msg = $map[$_GET['error']] ?? 'Error al iniciar sesión.';
            ?>
            <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <form method="post" action="/login_process.php" class="card card-minimal p-4">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>