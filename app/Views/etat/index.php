<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'États') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <div class="topbar">
        <h1 style="margin:0;">Liste des États</h1>
        <a class="button" href="/index.php/etat/create">Créer un état</a>
    </div>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($etats)): ?>
        <p>Aucun état trouvé.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Libellé</th>
                    <th>Voir</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etats as $et): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$et['id']) ?></td>
                        <td><?= htmlspecialchars((string)$et['libelle']) ?></td>
                        <td><a href="/index.php/etat/<?= urlencode($et['id']) ?>" class="btn-voir">Voir</a></td>
                        <td><a href="/index.php/etat/<?= urlencode($et['id']) ?>/edit" class="btn-modifier">Modifier</a></td>
                        <td>
                            <form method="post" action="/index.php/etat/<?= urlencode($et['id']) ?>/delete" style="display:inline;">
                                <button type="submit" class="btn-supprimer" onclick="return confirm('Supprimer cet état ?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
