<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'État') ?></title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <h1>Détail de l'état</h1>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($etat)): ?>
        <div class="card">
            <p><strong>ID :</strong> <?= htmlspecialchars($etat['id']) ?></p>
            <p><strong>Libellé :</strong> <?= htmlspecialchars($etat['libelle']) ?></p>
        </div>
        <a class="button" href="/index.php/etat">⬅ Retour à la liste</a>
    <?php else: ?>
        <p>État introuvable.</p>
        <a class="button" href="/index.php/etat">Retour à la liste</a>
    <?php endif; ?>
</body>
</html>
