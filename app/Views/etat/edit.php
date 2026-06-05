<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Modifier un état', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <h1><?= htmlspecialchars($title ?? 'Modifier un état', ENT_QUOTES, 'UTF-8'); ?></h1>

    <form action="/index.php/etat/<?= htmlspecialchars($etat['id'], ENT_QUOTES, 'UTF-8'); ?>/edit" method="post">
        <div class="field">
            <label for="libelle">Libellé *</label>
            <input type="text" name="libelle" id="libelle" value="<?= htmlspecialchars($old['libelle'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required autofocus>
            <?php if (!empty($errors['libelle'])): ?>
                <div class="error"><?= htmlspecialchars($errors['libelle'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>
        <div class="actions">
            <button type="submit">Enregistrer</button>
            <a href="/index.php/etat" class="btn">Annuler</a>
        </div>
    </form>
</body>
</html>
