<?php $e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); ?>

<div class="auth-wrapper" style="max-width:520px;">

  <div class="auth-logo">
    <div class="auth-logo-badge"><span>gsb</span></div>
    <div class="auth-logo-info">
      <strong>Galaxy Swiss Bourdin</strong>
      <small>Gestion des frais</small>
    </div>
  </div>

  <div class="auth-card">

    <p class="auth-eyebrow">Nouveau collaborateur</p>
    <h1 class="auth-title">Créer un compte</h1>
    <p class="auth-sub">Remplissez les informations ci-dessous pour rejoindre GSB.</p>

    <?php if (!empty($message)): ?>
    <div class="auth-error">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16.5"/>
      </svg>
      <?= $e($message) ?>
    </div>
    <?php endif; ?>

    <form action="/PPE-main/public/inscription" method="post">

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
        <div class="form-group">
          <label for="nom">Nom *</label>
          <input type="text" name="nom" id="nom" value="<?= $e($old['nom'] ?? '') ?>" required autofocus>
          <?php if (!empty($errors['nom'])): ?><div class="form-error"><?= $e($errors['nom']) ?></div><?php endif; ?>
        </div>
        <div class="form-group">
          <label for="prenom">Prénom *</label>
          <input type="text" name="prenom" id="prenom" value="<?= $e($old['prenom'] ?? '') ?>" required>
          <?php if (!empty($errors['prenom'])): ?><div class="form-error"><?= $e($errors['prenom']) ?></div><?php endif; ?>
        </div>
      </div>

      <div class="form-group">
        <label for="adresse">Adresse *</label>
        <input type="text" name="adresse" id="adresse" value="<?= $e($old['adresse'] ?? '') ?>" required>
        <?php if (!empty($errors['adresse'])): ?><div class="form-error"><?= $e($errors['adresse']) ?></div><?php endif; ?>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
        <div class="form-group">
          <label for="ville">Ville *</label>
          <input type="text" name="ville" id="ville" value="<?= $e($old['ville'] ?? '') ?>" required>
          <?php if (!empty($errors['ville'])): ?><div class="form-error"><?= $e($errors['ville']) ?></div><?php endif; ?>
        </div>
        <div class="form-group">
          <label for="cp">Code postal *</label>
          <input type="text" name="cp" id="cp" value="<?= $e($old['cp'] ?? '') ?>" pattern="[0-9]{5}" required>
          <?php if (!empty($errors['cp'])): ?><div class="form-error"><?= $e($errors['cp']) ?></div><?php endif; ?>
        </div>
      </div>

      <div class="form-group">
        <label for="login">Login *</label>
        <input type="text" name="login" id="login" value="<?= $e($old['login'] ?? '') ?>" required>
        <?php if (!empty($errors['login'])): ?><div class="form-error"><?= $e($errors['login']) ?></div><?php endif; ?>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
        <div class="form-group">
          <label for="mdp">Mot de passe *</label>
          <input type="password" name="mdp" id="mdp" placeholder="••••••••" required>
          <?php if (!empty($errors['mdp'])): ?><div class="form-error"><?= $e($errors['mdp']) ?></div><?php endif; ?>
        </div>
        <div class="form-group">
          <label for="mdp_confirm">Confirmer *</label>
          <input type="password" name="mdp_confirm" id="mdp_confirm" placeholder="••••••••" required>
          <?php if (!empty($errors['mdp_confirm'])): ?><div class="form-error"><?= $e($errors['mdp_confirm']) ?></div><?php endif; ?>
        </div>
      </div>

      <button type="submit" class="btn-gsb">Créer mon compte</button>

    </form>

    <p style="font-size:13px; color:var(--gray-text); text-align:center; margin-top:1rem;">
      Déjà un compte ? <a href="/PPE-main/public/login" style="color:var(--cyan-dark); font-weight:500; text-decoration:none;">Se connecter</a>
    </p>

  </div>
</div>