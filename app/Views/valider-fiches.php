<?php $e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Validation des fiches</title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <div class="topbar">
        <h1 style="margin:0;">Validation des fiches de frais</h1>
        <a class="button" href="/index.php/dashboard-comptable">← Retour</a>
    </div>

    <?php if (!empty($message)): ?>
        <div class="flash-success"><?= $e($message) ?></div>
    <?php endif; ?>

    <?php if (empty($fiches)): ?>
        <p>Aucune fiche de frais trouvée.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Visiteur</th>
                    <th>Mois</th>
                    <th>Justificatifs</th>
                    <th>Montant</th>
                    <th>Date modif</th>
                    <th>État actuel</th>
                    <th style="text-align:center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fiches as $fiche): ?>
                <?php
                $etats       = [1=>'Créée', 2=>'Clôturée', 3=>'Validée', 4=>'Remboursée'];
                $couleurs    = [1=>'#F4F6F9', 2=>'#FFF8E1', 3=>'#F0FFF4', 4=>'#E0F7FB'];
                $textCouleurs= [1=>'#6B7A90', 2=>'#92610a', 3=>'#166534', 4=>'#009AB8'];
                $idEtat      = (int)$fiche['idEtat'];
                ?>
                <tr>
                    <td style="font-weight:500"><?= $e((string)$fiche['nom']) ?></td>
                    <td style="color:var(--gray-text)"><?= $e((string)$fiche['mois']) ?></td>
                    <td><?= $e((string)$fiche['nbrJustificatifs']) ?></td>
                    <td><?= $e(number_format((float)$fiche['montantValide'], 2, ',', ' ')) ?> €</td>
                    <td style="color:var(--gray-text)"><?= $e((string)$fiche['dateModif']) ?></td>
                    <td>
                        <span style="background:<?= $couleurs[$idEtat] ?? '#F4F6F9' ?>;color:<?= $textCouleurs[$idEtat] ?? '#6B7A90' ?>;padding:3px 10px;border-radius:99px;font-size:12px;font-weight:500;">
                            <?= $etats[$idEtat] ?? 'Inconnu' ?>
                        </span>
                    </td>
                    <td style="text-align:center">
                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">

                            <?php if ($idEtat == 4): ?>
                                <span style="color:var(--gray-text);font-size:12px;">✓ Remboursée</span>

                            <?php else: ?>

                                <?php if ($idEtat != 3): ?>
                                <form method="post" action="/index.php/valider-fiches" style="margin:0">
                                    <input type="hidden" name="idVisiteur" value="<?= $e((string)$fiche['idVisiteur']) ?>">
                                    <input type="hidden" name="mois" value="<?= $e((string)$fiche['mois']) ?>">
                                    <input type="hidden" name="idEtat" value="3">
                                    <button type="submit" class="btn-voir" onclick="return confirm('Valider cette fiche ?')">✓ Valider</button>
                                </form>
                                <?php endif; ?>

                                <?php if ($idEtat != 2): ?>
                                <form method="post" action="/index.php/valider-fiches" style="margin:0">
                                    <input type="hidden" name="idVisiteur" value="<?= $e((string)$fiche['idVisiteur']) ?>">
                                    <input type="hidden" name="mois" value="<?= $e((string)$fiche['mois']) ?>">
                                    <input type="hidden" name="idEtat" value="2">
                                    <button type="submit" class="btn-warn" onclick="return confirm('Clôturer cette fiche ?')">✕ Clôturer</button>
                                </form>
                                <?php endif; ?>

                                <?php if ($idEtat == 3): ?>
                                <form method="post" action="/index.php/valider-fiches" style="margin:0">
                                    <input type="hidden" name="idVisiteur" value="<?= $e((string)$fiche['idVisiteur']) ?>">
                                    <input type="hidden" name="mois" value="<?= $e((string)$fiche['mois']) ?>">
                                    <input type="hidden" name="idEtat" value="4">
                                    <button type="submit" class="btn-modifier" onclick="return confirm('Marquer comme remboursée ?')">$ Rembourser</button>
                                </form>
                                <?php endif; ?>

                            <?php endif; ?>

                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>