<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Frais Forfait') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <div class="topbar">
        <h1 style="margin:0;">Liste des Frais de forfait</h1>
        <?php if ($_SESSION['role'] === 'comptable'): ?>
            <a class="button" href="/index.php/forfait/create">Créer un forfait</a>
        <?php endif; ?>
    </div>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($forfait)): ?>
        <p>Aucun frais de forfait trouvé.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Libellé</th><th>Montant</th>
                    <?php if ($_SESSION['role'] === 'comptable'): ?>
                        <th>ID</th><th>Voir</th><th>Modifier</th><th>Supprimer</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($forfait as $for): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$for['libelle']) ?></td>
                        <td><?= htmlspecialchars((string)$for['montant']) ?> €</td>
                        <?php if ($_SESSION['role'] === 'comptable'): ?>
                            <td><?= htmlspecialchars((string)$for['id']) ?></td>
                            <td><a href="/index.php/forfait/<?= urlencode($for['id']) ?>" class="btn-voir">Voir</a></td>
                            <td><a href="/index.php/forfait/<?= urlencode($for['id']) ?>/edit" class="btn-modifier">Modifier</a></td>
                            <td>
                                <form method="post" action="/index.php/forfait/<?= urlencode($for['id']) ?>/delete" style="display:inline;">
                                    <button type="submit" class="btn-supprimer" onclick="return confirm('Supprimer ce forfait ?');">Supprimer</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>