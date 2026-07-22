<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 | TraceOps ERP</title>
    <style>
        body{margin:0;font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:#f4f7fb;color:#172033}.error-shell{min-height:100vh;display:grid;place-items:center;padding:24px}.error-card{width:min(680px,100%);background:#fff;border:1px solid #e6ebf2;border-radius:24px;padding:48px;box-shadow:0 24px 70px rgba(22,32,51,.10);text-align:center}.brand{font-weight:800;letter-spacing:.08em;color:#1b4d89}.code{font-size:clamp(72px,16vw,150px);line-height:1;font-weight:900;color:#dce8f6;margin:24px 0 8px}.error-card h1{font-size:30px;margin:0 0 12px}.error-card p{color:#617087;line-height:1.7;margin:0 auto 28px;max-width:520px}.actions{display:flex;justify-content:center;gap:12px;flex-wrap:wrap}.button{display:inline-flex;align-items:center;justify-content:center;padding:12px 18px;border-radius:12px;text-decoration:none;font-weight:700}.button-primary{background:#1b4d89;color:#fff}.button-secondary{background:#eef3f9;color:#1b4d89}
    </style>
</head>
<body>
<main class="error-shell">
    <section class="error-card">
        <div class="brand">TRACEOPS ERP</div>
        <div class="code">404</div>
        <h1>Página no encontrada</h1>
        <p>La ruta solicitada no existe o fue trasladada. Regresa al espacio de trabajo principal para continuar.</p>
        <div class="actions">
            <a class="button button-primary" href="<?= base_url('/') ?>">Ir al dashboard</a>
            <a class="button button-secondary" href="javascript:history.back()">Volver</a>
        </div>
    </section>
</main>
</body>
</html>
