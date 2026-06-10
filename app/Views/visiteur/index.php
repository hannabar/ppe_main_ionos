<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'visiteur') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <div class="topbar">
        <h1 style="margin:0;">Liste des Visiteurs</h1>
        <a class="button" href="/index.php/visiteur/create">Créer un visiteur</a>
    </div>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($visiteur)): ?>
        <p>Aucun visiteur trouvé.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>Code Postale</th>
                    <th>Date d'embauche</th>
                    <th>Login</th>
                    <th>Voir</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                    <th>Modifier MDP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visiteur as $vis): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$vis['id']) ?></td>
                        <td><?= htmlspecialchars((string)$vis['nom']) ?></td>
                        <td><?= htmlspecialchars((string)$vis['prenom']) ?></td>
                        <td><?= htmlspecialchars((string)$vis['adresse']) ?></td>
                        <td><?= htmlspecialchars((string)$vis['ville']) ?></td>
                        <td><?= htmlspecialchars((string)$vis['cp']) ?></td>
                        <td><?= htmlspecialchars((string)$vis['date_embauche']) ?></td>
                        <td><?= htmlspecialchars((string)$vis['login']) ?></td>
                        <td><a href="/index.php/visiteur/<?= urlencode($vis['id']) ?>" class="btn-voir">Voir</a></td>
                        <td><a href="/index.php/visiteur/<?= urlencode($vis['id']) ?>/edit" class="btn-modifier">Modifier</a></td>
                        <td>
                            <form method="post" action="/index.php/visiteur/<?= urlencode($vis['id']) ?>/delete" style="display:inline;">
                                <button type="submit" class="btn-supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce visiteur ?');">Supprimer</button>
                            </form>
                        </td>
                        <td><a href="/index.php/visiteur/<?= $vis['id'] ?>/modifier-mdp" class="btn-mdp">Modifier MDP</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
