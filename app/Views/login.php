<?php
$e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>

<div class="auth-wrapper">

  <div class="auth-logo">
    <div class="auth-logo-badge"><span>gsb</span></div>
    <div class="auth-logo-info">
      <small>Gestion des frais</small>
    </div>
  </div>

  <div class="auth-card">

    <p class="auth-eyebrow">Espace collaborateur</p>
    <h1 class="auth-title">Connectez-vous</h1>
    <p class="auth-sub">Accédez à votre espace de gestion des frais.</p>

    <?php if (!empty($message)): ?>
    <div class="auth-error">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16.5"/>
      </svg>
      <?= $e($message) ?>
    </div>
    <?php endif; ?>

    <form method="post" action="/index.php/auth">

      <div class="form-group">
        <label for="username">Identifiant</label>
        <input type="text" id="username" name="username" placeholder="prenom.nom" required autofocus>
      </div>

      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
      </div>

      <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">

      <button type="submit" class="btn-gsb">Se connecter</button>

    </form>

    <div class="auth-security">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#009AB8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
      <span>Connexion sécurisée — vos données sont protégées</span>
    </div>

  </div>
</div>