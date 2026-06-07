<?php $e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion des rôles</title>
    <link rel="stylesheet" href="/gsb.css">
</head>
<body>
    <div class="topbar">
        <h1 style="margin:0;">Gestion des rôles</h1>
        <a class="button" href="/index.php/dashboard-comptable">← Retour</a>
    </div>

    <?php if (!empty($message)): ?>
        <div class="flash-success"><?= $e($message) ?></div>
    <?php endif; ?>

    <?php if (empty($visiteurs)): ?>
        <p>Aucun utilisateur trouvé.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Login</th>
                    <th>Rôle actuel</th>
                    <th style="text-align:center">Changer le rôle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visiteurs as $vis): ?>
                <tr>
                    <td style="color:var(--gray-text)">#<?= $e((string)$vis['id']) ?></td>
                    <td style="font-weight:500"><?= $e((string)$vis['nom']) ?></td>
                    <td><?= $e((string)$vis['prenom']) ?></td>
                    <td style="color:var(--gray-text)"><?= $e((string)$vis['login']) ?></td>
                    <td>
                        <?php if ($vis['role'] === 'comptable'): ?>
                            <span style="background:#E0F7FB;color:#009AB8;padding:3px 10px;border-radius:99px;font-size:12px;font-weight:500;">Comptable</span>
                        <?php else: ?>
                            <span style="background:#F4F6F9;color:#6B7A90;padding:3px 10px;border-radius:99px;font-size:12px;font-weight:500;">Visiteur</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center">
                        <?php if ($vis['role'] === 'visiteur'): ?>
                            <form method="post" action="/index.php/gestion-roles" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $e((string)$vis['id']) ?>">
                                <input type="hidden" name="role" value="comptable">
                                <button type="submit" class="btn-voir" onclick="return confirm('Passer <?= $e($vis['login']) ?> en comptable ?')">
                                    → Passer comptable
                                </button>
                            </form>
                        <?php else: ?>
                            <form method="post" action="/index.php/gestion-roles" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $e((string)$vis['id']) ?>">
                                <input type="hidden" name="role" value="visiteur">
                                <button type="submit" class="btn-warn" onclick="return confirm('Repasser <?= $e($vis['login']) ?> en visiteur ?')">
                                    → Repasser visiteur
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>