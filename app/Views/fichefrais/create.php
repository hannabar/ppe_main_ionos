<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Créer une fiche de frais', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <h1><?= htmlspecialchars($title ?? 'Créer une fiche de frais', ENT_QUOTES, 'UTF-8'); ?></h1>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form action="create" method="post">
        <div class="field">
            <label for="idVisiteur">Visiteur</label>
            <input type="text" value="<?= htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            <input type="hidden" name="idVisiteur" value="<?= htmlspecialchars($_SESSION['uid'], ENT_QUOTES, 'UTF-8') ?>">
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
    <label for="idLigneFraisHorsForfait">Libellé hors forfait</label>
    <select name="idLigneFraisHorsForfait" id="idLigneFraisHorsForfait">
        <option value="">Sélectionner un libellé</option>
        <?php foreach ($horforfait as $hf): ?>
            <option value="<?= htmlspecialchars($hf['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($old['idLigneFraisHorsForfait'] ?? '') == $hf['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($hf['libelle'], ENT_QUOTES, 'UTF-8') ?> — <?= htmlspecialchars((string)$hf['montant'], ENT_QUOTES, 'UTF-8') ?> €
            </option>
        <?php endforeach; ?>
    </select>
</div>
        <div class="field">
            <label for="idEtat">État</label>
            <input type="text" value="Créé" disabled>
            <input type="hidden" name="idEtat" value="1">
        </div>

        <!-- Champ caché pour montantValide calculé automatiquement -->
        <input type="hidden" name="montantValide" id="montantValide" value="0">

        <div class="field">
            <label>Frais forfaitaires</label>
            <table style="width:100%;border-collapse:collapse;margin-top:8px;">
                <thead>
                    <tr style="background:#0A2540;">
                        <th style="padding:10px 14px;text-align:left;color:rgba(255,255,255,0.7);font-size:11px;text-transform:uppercase;">Type de frais</th>
                        <th style="padding:10px 14px;text-align:left;color:rgba(255,255,255,0.7);font-size:11px;text-transform:uppercase;">Montant unitaire</th>
                        <th style="padding:10px 14px;text-align:left;color:rgba(255,255,255,0.7);font-size:11px;text-transform:uppercase;">Quantité</th>
                        <th style="padding:10px 14px;text-align:left;color:rgba(255,255,255,0.7);font-size:11px;text-transform:uppercase;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($forfaits as $forfait): ?>
                    <tr style="border-bottom:1px solid #DDE3EC;">
                        <td style="padding:10px 14px;font-size:14px;"><?= htmlspecialchars($forfait['libelle'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td style="padding:10px 14px;font-size:14px;color:#6B7A90;" data-montant="<?= $forfait['montant'] ?>"><?= htmlspecialchars((string)$forfait['montant'], ENT_QUOTES, 'UTF-8') ?> €</td>
                        <td style="padding:10px 14px;">
                            <input type="number"
                                   name="quantites[<?= htmlspecialchars($forfait['id'], ENT_QUOTES, 'UTF-8') ?>]"
                                   min="0" value="0"
                                   class="quantite-input"
                                   data-montant="<?= $forfait['montant'] ?>"
                                   style="width:80px;padding:6px;border:1.5px solid #DDE3EC;border-radius:6px;">
                        </td>
                        <td style="padding:10px 14px;font-size:14px;font-weight:600;" class="ligne-total">0,00 €</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background:#E0F7FB;">
                        <td colspan="3" style="padding:10px 14px;font-weight:700;font-size:14px;">Total général</td>
                        <td style="padding:10px 14px;font-weight:700;font-size:14px;color:#009AB8;" id="total-general">0,00 €</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="actions">
            <button type="submit">Enregistrer</button>
            <a href="/index.php/fichefrais" class="btn">Annuler</a>
        </div>
    </form>

    <script>
        function recalculer() {
            let total = 0;
            document.querySelectorAll('.quantite-input').forEach(function(input) {
                const montant = parseFloat(input.dataset.montant) || 0;
                const qte = parseInt(input.value) || 0;
                const ligneTotal = qte * montant;
                total += ligneTotal;
                input.closest('tr').querySelector('.ligne-total').textContent = ligneTotal.toFixed(2).replace('.', ',') + ' €';
            });
            document.getElementById('total-general').textContent = total.toFixed(2).replace('.', ',') + ' €';
            document.getElementById('montantValide').value = total.toFixed(2);
        }

        document.querySelectorAll('.quantite-input').forEach(function(input) {
            input.addEventListener('input', recalculer);
        });
    </script>
</body>
</html>