<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Créer un horforfait', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <h1><?= htmlspecialchars($title ?? 'Créer un horforfait', ENT_QUOTES, 'UTF-8'); ?></h1>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form action="/index.php/horforfait/create" method="post">
        <div class="field">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="<?= htmlspecialchars($old['date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            <?php if (!empty($errors['date'])): ?>
                <div class="error"><?= htmlspecialchars($errors['date'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="montant">Montant</label>
            <input type="number" step="0.01" name="montant" id="montant" value="<?= htmlspecialchars($old['montant'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            <?php if (!empty($errors['montant'])): ?>
                <div class="error"><?= htmlspecialchars($errors['montant'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="libelle">Libellé</label>
            <input type="text" name="libelle" id="libelle" value="<?= htmlspecialchars($old['libelle'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            <?php if (!empty($errors['libelle'])): ?>
                <div class="error"><?= htmlspecialchars($errors['libelle'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>
        <div class="actions">
            <button type="submit">Enregistrer</button>
            <a href="/index.php/horforfait" class="btn">Annuler</a>
        </div>
    </form>
</body>
</html>
