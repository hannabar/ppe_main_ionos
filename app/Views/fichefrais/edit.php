<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Modifier une fiche de frais', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <h1><?= htmlspecialchars($title ?? 'Modifier une fiche de frais', ENT_QUOTES, 'UTF-8'); ?></h1>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form action="/index.php/fichefrais/<?= htmlspecialchars($fichefrais['IDvisiteur'], ENT_QUOTES, 'UTF-8'); ?>/<?= htmlspecialchars($fichefrais['mois'], ENT_QUOTES, 'UTF-8'); ?>/edit" method="post">
        <div class="field">
            <label>ID Visiteur</label>
            <input type="text" value="<?= htmlspecialchars($fichefrais['IDvisiteur'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" disabled>
            <small style="color:var(--gray-text)">Ce champ ne peut pas être modifié</small>
        </div>
        <div class="field">
            <label>Mois</label>
            <input type="text" value="<?= htmlspecialchars($fichefrais['mois'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" disabled>
            <small style="color:var(--gray-text)">Ce champ ne peut pas être modifié</small>
        </div>
        <div class="field">
            <label for="nbrJustificatifs">Nombre de justificatifs *</label>
            <input type="number" name="nbrJustificatifs" id="nbrJustificatifs" min="0" value="<?= htmlspecialchars($old['nbrJustificatifs'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required autofocus>
            <?php if (!empty($errors['nbrJustificatifs'])): ?>
                <div class="error"><?= htmlspecialchars($errors['nbrJustificatifs'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="montantValide">Montant validé (€) *</label>
            <input type="number" name="montantValide" id="montantValide" step="0.01" min="0" value="<?= htmlspecialchars($old['montantValide'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            <?php if (!empty($errors['montantValide'])): ?>
                <div class="error"><?= htmlspecialchars($errors['montantValide'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>
        <div class="field">
            <label for="idEtat">État</label>
            <select name="idEtat" id="idEtat" required>
                <option value="">Sélectionner un état</option>
                <?php foreach ($etat as $et): ?>
                    <option value="<?= htmlspecialchars($et['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($old['idEtat'] ?? '') == $et['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($et['libelle'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="actions">
            <button type="submit">Enregistrer</button>
            <a href="/index.php/fichefrais" class="btn">Annuler</a>
        </div>
    </form>
</body>
</html>
