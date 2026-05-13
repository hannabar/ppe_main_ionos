<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Dashboard Comptable</title>
    <link rel="stylesheet" href="/PPE-main/public/gsb.css">
</head>
<body>
    <h1>Espace Comptable</h1>
    <p>Bienvenue <?= htmlspecialchars($username) ?> — vous êtes connecté en tant que comptable.</p>

    <div class="topbar" style="margin-top:2rem">
        <a class="button" href="/PPE-main/public/fichefrais">Valider les fiches de frais</a>
        <a class="button" href="/PPE-main/public/visiteur">Gérer les visiteurs</a>
        <a class="button" href="/PPE-main/public/logout">Se déconnecter</a>
    </div>
</body>
</html>