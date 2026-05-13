<?php
declare(strict_types=1);

/*
 * public/index.php (IONOS compatible)
 * - logs dans /ppe_logs
 * - normalisation robuste du path (sous-dossier + index.php)
 * - try/catch global pour afficher les erreurs en log
 */

$logDir = __DIR__ . '/../ppe_logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}

// Ping
@file_put_contents($logDir . '/ping.log', "[" . date('c') . "] index.php reached\n", FILE_APPEND);

// Fatal errors
register_shutdown_function(function () use ($logDir) {
    $e = error_get_last();
    if ($e) {
        @file_put_contents(
            $logDir . '/php-fatal.log',
            "[" . date('c') . "] {$e['type']} {$e['message']} in {$e['file']}:{$e['line']}\n",
            FILE_APPEND
        );
    }
});

// Session
session_start();

// Raw request log (pour voir si POST arrive)
@file_put_contents(
    $logDir . '/raw.log',
    "[" . date('c') . "] " . ($_SERVER['REQUEST_METHOD'] ?? '?') . " " . ($_SERVER['REQUEST_URI'] ?? '?') .
    " CT=" . ($_SERVER['CONTENT_TYPE'] ?? '-') .
    " CL=" . ($_SERVER['CONTENT_LENGTH'] ?? '-') . "\n",
    FILE_APPEND
);

// Autoload simple
spl_autoload_register(function (string $class): void {
    $path = __DIR__ . '/../app/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($path)) {
        require $path;
    }
});

use Core\Router;

$router = new Router();

// -------------------- ROUTES --------------------
// Auth
$router->get('/',                        [Controllers\AuthController::class, 'accueil']);
$router->get('/index.php',               [Controllers\AuthController::class, 'login']);
$router->get('/login',                   [Controllers\AuthController::class, 'login']);
$router->post('/login',                  [Controllers\AuthController::class, 'doLogin']);
$router->get('/dashboard',               [Controllers\AuthController::class, 'dashboard']);
$router->get('/dashboard-comptable',     [Controllers\AuthController::class, 'dashboardComptable']);
$router->get('/accueil',                 [Controllers\AuthController::class, 'accueil']);
$router->get('/logout',                  [Controllers\AuthController::class, 'logout']);
$router->get('/inscription',             [Controllers\AuthController::class, 'inscription']);
$router->post('/inscription',            [Controllers\AuthController::class, 'doInscription']);

// Etat
$router->get('/etat',                              [Controllers\ControlEtat::class, 'index']);
$router->get('/etat/',                             [Controllers\ControlEtat::class, 'index']);
$router->get('/etat/create',                       [Controllers\ControlEtat::class, 'create']);
$router->post('/etat/create',                      [Controllers\ControlEtat::class, 'store']);
$router->get('#^/etat/([0-9]+)$#',                 [Controllers\ControlEtat::class, 'show']);
$router->get('#^/etat/([0-9]+)/edit$#',            [Controllers\ControlEtat::class, 'edit']);
$router->post('#^/etat/([0-9]+)/edit$#',           [Controllers\ControlEtat::class, 'update']);
$router->post('#^/etat/([0-9]+)/delete$#',         [Controllers\ControlEtat::class, 'delete']);

// Forfait
$router->get('/forfait',                           [Controllers\ControlFraisforfait::class, 'index']);
$router->get('/forfait/',                          [Controllers\ControlFraisforfait::class, 'index']);
$router->get('/forfait/create',                    [Controllers\ControlFraisforfait::class, 'create']);
$router->post('/forfait/create',                   [Controllers\ControlFraisforfait::class, 'store']);
$router->get('#^/forfait/([0-9]+)$#',              [Controllers\ControlFraisforfait::class, 'show']);
$router->get('#^/forfait/([0-9]+)/edit$#',         [Controllers\ControlFraisforfait::class, 'edit']);
$router->post('#^/forfait/([0-9]+)/edit$#',        [Controllers\ControlFraisforfait::class, 'update']);
$router->post('#^/forfait/([0-9]+)/delete$#',      [Controllers\ControlFraisforfait::class, 'delete']);

// Visiteur
$router->get('/visiteur',                          [Controllers\ControlVisiteur::class, 'index']);
$router->get('/visiteur/',                         [Controllers\ControlVisiteur::class, 'index']);
$router->get('/visiteur/create',                   [Controllers\ControlVisiteur::class, 'create']);
$router->post('/visiteur/create',                  [Controllers\ControlVisiteur::class, 'store']);
$router->get('#^/visiteur/([0-9]+)$#',             [Controllers\ControlVisiteur::class, 'show']);
$router->get('#^/visiteur/([0-9]+)/edit$#',        [Controllers\ControlVisiteur::class, 'edit']);
$router->post('#^/visiteur/([0-9]+)/edit$#',       [Controllers\ControlVisiteur::class, 'update']);
$router->post('#^/visiteur/([0-9]+)/delete$#',     [Controllers\ControlVisiteur::class, 'delete']);
$router->get('#^/visiteur/([0-9]+)/modifier-mdp$#',  [Controllers\ControlVisiteur::class, 'modifierMdp']);
$router->post('#^/visiteur/([0-9]+)/modifier-mdp$#', [Controllers\ControlVisiteur::class, 'modifierMdp']);

// HorForfait
$router->get('/horforfait',                        [Controllers\ControlHorForfait::class, 'index']);
$router->get('/horforfait/',                       [Controllers\ControlHorForfait::class, 'index']);
$router->get('/horforfait/create',                 [Controllers\ControlHorForfait::class, 'create']);
$router->post('/horforfait/create',                [Controllers\ControlHorForfait::class, 'store']);
$router->get('#^/horforfait/([0-9]+)$#',           [Controllers\ControlHorForfait::class, 'show']);
$router->get('#^/horforfait/([0-9]+)/edit$#',      [Controllers\ControlHorForfait::class, 'edit']);
$router->post('#^/horforfait/([0-9]+)/edit$#',     [Controllers\ControlHorForfait::class, 'update']);
$router->post('#^/horforfait/([0-9]+)/delete$#',   [Controllers\ControlHorForfait::class, 'delete']);

// FicheFrais
$router->get('/fichefrais',                                          [Controllers\ControlFicheFrais::class, 'index']);
$router->get('/fichefrais/',                                         [Controllers\ControlFicheFrais::class, 'index']);
$router->get('/fichefrais/create',                                   [Controllers\ControlFicheFrais::class, 'create']);
$router->post('/fichefrais/create',                                  [Controllers\ControlFicheFrais::class, 'store']);
$router->get('#^/fichefrais/([^/]+)/([^/]+)/edit$#',                 [Controllers\ControlFicheFrais::class, 'edit']);
$router->post('#^/fichefrais/([^/]+)/([^/]+)/edit$#',                [Controllers\ControlFicheFrais::class, 'update']);
$router->post('#^/fichefrais/([^/]+)/([^/]+)/delete$#',              [Controllers\ControlFicheFrais::class, 'delete']);
$router->get('#^/fichefrais/([^/]+)/([^/]+)$#',                      [Controllers\ControlFicheFrais::class, 'show']);

// LigneFraisForfait
$router->get('/lignefraisforfait',                                                   [\Controllers\ControlLigneFraisForfait::class, 'index']);
$router->get('/lignefraisforfait/',                                                  [\Controllers\ControlLigneFraisForfait::class, 'index']);
$router->get('/lignefraisforfait/create',                                            [\Controllers\ControlLigneFraisForfait::class, 'create']);
$router->post('/lignefraisforfait/create',                                           [\Controllers\ControlLigneFraisForfait::class, 'store']);
$router->get('#^/lignefraisforfait/([^/]+)/([^/]+)/([^/]+)/edit$#',                 [\Controllers\ControlLigneFraisForfait::class, 'edit']);
$router->post('#^/lignefraisforfait/([^/]+)/([^/]+)/([^/]+)/edit$#',                [\Controllers\ControlLigneFraisForfait::class, 'update']);
$router->post('#^/lignefraisforfait/([^/]+)/([^/]+)/([^/]+)/delete$#',              [\Controllers\ControlLigneFraisForfait::class, 'delete']);
$router->get('#^/lignefraisforfait/([^/]+)/([^/]+)/([^/]+)$#',                      [\Controllers\ControlLigneFraisForfait::class, 'show']);

// -------------------- DISPATCH (normalisation robuste) --------------------
$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
$scriptDir  = rtrim(dirname($scriptName), '/');

$path = $uriPath;

// Enlève le sous-dossier si besoin
if ($scriptDir !== '' && $scriptDir !== '/' && str_starts_with($path, $scriptDir)) {
    $path = substr($path, strlen($scriptDir)) ?: '/';
}

// Enlève index.php si présent (nécessaire sur IONOS)
if ($path === '/index.php') {
    $path = '/';
} elseif (str_starts_with($path, '/index.php/')) {
    $path = substr($path, strlen('/index.php')) ?: '/';
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Trace
@file_put_contents($logDir . '/trace.log', "[" . date('c') . "] DISPATCH $method $path\n", FILE_APPEND);

// Dispatch + exceptions
try {
    $router->dispatch($method, $path);
    @file_put_contents($logDir . '/trace.log', "[" . date('c') . "] DISPATCH DONE\n", FILE_APPEND);
} catch (\Throwable $e) {
    @file_put_contents(
        $logDir . '/php-exception.log',
        "[" . date('c') . "] " . get_class($e) . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n" .
        $e->getTraceAsString() . "\n\n",
        FILE_APPEND
    );
    http_response_code(500);
    echo "Erreur interne.";
}
