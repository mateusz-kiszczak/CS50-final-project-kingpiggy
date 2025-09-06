<?php include('includes/user-dashboard-header.php'); ?>

<section class="db-user-edit__personal-data">
		<!-- Options - START --> 
		<h2>Delete Account</h2>
		<form action="<?= 'delete-account.php?user=' . $_SESSION['username']; ?>" method="post" novalidate>
			<section class="db-user-edit__personal-data__inputs-container">
				<div class="form-input">
        			<label class=<?= isset($errors['email']) ? "form-input__label--error" : "form-input__label"; ?> for="email">Email *</label>
        			<input class=<?= isset($errors['email']) ? "form-input__input--error" : "form-input__input"; ?> type="email" name="email" id="email" value="<?= $inputs['email'] ?? '' ?>">
        			<div class="form-input__alert">
        			  <p><?= $errors['email'] ?? '' ?></p>
        			</div>
        		</div>
       			<div class="form-input">
        			<label class=<?= isset($errors['password']) ? "form-input__label--error" : "form-input__label"; ?> for="password">Password *</label>
        			<input class=<?= isset($errors['password']) ? "form-input__input--error" : "form-input__input"; ?> type="password" name="password" value="<?= $inputs['password'] ?? '' ?>">
        			<div class="form-input__alert">
        				<p><?= $errors['password'] ?? '' ?></p>
        			</div>
        		</div>
				<div class="form-input">
        			<label class=<?= isset($errors['new-password']) ? "form-input__label--error" : "form-input__label"; ?> for="new-password">Repeat Password *</label>
        			<input class=<?= isset($errors['new-password']) ? "form-input__input--error" : "form-input__input"; ?> type="password" name="new-password" value="<?= $inputs['new-password'] ?? '' ?>">
        			<div class="form-input__alert">
        				<p><?= $errors['new-password'] ?? '' ?></p>
        			</div>
        		</div>
				<input class="form-button form-button--red" type="submit" value="DELETE ACCOUNT">
			</section>
		</form>
	</section>

<?php include('includes/user-dashboard-footer.php'); ?>