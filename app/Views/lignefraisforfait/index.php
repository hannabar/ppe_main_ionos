<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Lignes Frais Forfait') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <div class="topbar">
        <h1 style="margin:0;">Liste des Lignes de Frais Forfait</h1>
        <a class="button" href="/index.php/lignefraisforfait/create">Créer une ligne</a>
    </div>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($lignefraisforfait)): ?>
        <p>Aucune ligne de frais forfait trouvée.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Visiteur</th><th>Mois</th><th>Type de frais</th><th>Quantité</th><th>Voir</th><th>Modifier</th><th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lignefraisforfait as $ligne): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$ligne['nom']) ?></td>
                        <td><?= htmlspecialchars((string)$ligne['mois']) ?></td>
                        <td><?= htmlspecialchars((string)$ligne['libelleFraisForfait']) ?></td>
                        <td><?= htmlspecialchars((string)$ligne['quantite']) ?></td>
                        <td><a href="/index.php/lignefraisforfait/<?= urlencode($ligne['IDvisiteur']) ?>/<?= urlencode($ligne['mois']) ?>/<?= urlencode($ligne['IDfraisforfait']) ?>" class="btn-voir">Voir</a></td>
                        <td><a href="/index.php/lignefraisforfait/<?= urlencode($ligne['IDvisiteur']) ?>/<?= urlencode($ligne['mois']) ?>/<?= urlencode($ligne['IDfraisforfait']) ?>/edit" class="btn-modifier">Modifier</a></td>
                        <td>
                            <form method="post" action="/index.php/lignefraisforfait/<?= urlencode($ligne['IDvisiteur']) ?>/<?= urlencode($ligne['mois']) ?>/<?= urlencode($ligne['IDfraisforfait']) ?>/delete" style="display:inline;">
                                <button type="submit" class="btn-supprimer" onclick="return confirm('Supprimer cette ligne ?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
