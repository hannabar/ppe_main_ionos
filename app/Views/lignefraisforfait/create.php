<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Créer une ligne de frais forfait', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <h1><?= htmlspecialchars($title ?? 'Créer une ligne de frais forfait', ENT_QUOTES, 'UTF-8'); ?></h1>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <?php if (!empty($errors['general'])): ?>
        <div class="flash"><?= htmlspecialchars($errors['general'], ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form action="index.php/create" method="post">
        <div class="field">
            <label for="idVisiteur">Visiteur</label>
            <select name="idVisiteur" id="idVisiteur" required>
                <option value="">Sélectionner un visiteur</option>
                <?php foreach ($visiteurs as $visiteur): ?>
                    <option value="<?= htmlspecialchars($visiteur['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($old['idVisiteur'] ?? '') == $visiteur['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($visiteur['nom'] . ' ' . $visiteur['prenom'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['idVisiteur'])): ?>
                <div class="error"><?= htmlspecialchars($errors['idVisiteur'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label>Mois</label>
            <div style="display:flex; gap:1rem;">
                <select name="mois_annee" required>
                    <option value="">Année</option>
                    <?php for ($a = 2026; $a >= 2000; $a--): ?>
                        <option value="<?= $a ?>" <?= ($old['mois_annee'] ?? '') == $a ? 'selected' : '' ?>><?= $a ?></option>
                    <?php endfor; ?>
                </select>
                <select name="mois_mois" required>
                    <option value="">Mois</option>
                    <?php
                    $moisLettres = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
                    foreach ($moisLettres as $i => $libelle):
                        $val = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                        <option value="<?= $val ?>" <?= ($old['mois_mois'] ?? '') == $val ? 'selected' : '' ?>><?= $libelle ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if (!empty($errors['mois'])): ?>
                <div class="error"><?= htmlspecialchars($errors['mois'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="idFraisForfait">Type de frais forfait</label>
            <select name="idFraisForfait" id="idFraisForfait" required>
                <option value="">Sélectionner un type</option>
                <?php foreach ($fraisforfait as $ff): ?>
                    <option value="<?= htmlspecialchars($ff['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($old['idFraisForfait'] ?? '') == $ff['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($ff['libelle'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['idFraisForfait'])): ?>
                <div class="error"><?= htmlspecialchars($errors['idFraisForfait'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="quantite">Quantité</label>
            <input type="number" name="quantite" id="quantite" min="0" value="<?= htmlspecialchars((string)($old['quantite'] ?? '0'), ENT_QUOTES, 'UTF-8'); ?>" required>
            <?php if (!empty($errors['quantite'])): ?>
                <div class="error"><?= htmlspecialchars($errors['quantite'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>

        <div class="actions">
            <button type="submit">Enregistrer</button>
            <a href="/index.php/lignefraisforfait" class="btn">Annuler</a>
        </div>
    </form>
</body>
</html>
