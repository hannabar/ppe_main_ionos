<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Fiches Frais') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <div class="topbar">
    <h1 style="margin:0;">Liste des Fiches Frais</h1>
    <?php if ($_SESSION['role'] !== 'comptable'): ?>
        <a class="button" href="/index.php/fichefrais/create">Créer une fiche frais</a>
    <?php endif; ?>
</div>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($fichefrais)): ?>
        <p>Aucune fiche frais trouvée.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Visiteur</th><th>Mois</th><th>Nb Justificatifs</th><th>Montant Validé</th><th>Date Modif</th><th>État</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fichefrais as $fiche): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$fiche['nom']) ?></td>
                        <td><?= htmlspecialchars((string)$fiche['mois']) ?></td>
                        <td><?= htmlspecialchars((string)$fiche['nbrJustificatifs']) ?></td>
                        <td><?= htmlspecialchars(number_format($fiche['montantValide'], 2, ',', ' ')) ?> €</td>
                        <td><?= htmlspecialchars((string)$fiche['dateModif']) ?></td>
                        <td><?= htmlspecialchars((string)$fiche['LibelleEtat']) ?></td>
                        <td>
                            <a href="/index.php/fichefrais/<?= urlencode($fiche['idVisiteur']) ?>/<?= urlencode($fiche['mois']) ?>" class="btn-voir">Voir</a>
                            <?php if ($fiche['idEtat'] == 1): ?>
                                <a href="/index.php/fichefrais/<?= urlencode($fiche['idVisiteur']) ?>/<?= urlencode($fiche['mois']) ?>/edit" class="btn-modifier">Modifier</a>
                                <form method="post" action="/index.php/fichefrais/<?= urlencode($fiche['idVisiteur']) ?>/<?= urlencode($fiche['mois']) ?>/delete" style="display:inline;">
                                    <button type="submit" class="btn-supprimer" onclick="return confirm('Supprimer cette fiche frais ?');">Supprimer</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
