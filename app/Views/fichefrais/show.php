<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Fiche Frais') ?></title>
    <link rel="stylesheet" href="/PPE-main/public/gsb.css">
</head>
<body>
    <h1>Détail de la Fiche Frais</h1>

    <?php if (!empty($fichefrais)): ?>
        <div class="card">
            <p><strong>ID Visiteur :</strong> <?= htmlspecialchars($fichefrais['IDvisiteur']) ?></p>
            <p><strong>Mois :</strong> <?= htmlspecialchars($fichefrais['mois']) ?></p>
            <p><strong>Nombre de Justificatifs :</strong> <?= htmlspecialchars($fichefrais['nbrJustificatifs']) ?></p>
            <p><strong>Montant Validé :</strong> <?= htmlspecialchars(number_format($fichefrais['montantValide'], 2, ',', ' ')) ?> €</p>
            <p><strong>Date de Modification :</strong> <?= htmlspecialchars($fichefrais['dateModif']) ?></p>
            <p><strong>ID État :</strong> <?= htmlspecialchars($fichefrais['idEtat']) ?></p>
        </div>
        <a class="button" href="/fichefrais">⬅ Retour à la liste</a>
        <a class="button btn-modifier" href="/fichefrais/<?= urlencode($fichefrais['IDvisiteur']) ?>/<?= urlencode($fichefrais['mois']) ?>/edit">Modifier</a>
        <form method="post" action="/fichefrais/<?= urlencode($fichefrais['IDvisiteur']) ?>/<?= urlencode($fichefrais['mois']) ?>/delete" style="display:inline;">
            <button type="submit" class="btn-supprimer" onclick="return confirm('Supprimer cette fiche frais ?');">Supprimer</button>
        </form>
    <?php else: ?>
        <p>Fiche frais introuvable.</p>
        <a class="button" href="/fichefrais">Retour à la liste</a>
    <?php endif; ?>
</body>
</html>
