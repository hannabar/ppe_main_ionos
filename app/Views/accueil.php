<?php $authPage = true; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>GSB — Accueil</title>
    <link rel="stylesheet" href="/gsb.css">
    <style>
        body {
            margin: 0;
            background: #F4F6F9;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ── */
        .accueil-nav {
            background: #0A2540;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            gap: 10px;
        }
        .accueil-nav-badge {
            width: 36px; height: 36px;
            border-radius: 9px;
            background: #0A2540;
            border: 2px solid #00BFDF;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: #00BFDF; font-weight: 600;
        }
        .accueil-nav-title {
            font-size: 14px; font-weight: 600;
            color: rgba(255,255,255,0.85);
        }

        /* ── Hero ── */
        .accueil-hero {
            background: #0A2540;
            padding: 72px 2rem;
            text-align: center;
        }
        .accueil-hero-eyebrow {
            font-size: 11px; font-weight: 600;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: #00BFDF; margin-bottom: 14px;
        }
        .accueil-hero h1 {
            font-size: 2.2rem; font-weight: 700;
            color: #fff; margin-bottom: 10px;
            line-height: 1.2;
        }
        .accueil-hero p {
            font-size: 15px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 36px;
        }
        .accueil-hero-btns {
            display: flex; gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-hero-primary {
            padding: 13px 32px;
            background: #00BFDF;
            color: #fff;
            border-radius: 10px;
            font-size: 15px; font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-hero-primary:hover { background: #009AB8; }
        .btn-hero-secondary {
            padding: 13px 32px;
            background: transparent;
            color: #fff;
            border-radius: 10px;
            border: 1.5px solid rgba(255,255,255,0.3);
            font-size: 15px; font-weight: 600;
            text-decoration: none;
            transition: border-color 0.2s;
        }
        .btn-hero-secondary:hover { border-color: rgba(255,255,255,0.6); }

        .accueil-hero { flex: 1; }
    </style>
</head>
<body>

    <nav class="accueil-nav">
        <div class="accueil-nav-badge">GSB</div>
        
    </nav>

    <div class="accueil-hero">
        <p class="accueil-hero-eyebrow">Application de gestion</p>
        <h1>Gérez vos frais<br>professionnels</h1>
        <p>Plateforme de gestion des frais pour visiteurs médicaux et comptables</p>
        <div class="accueil-hero-btns">
            <a href="/index.php/login" class="btn-hero-primary">Se connecter</a>
            <a href="/index.php/inscription" class="btn-hero-secondary">S'inscrire</a>
        </div>
    </div>



</body>
</html>