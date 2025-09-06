<!-- Header -->
<?php 
  view('header', ['title' => 'Login']);
  
?>
<main>
  <?php   
    display_all_flash_messages(); 
  ?>
  
  <div class="register-form-wrapper">
    <header>
      <h1>Log In</h1>
      <p>Already a member? Login and continue to your account.</p>
    </header>
    
    
    <form class="login-form" action="login.php" method="post">
      <!-- Error message - START -->
        <?php if (isset($errors['login'])) : ?>
        
          <div class="alert--error">
              <?= $errors['login'] ?>
          </div>
        
        <?php endif ?>
      <!-- Error message - END -->

      <div class="register-form__inputs-container">
        <div class="form-input">
            <label class=<?= isset($errors['username']) ? "form-input__label--error" : "form-input__label"; ?> for="username">Username:</label>
            <input class=<?= isset($errors['username']) ? "form-input__input--error" : "form-input__input"; ?> type="text" name="username" id="username" value="<?= $inputs['username'] ?? '' ?>">
            <div class="form-input__alert">
              <p><?= $errors['username'] ?? '' ?></p>
            </div>
        </div>
        <div class="form-input">
            <label class=<?= isset($errors['password']) ? "form-input__label--error" : "form-input__label"; ?> for="password">Password:</label>
            <input class=<?= isset($errors['password']) ? "form-input__input--error" : "form-input__input"; ?> type="password" name="password" id="password" value="<?= $inputs['password'] ?? '' ?>">
            <div class="form-input__alert">
              <p><?= $errors['password'] ?? '' ?></p>
            </div>
        </div>
        <button class="form-button form-button--red form-button--register" type="submit">Login</button>
        <footer>Don't have an account? <a class="register-form__login-link" href="register.php">Register</a></footer>
      </div>
    </form>
  </div>
</main>

<!-- Footer -->
<?php include('includes/footer.php'); ?>
