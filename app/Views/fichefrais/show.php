<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Fiche Frais') ?></title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>

<?php
// Calcul des totaux
$totalForfait = 0;

if (!empty($lignesForfait)) {
    foreach ($lignesForfait as $ligne) {
        $montantUnitaire = $ligne['montant'] ?? 0;
        $totalForfait += $ligne['quantite'] * $montantUnitaire;
    }
}

$montantHorsForfait = $fichefrais['montanthorforfait'] ?? 0;
$montantTotal = $totalForfait + $montantHorsForfait;
?>

<h1>Détail de la Fiche Frais</h1>

<?php if (!empty($message)): ?>
    <div class="flash">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if (!empty($fichefrais)): ?>

    <div style="display:flex; gap:2rem; align-items:flex-start; flex-wrap:wrap;">

        <!-- Informations générales -->
        <div style="flex:1; min-width:280px;">
            <h2 style="font-size:16px; margin-bottom:0.8rem;">Informations</h2>

            <table>
                <thead>
                    <tr>
                        <th>Champ</th>
                        <th>Valeur</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><strong>Visiteur</strong></td>
                        <td>
                            <?= htmlspecialchars($fichefrais['nom'] . ' ' . $fichefrais['prenom']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Mois</strong></td>
                        <td><?= htmlspecialchars($fichefrais['mois']) ?></td>
                    </tr>

                    <tr>
                        <td><strong>Date de modification</strong></td>
                        <td><?= htmlspecialchars($fichefrais['dateModif']) ?></td>
                    </tr>

                    <tr>
                        <td><strong>État</strong></td>
                        <td><?= htmlspecialchars($fichefrais['LibelleEtat']) ?></td>
                    </tr>

                    <?php if (!empty($fichefrais['LibelleHorForfait'])): ?>
                        <tr>
                            <td><strong>Hors forfait</strong></td>
                            <td><?= htmlspecialchars($fichefrais['LibelleHorForfait']) ?></td>
                        </tr>

                        <tr>
                            <td><strong>Montant hors forfait</strong></td>
                            <td>
                                <?= number_format($montantHorsForfait, 2, ',', ' ') ?> €
                            </td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td><strong>Justificatifs</strong></td>
                        <td><?= htmlspecialchars($fichefrais['nbrJustificatifs']) ?></td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr style="background:var(--cyan-light);">
                        <td style="padding:12px 16px; font-weight:700;">
                            Montant Total
                        </td>
                        <td style="padding:12px 16px; font-weight:700; color:var(--cyan-dark);">
                            <?= number_format($montantTotal, 2, ',', ' ') ?> €
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Frais forfaitaires -->
        <div style="flex:1; min-width:280px;">
            <h2 style="font-size:16px; margin-bottom:0.8rem;">
                Frais forfaitaires
            </h2>

            <?php if (!empty($lignesForfait)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Type de frais</th>
                            <th>Qté</th>
                            <th>Montant unit.</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($lignesForfait as $ligne): ?>

                            <?php
                            $montantUnitaire = $ligne['montant'] ?? 0;
                            $totalLigne = $ligne['quantite'] * $montantUnitaire;
                            ?>

                            <tr>
                                <td>
                                    <?= htmlspecialchars($ligne['libelleFraisForfait']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($ligne['quantite']) ?>
                                </td>

                                <td>
                                    <?= number_format($montantUnitaire, 2, ',', ' ') ?> €
                                </td>

                                <td>
                                    <?= number_format($totalLigne, 2, ',', ' ') ?> €
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr style="background:var(--cyan-light);">
                            <td colspan="3" style="padding:12px 16px; font-weight:700;">
                                Total forfaitaire
                            </td>

                            <td style="padding:12px 16px; font-weight:700; color:var(--cyan-dark);">
                                <?= number_format($totalForfait, 2, ',', ' ') ?> €
                            </td>
                        </tr>
                    </tfoot>
                </table>

            <?php else: ?>
                <p style="color:var(--gray-text);">
                    Aucun frais forfaitaire.
                </p>
            <?php endif; ?>
        </div>

    </div>

    <!-- Boutons -->
    <div style="margin-top:2rem; display:flex; gap:8px; flex-wrap:wrap;">
        <a class="button" href="/index.php/fichefrais">
            ⬅ Retour à la liste
        </a>

        <?php if (
            isset($_SESSION['role']) &&
            $_SESSION['role'] === 'comptable' &&
            $fichefrais['idEtat'] == 1
        ): ?>

            <a
                class="button btn-modifier"
                href="/index.php/fichefrais/<?= urlencode($fichefrais['IDvisiteur']) ?>/<?= urlencode($fichefrais['mois']) ?>/edit">
                Modifier
            </a>

            <form
                method="post"
                action="/index.php/fichefrais/<?= urlencode($fichefrais['IDvisiteur']) ?>/<?= urlencode($fichefrais['mois']) ?>/delete"
                style="display:inline;">

                <button
                    type="submit"
                    class="btn-supprimer"
                    onclick="return confirm('Supprimer cette fiche frais ?');">
                    Supprimer
                </button>

            </form>

        <?php endif; ?>
    </div>

<?php else: ?>

    <p>Fiche frais introuvable.</p>

    <a class="button" href="/index.php/fichefrais">
        Retour à la liste
    </a>

<?php endif; ?>

</body>
</html>