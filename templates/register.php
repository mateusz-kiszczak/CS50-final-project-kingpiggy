<!-- Header -->
<?php 
  view('header', ['title' => 'Register']);
?>

<main>
  <div class="register-form-wrapper">
    <header>
      <h1>Sign Up</h1>
      <p>Become a Kingpiggy member, download and upload images. No worries, it's all FREE!</p>
    </header>
    <form class="register-form" action="register.php" method="post">
      <div class="register-form__inputs-container">
        <div class="form-input">
          <label class=<?= isset($errors['username']) ? "form-input__label--error" : "form-input__label"; ?> for="username">Username</label>
          <input class=<?= isset($errors['username']) ? "form-input__input--error" : "form-input__input"; ?> type="text" name="username" id="username" value="<?= $inputs['username'] ?? '' ?>">
          <div class="form-input__alert">
            <p><?= $errors['username'] ?? '' ?></p>
          </div>
        </div>
        <div class="form-input">
          <label class=<?= isset($errors['email']) ? "form-input__label--error" : "form-input__label"; ?> for="email">Email</label>
          <input class=<?= isset($errors['email']) ? "form-input__input--error" : "form-input__input"; ?> type="email" name="email" id="email" value="<?= $inputs['email'] ?? '' ?>">
          <div class="form-input__alert">
            <p><?= $errors['email'] ?? '' ?></p>
          </div>
        </div>
        <div class="form-input">
          <label class=<?= isset($errors['password']) ? "form-input__label--error" : "form-input__label"; ?> for="password">Password</label>
          <input class=<?= isset($errors['password']) ? "form-input__input--error" : "form-input__input"; ?> type="password" name="password" id="password" value="<?= $inputs['password'] ?? '' ?>">
          <div class="form-input__alert">
            <p><?= $errors['password'] ?? '' ?></p>
          </div>
        </div>
        <div class="form-input">
          <label class=<?= isset($errors['password2']) ? "form-input__label--error" : "form-input__label"; ?> for="password2">Repeat Password</label>
          <input class=<?= isset($errors['password2']) ? "form-input__input--error" : "form-input__input"; ?> type="password" name="password2" id="password2" value="<?= $inputs['password2'] ?? '' ?>">
          <div class="form-input__alert">
            <p><?= $errors['password2'] ?? '' ?></p>
          </div>
        </div>
        <div class="form-checkbox">
          <div class="form-checkbox__input-wrapper">
            <input class="form-checkbox__input" type="checkbox" name="agree" id="agree" value="checked" <?= $inputs['agree'] ?? '' ?>/>
            <label for="agree">I agree with the <a class="register-form__terms-link" href="terms-and-conditions.php" title="term of services">terms and conditions of services</a></label>
          </div>

            <!-- Error message - START -->
            <?php if (isset($errors['agree'])) : ?>

              <div class="alert--error">
                  <?= $errors['agree'] ?>
              </div>

            <?php endif ?>
            <!-- Error message - END -->

        </div>
      </div>
      <button class="form-button form-button--red form-button--register" type="submit">Register</button>
      <footer>Already a member? <a class="register-form__login-link" href="login.php">Login here</a></footer>
    </form>
  </div>
</main>

<!-- Footer -->
<?php include('includes/footer.php'); ?>
