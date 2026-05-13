<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Modifier une ligne de frais forfait', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/PPE-main/public/gsb.css">
</head>
<body>
    <h1><?= htmlspecialchars($title ?? 'Modifier une ligne de frais forfait', ENT_QUOTES, 'UTF-8'); ?></h1>

    <form action="/lignefraisforfait/<?= urlencode($lignefraisforfait['IDvisiteur']) ?>/<?= urlencode($lignefraisforfait['mois']) ?>/<?= urlencode($lignefraisforfait['IDfraisforfait']) ?>/edit" method="post">
        <div class="field">
            <label>ID Visiteur</label>
            <input type="text" value="<?= htmlspecialchars($lignefraisforfait['IDvisiteur'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            <small style="color:var(--gray-text)">Non modifiable</small>
        </div>
        <div class="field">
            <label>Mois</label>
            <input type="text" value="<?= htmlspecialchars($lignefraisforfait['mois'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            <small style="color:var(--gray-text)">Non modifiable</small>
        </div>
        <div class="field">
            <label>Type de frais forfait</label>
            <input type="text" value="<?= htmlspecialchars($lignefraisforfait['IDfraisforfait'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            <small style="color:var(--gray-text)">Non modifiable</small>
        </div>
        <div class="field">
            <label for="quantite">Quantité *</label>
            <input type="number" name="quantite" id="quantite" min="0" value="<?= htmlspecialchars((string)($old['quantite'] ?? $lignefraisforfait['quantite']), ENT_QUOTES, 'UTF-8'); ?>" required autofocus>
            <?php if (!empty($errors['quantite'])): ?>
                <div class="error"><?= htmlspecialchars($errors['quantite'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>
        <div class="actions">
            <button type="submit">Enregistrer</button>
            <a href="/lignefraisforfait" class="btn">Annuler</a>
        </div>
    </form>
</body>
</html>
