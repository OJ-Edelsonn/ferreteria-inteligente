<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Servicios de obra - ' . BUSINESS_NAME;
$activePage = 'servicios';
$message = urlencode('Hola, me interesa solicitar un presupuesto para una obra. Quisiera coordinar una evaluacion.');

require_once __DIR__ . '/../app/Views/partials/header.php';

$services = [
    ['Construccion de viviendas', 'Obras desde cero con ladrillo, cemento, columnas, techos y acabados resistentes para la zona.'],
    ['Remodelacion y ampliaciones', 'Refacciones, ampliaciones de ambientes, tarrajeo, pisos, muros y mejoras de vivienda.'],
    ['Instalaciones sanitarias', 'Colocacion de baños, lavatorios, tuberias, desague, llaves y conexiones de agua.'],
    ['Instalaciones electricas', 'Cableado, tomacorrientes, interruptores, tablero electrico y puntos de luz.'],
    ['Puertas, ventanas y acabados', 'Colocacion, nivelacion, empaste, pintura y detalles finales para entregar una obra limpia.'],
    ['Asesoria de materiales', 'Orientacion para elegir materiales adecuados y comprar en J&S Ferretería con mejor criterio.'],
];

$steps = [
    ['1', 'Contacto inicial', 'El cliente escribe por WhatsApp o visita la ferreteria para explicar el trabajo que necesita.'],
    ['2', 'Evaluacion de obra', 'Se revisa el espacio, medidas, materiales necesarios y dificultad del trabajo.'],
    ['3', 'Presupuesto claro', 'Se presenta una estimacion de mano de obra y materiales para tomar una decision informada.'],
    ['4', 'Compra de materiales', 'El cliente puede adquirir materiales en J&S Ferretería con asesoria directa.'],
    ['5', 'Ejecucion y entrega', 'Se realiza el trabajo acordado y se entrega con revision final.'],
];

?>
    <main>
        <section class="services-hero">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-7">
                        <p class="eyebrow">Servicio de maestro albañil</p>
                        <h1>Construccion y remodelacion para familias de <?= e(BUSINESS_LOCATION) ?>.</h1>
                        <p class="lead">Ademas del catalogo de materiales, J&S Ferretería facilita contacto para servicios de obra con experiencia local.</p>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a class="btn btn-danger" href="https://wa.me/<?= e(BUSINESS_WHATSAPP) ?>?text=<?= e($message) ?>" target="_blank" rel="noopener">Solicitar presupuesto</a>
                            <a class="btn btn-outline-light" href="<?= e(BASE_URL) ?>/cotizador.php">Cotizar materiales</a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="service-hero-card">
                            <span>Ventaja para clientes</span>
                            <strong>Mano de obra + materiales</strong>
                            <p>Al coordinar el servicio, el cliente recibe orientacion para elegir materiales y estimar mejor su presupuesto.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="section-kicker">
                    <p class="eyebrow">Servicios</p>
                    <h2>Trabajos que se pueden solicitar</h2>
                </div>
                <div class="service-grid">
                    <?php foreach ($services as [$title, $description]): ?>
                        <article class="service-card">
                            <h3><?= e($title) ?></h3>
                            <p><?= e($description) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="process-section">
            <div class="container">
                <div class="section-kicker">
                    <p class="eyebrow">Proceso</p>
                    <h2>Como se coordina una obra</h2>
                </div>
                <div class="process-grid">
                    <?php foreach ($steps as [$number, $title, $description]): ?>
                        <article class="process-card">
                            <span><?= e($number) ?></span>
                            <h3><?= e($title) ?></h3>
                            <p><?= e($description) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="cta-band">
            <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
                <div>
                    <p class="eyebrow">Presupuesto</p>
                    <h2>Cuéntanos que obra necesitas realizar.</h2>
                    <p>El primer contacto se realiza por WhatsApp para coordinar ubicacion, tipo de trabajo y materiales requeridos.</p>
                </div>
                <a class="btn btn-light" href="https://wa.me/<?= e(BUSINESS_WHATSAPP) ?>?text=<?= e($message) ?>" target="_blank" rel="noopener">Escribir por WhatsApp</a>
            </div>
        </section>
    </main>
<?php require_once __DIR__ . '/../app/Views/partials/footer.php'; ?>

