<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Modifier un visiteur', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/PPE-main/public/gsb.css">
</head>
<body>

    <h1><?= htmlspecialchars($title ?? 'Modifier un visiteur', ENT_QUOTES, 'UTF-8'); ?></h1>

    <form action="/PPE-main/public/visiteur/<?= htmlspecialchars($visiteur['id'], ENT_QUOTES, 'UTF-8') ?>/edit" method="post">
        
        <div class="field">
            <label for="adresse">Adresse *</label>
            <input type="text" name="adresse" id="adresse" value="<?= htmlspecialchars($old['adresse'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required autofocus>
            <?php if (!empty($errors['adresse'])): ?>
                <div class="error"><?= htmlspecialchars($errors['adresse'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="ville">Ville *</label>
            <input type="text" name="ville" id="ville" value="<?= htmlspecialchars($old['ville'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            <?php if (!empty($errors['ville'])): ?>
                <div class="error"><?= htmlspecialchars($errors['ville'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="cp">Code postal *</label>
            <input type="text" name="cp" id="cp" value="<?= htmlspecialchars($old['cp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            <?php if (!empty($errors['cp'])): ?>
                <div class="error"><?= htmlspecialchars($errors['cp'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>

        <div class="actions">
            <button type="submit">Enregistrer</button>
            <a href="/visiteur" class="btn">Annuler</a>
        </div>
    </form>

</body>
</html>
