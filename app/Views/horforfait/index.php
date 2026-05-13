<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Frais HorForfait') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/PPE-main/public/gsb.css">
</head>
<body>
    <div class="topbar">
        <h1 style="margin:0;">Liste des Frais Horforfait</h1>
        <a class="button" href="/horforfait/create">Créer un horforfait</a>
    </div>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($horforfait)): ?>
        <p>Aucun horforfait trouvé.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Date</th><th>Montant</th><th>Libellé</th><th>Voir</th><th>Modifier</th><th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horforfait as $hor): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$hor['id']) ?></td>
                        <td><?= htmlspecialchars((string)$hor['date']) ?></td>
                        <td><?= htmlspecialchars((string)$hor['montant']) ?> €</td>
                        <td><?= htmlspecialchars((string)$hor['libelle']) ?></td>
                        <td><a href="/horforfait/<?= urlencode($hor['id']) ?>" class="btn-voir">Voir</a></td>
                        <td><a href="/horforfait/<?= urlencode($hor['id']) ?>/edit" class="btn-modifier">Modifier</a></td>
                        <td>
                            <form method="post" action="/horforfait/<?= urlencode($hor['id']) ?>/delete" style="display:inline;">
                                <button type="submit" class="btn-supprimer" onclick="return confirm('Supprimer ce horforfait ?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
