<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Créer une fiche de frais', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/PPE-main/public/gsb.css">
</head>
<body>
    <h1><?= htmlspecialchars($title ?? 'Créer une fiche de frais', ENT_QUOTES, 'UTF-8'); ?></h1>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form action="/fichefrais/create" method="post">
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
                <select name="mois_annee" id="mois_annee" required>
                    <option value="">Année</option>
                    <?php for ($a = 2026; $a >= 2000; $a--): ?>
                        <option value="<?= $a ?>" <?= ($old['mois_annee'] ?? '') == $a ? 'selected' : '' ?>><?= $a ?></option>
                    <?php endfor; ?>
                </select>
                <select name="mois_mois" id="mois_mois" required>
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
            <label for="nbrJustificatifs">Nombre de justificatifs</label>
            <input type="number" name="nbrJustificatifs" id="nbrJustificatifs" min="0" value="<?= htmlspecialchars($old['nbrJustificatifs'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>" required>
            <?php if (!empty($errors['nbrJustificatifs'])): ?>
                <div class="error"><?= htmlspecialchars($errors['nbrJustificatifs'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="montantValide">Montant validé (€)</label>
            <input type="number" name="montantValide" id="montantValide" step="0.01" min="0" value="<?= htmlspecialchars($old['montantValide'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>" required>
            <?php if (!empty($errors['montantValide'])): ?>
                <div class="error"><?= htmlspecialchars($errors['montantValide'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="idLigneFraisHorsForfait">Libelle hors forfait</label>
            <select name="idLigneFraisHorsForfait" id="idLigneFraisHorsForfait" required>
                <option value="">Sélectionner un libellé</option>
                <?php foreach ($horforfait as $hf): ?>
                    <option value="<?= htmlspecialchars($hf['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($old['idLigneFraisHorsForfait'] ?? '') == $hf['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($hf['libelle'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
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
            <a href="/fichefrais" class="btn">Annuler</a>
        </div>
    </form>
</body>
</html>
