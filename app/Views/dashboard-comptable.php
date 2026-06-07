<?php $e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Dashboard Comptable</title>
    <link rel="stylesheet" href="/gsb.css">
    <style>
        body { margin: 0; background: #F4F6F9; }
        .dash-hero { background: #0A2540; border-radius: 16px; padding: 2rem 2.5rem; margin-bottom: 2rem; position: relative; overflow: hidden; }
        .dash-hero::before { content: ''; position: absolute; top: -60px; right: -60px; width: 260px; height: 260px; border-radius: 50%; background: rgba(0,191,223,0.07); }
        .dash-hero-eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: #00BFDF; margin-bottom: 8px; }
        .dash-hero h2 { font-family: var(--font-display, serif); font-size: 26px; color: #fff; margin-bottom: 5px; }
        .dash-hero p { font-size: 13.5px; color: rgba(255,255,255,0.5); }
        .badge-comptable { display: inline-block; background: #E0F7FB; color: #009AB8; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 99px; margin-bottom: 10px; }
        .dash-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .dash-card { background: #fff; border-radius: 14px; border: 1px solid #DDE3EC; padding: 1.5rem; text-decoration: none; transition: box-shadow 0.2s, transform 0.15s; display: block; }
        .dash-card:hover { box-shadow: 0 4px 20px rgba(10,37,64,0.08); transform: translateY(-2px); }
        .dash-card-icon { width: 38px; height: 38px; border-radius: 9px; background: #E0F7FB; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
        .dash-card-title { font-size: 14px; font-weight: 600; color: #0A2540; margin-bottom: 4px; }
        .dash-card-desc { font-size: 12.5px; color: #6B7A90; line-height: 1.5; }
        .dash-main { max-width: 1100px; margin: 0 auto; padding: 2.5rem 2rem; }
    </style>
</head>
<body>

<nav class="dash-nav">
    <div class="dash-nav-left" style="display:flex;align-items:center;gap:1.5rem;">
        <a href="/index.php/dashboard-comptable" class="dash-nav-logo" style="display:flex;align-items:center;gap:9px;text-decoration:none;">
            <div class="dash-nav-logo-badge" style="width:36px;height:36px;border-radius:9px;background:#0A2540;border:2px solid #00BFDF;display:flex;align-items:center;justify-content:center;">
                <span style="font-size:13px;color:#00BFDF;font-weight:600;">gsb</span>
            </div>
            <strong style="font-size:13px;font-weight:600;color:#0A2540;">GSB</strong>
        </a>
        <div style="display:flex;gap:4px;">
            <a href="/index.php/dashboard-comptable" style="font-size:13px;font-weight:500;color:#009AB8;background:#E0F7FB;padding:6px 11px;border-radius:7px;text-decoration:none;">Accueil</a>
            <a href="/index.php/valider-fiches" style="font-size:13px;font-weight:500;color:#6B7A90;padding:6px 11px;border-radius:7px;text-decoration:none;">Valider les fiches</a>
            <a href="/index.php/visiteur" style="font-size:13px;font-weight:500;color:#6B7A90;padding:6px 11px;border-radius:7px;text-decoration:none;">Visiteurs</a>
            <a href="/index.php/gestion-roles" style="font-size:13px;font-weight:500;color:#6B7A90;padding:6px 11px;border-radius:7px;text-decoration:none;">Gestion des rôles</a>
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
        <span style="background:#E0F7FB;color:#009AB8;font-size:11px;font-weight:600;padding:3px 10px;border-radius:99px;">Comptable</span>
        <div style="width:30px;height:30px;border-radius:50%;background:#0A2540;color:#00BFDF;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;"><?= strtoupper(substr($username, 0, 1)) ?></div>
        <span style="font-size:13px;font-weight:500;color:#0A2540;"><?= $e($username) ?></span>
        <a href="/index.php/logout" style="font-size:12.5px;color:#6B7A90;text-decoration:none;padding:6px 12px;border:1px solid #DDE3EC;border-radius:7px;">Se déconnecter</a>
    </div>
</nav>

<div class="dash-main">
    <div class="dash-hero">
        <span class="badge-comptable">Espace comptable</span>
        <h2>Bonjour, <?= $e($username) ?></h2>
        <p>Gérez et validez les fiches de frais des visiteurs médicaux.</p>
    </div>

    <div class="dash-cards">
        <a href="/index.php/valider-fiches" class="dash-card">
            <div class="dash-card-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#009AB8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 4 12 14.01 9 11.01"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            </div>
            <p class="dash-card-title">Valider les fiches</p>
            <p class="dash-card-desc">Valider, clôturer ou rembourser les fiches de frais des visiteurs.</p>
        </a>
        <a href="/index.php/visiteur" class="dash-card">
            <div class="dash-card-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#009AB8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <p class="dash-card-title">Gérer les visiteurs</p>
            <p class="dash-card-desc">Consulter et administrer les comptes des visiteurs médicaux.</p>
        </a>
        <a href="/index.php/gestion-roles" class="dash-card">
            <div class="dash-card-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#009AB8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
            </div>
            <p class="dash-card-title">Gestion des rôles</p>
            <p class="dash-card-desc">Attribuer ou retirer le rôle comptable aux utilisateurs.</p>
        </a>
        <a href="/index.php/fichefrais" class="dash-card">
            <div class="dash-card-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#009AB8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <p class="dash-card-title">Toutes les fiches</p>
            <p class="dash-card-desc">Consulter l'ensemble des fiches de frais.</p>
        </a>
    </div>
</div>

</body>
</html>