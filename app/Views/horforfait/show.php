<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Frais horforfait') ?></title>
    <link rel="stylesheet" href="/PPE-main/public/gsb.css">
</head>
<body>
    <h1>Détail des frais horforfaits</h1>

    <?php if (!empty($horforfait)): ?>
        <div class="card">
            <p><strong>ID :</strong> <?= htmlspecialchars($horforfait['id']) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($horforfait['date']) ?></p>
            <p><strong>Montant :</strong> <?= htmlspecialchars($horforfait['montant']) ?> €</p>
            <p><strong>Libellé :</strong> <?= htmlspecialchars($horforfait['libelle']) ?></p>
        </div>
        <a class="button" href="/horforfait">⬅ Retour à la liste</a>
    <?php else: ?>
        <p>Horforfait introuvable.</p>
        <a class="button" href="/horforfait">Retour à la liste</a>
    <?php endif; ?>
</body>
</html>
