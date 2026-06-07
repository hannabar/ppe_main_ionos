<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Frais de forfait') ?></title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <h1>Détail des frais de forfaits</h1>

    <?php if (!empty($forfait)): ?>
        <div class="card">
            <p><strong>ID :</strong> <?= htmlspecialchars($forfait['id']) ?></p>
            <p><strong>Libellé :</strong> <?= htmlspecialchars($forfait['libelle']) ?></p>
            <p><strong>Montant :</strong> <?= htmlspecialchars($forfait['montant']) ?> €</p>
        </div>
        <a class="button" href="/index.php/forfait">⬅ Retour à la liste</a>
    <?php else: ?>
        <p>Forfait introuvable.</p>
        <a class="button" href="/index.php/forfait">Retour à la liste</a>
    <?php endif; ?>
</body>
</html>
