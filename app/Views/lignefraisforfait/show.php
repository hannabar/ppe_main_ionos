<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Ligne Frais Forfait') ?></title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <h1>Détail de la Ligne de Frais Forfait</h1>

    <?php if (!empty($lignefraisforfait)): ?>
        <div class="card">
            <p><strong>ID Visiteur :</strong> <?= htmlspecialchars($lignefraisforfait['IDvisiteur']) ?></p>
            <p><strong>Mois :</strong> <?= htmlspecialchars($lignefraisforfait['mois']) ?></p>
            <p><strong>Type de frais :</strong> <?= htmlspecialchars($lignefraisforfait['IDfraisforfait']) ?></p>
            <p><strong>Quantité :</strong> <?= htmlspecialchars($lignefraisforfait['quantite']) ?></p>
        </div>
        <a class="button" href="/index.php/lignefraisforfait">⬅ Retour à la liste</a>
        <a class="button btn-modifier" href="/index.php/lignefraisforfait/<?= urlencode($lignefraisforfait['IDvisiteur']) ?>/<?= urlencode($lignefraisforfait['mois']) ?>/<?= urlencode($lignefraisforfait['IDfraisforfait']) ?>/edit">Modifier</a>
        <form method="post" action="/index.php/lignefraisforfait/<?= urlencode($lignefraisforfait['IDvisiteur']) ?>/<?= urlencode($lignefraisforfait['mois']) ?>/<?= urlencode($lignefraisforfait['IDfraisforfait']) ?>/delete" style="display:inline;">
            <button type="submit" class="btn-supprimer" onclick="return confirm('Supprimer cette ligne ?');">Supprimer</button>
        </form>
    <?php else: ?>
        <p>Ligne introuvable.</p>
        <a class="button" href="/index.php/lignefraisforfait">Retour à la liste</a>
    <?php endif; ?>
</body>
</html>
