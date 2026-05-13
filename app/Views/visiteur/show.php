<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Visiteur') ?></title>
    <link rel="stylesheet" href="/PPE-main/public/gsb.css">
</head>
<body>
    <h1>Détail des visiteurs</h1>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($visiteur)): ?>
        <div class="card">
            <p><strong>ID :</strong> <?= htmlspecialchars($visiteur['id']) ?></p>
            <p><strong>Nom :</strong> <?= htmlspecialchars($visiteur['nom']) ?></p>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($visiteur['prenom']) ?></p>
            <p><strong>Adresse :</strong> <?= htmlspecialchars($visiteur['adresse']) ?></p>
            <p><strong>Ville :</strong> <?= htmlspecialchars($visiteur['ville']) ?></p>
            <p><strong>Code Postale :</strong> <?= htmlspecialchars($visiteur['cp']) ?></p>
            <p><strong>Date embauche :</strong> <?= htmlspecialchars($visiteur['date_embauche']) ?></p>
            <p><strong>Login :</strong> <?= htmlspecialchars($visiteur['login']) ?></p>
            <p><strong>Mot de passe :</strong> <?= htmlspecialchars($visiteur['mdp']) ?></p>
        </div>
        <a class="button" href="/visiteur">⬅ Retour à la liste</a>
    <?php else: ?>
        <p>Visiteur introuvable.</p>
        <a class="button" href="/visiteur">Retour à la liste</a>
    <?php endif; ?>
</body>
</html>
