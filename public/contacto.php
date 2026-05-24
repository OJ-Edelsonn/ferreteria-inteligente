<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Contacto - ' . BUSINESS_NAME;
$activePage = 'contacto';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['nombre'] ?? ''));
    $phone = trim((string) ($_POST['celular'] ?? ''));
    $message = trim((string) ($_POST['mensaje'] ?? ''));

    if ($name === '' || $phone === '' || $message === '') {
        $error = 'Completa nombre, celular y mensaje.';
    } else {
        $text = urlencode("Hola, soy {$name} ({$phone}). {$message}");
        header('Location: https://wa.me/' . BUSINESS_WHATSAPP . '?text=' . $text);
        exit;
    }
}

require_once __DIR__ . '/../app/Views/partials/header.php';

?>
    <main>
        <section class="catalog-header page-hero page-hero-contacto">
            <div class="container">
                <p class="eyebrow"><?= e(BUSINESS_LOCATION) ?></p>
                <div class="row g-4 align-items-end">
                    <div class="col-lg-7">
                        <h1>Contacto</h1>
                        <p class="lead mb-0">Estamos cerca para ayudarte con materiales, herramientas y consultas para tu obra.</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="metric-panel contact-highlight">
                            <span>WhatsApp</span>
                            <strong>900 749 742</strong>
                            <p>Atención para clientes de <?= e(BUSINESS_DELIVERY_AREA) ?>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="map-section">
            <div class="container">
                <div class="map-panel">
                    <div class="map-copy">
                        <p class="eyebrow">Ubicación exacta</p>
                        <h2>Visítanos en Quiparacra - Pasco</h2>
                        <p>Usa el mapa para ubicar la ferretería antes de visitarnos o coordinar la entrega de materiales.</p>
                    </div>
                    <iframe
                        class="map-frame"
                        title="Mapa de J&S Ferretería en Quiparacra"
                        src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3901.234!2d-75.866949!3d-10.642924!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTDCsDM4JzM0LjUiUyA3NcKwNTInMDEuMCJX!5e0!3m2!1ses!2spe!4v1234567890!5m2!1ses!2spe"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="contact-panel">
                            <h2>Datos de la ferretería</h2>
                            <div class="contact-list">
                                <div>
                                    <span>Dirección</span>
                                    <strong><?= e(BUSINESS_ADDRESS) ?></strong>
                                </div>
                                <div>
                                    <span>Horario</span>
                                    <strong><?= e(BUSINESS_HOURS) ?></strong>
                                </div>
                                <div>
                                    <span>Entregas</span>
                                    <strong><?= e(BUSINESS_DELIVERY_AREA) ?></strong>
                                </div>
                            </div>
                            <a class="btn btn-danger w-100 mt-3" href="https://wa.me/<?= e(BUSINESS_WHATSAPP) ?>?text=Hola,%20quiero%20consultar%20sobre%20sus%20productos" target="_blank" rel="noopener">
                                Escribir por WhatsApp
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="contact-panel">
                            <h2>Enviar consulta rápida</h2>

                            <?php if ($error !== ''): ?>
                                <div class="alert alert-danger"><?= e($error) ?></div>
                            <?php endif; ?>

                            <form method="post" class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="nombre">Nombre</label>
                                    <input class="form-control" id="nombre" name="nombre" value="<?= e($_POST['nombre'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="celular">Celular</label>
                                    <input class="form-control" id="celular" name="celular" value="<?= e($_POST['celular'] ?? '') ?>" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="mensaje">Mensaje</label>
                                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required placeholder="Ejemplo: Necesito cotizar cemento y tubos PVC."><?= e($_POST['mensaje'] ?? '') ?></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-dark" type="submit">Preparar mensaje en WhatsApp</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php require_once __DIR__ . '/../app/Views/partials/footer.php'; ?>
