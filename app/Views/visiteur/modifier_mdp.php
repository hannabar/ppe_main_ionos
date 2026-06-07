<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le mot de passe</title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>

<div class="card" style="margin: 2rem auto;">
    <h1> Modifier le mot de passe</h1>

    <div class="flash-success" style="margin-top:1rem">
        <p><strong>Nom :</strong> <?= htmlspecialchars($visiteur['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($visiteur['prenom']) ?></p>
        <p><strong>Login :</strong> <?= htmlspecialchars($visiteur['login']) ?></p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="flash-success">✓ <?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($erreur)): ?>
        <div class="flash">✗ <?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="field">
            <label for="nouveau_mdp">Nouveau mot de passe</label>
            <input type="password" id="nouveau_mdp" name="nouveau_mdp" required>
            <small style="color:var(--gray-text);font-size:12px">Minimum 6 caractères</small>
        </div>

        <div class="field">
            <label for="confirmation_mdp">Confirmer le mot de passe</label>
            <input type="password" id="confirmation_mdp" name="confirmation_mdp" required>
        </div>

        <div class="actions">
            <button type="submit"> Enregistrer</button>
            <a href="/index.php/visiteur" class="btn">↩ Annuler</a>
        </div>
    </form>
</div>

</body>
</html>
