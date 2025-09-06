<?php 
	$sql = $privateUser[0];
	$sql_profiles = $profiles[0];


	// If no user set, redirect to home page
	if (!isset($_SESSION['username'])) 
	{
		redirect('../index.php');
	} 
	elseif (!isset($sql->user_nikname) && $_SESSION['username'] !== $sql->user_nikname) 
	{
		redirect('../index.php');
	}
?>

<?php include('includes/user-dashboard-header.php'); ?>

<div class="dashboard-section-wrapper">

	<?php   
		display_all_flash_messages(); 
	?>

	<h2>Edit Profile</h2>
	<section class="db-user-edit__personal-data">
		<h3>Personal Data</h3>
		
		<!-- USERNAME CAN NOT BE CHANGED -->
		<div class="form-input">
			<div class="form-input__label">Username</div>
			<div class="form-input__input" id="db-edit-username"><?= $sql->user_nikname; ?></div>
		</div>
		
		<!-- Upload an Avatar - START -->
		<form action="<?= 'submit/upload-avatar.php?user=' . $_SESSION['username']; ?>" method="post" enctype="multipart/form-data">
			<div class="db-user-edit__personal-data__upload-avatar">
				<div class="db-user-edit__personal-data__upload-avatar--row-1">
					<div class="db-user__avatar">
						<img src="../<?= $sql->user_avatar_url; ?>" alt="User's avatar">
					</div>
					<button id="db-edit-avatar__upload" class="button-default--medium--pink">Choose Avatar</button>
					<input class="hide" type="file" name="file-to-upload" id="file-to-upload" accept="image/*">
					<input class="button-default--medium--pink form-button--red hide" type="submit" value="Upload Image" name="submit" id="submit-avatar">
				</div>
				<div class="form-input__alert">
					<p id="db-edit-avatar__file-name"></p>
					<p><?= $errors['file-to-upload'] ?? ''; ?></p>
				</div>
			</div>
		</form>
		
		<!-- Upload an Avatar - END -->
		
		<!-- Edit profile - START -->
		<form action="<?= 'edit-profile.php?user=' . $_SESSION['username']; ?>" method="post" novalidate>
			<div class="db-user-edit__personal-data__inputs-container">
				<div class="db-user-edit__personal-data__inputs-wrapper">
					<div class="form-input">
						<label class=<?= isset($errors['name']) ? "form-input__label--error" : "form-input__label"; ?> for="name">Name</label>
						<input class=<?= isset($errors['name']) ? "form-input__input--error" : "form-input__input"; ?> name="name" id="db-edit-name" type="text" value="<?= isset($errors['name']) ? $inputs['name'] : $sql->user_name; ?>">
						<div class="form-input__alert">
							<p><?= $errors['name'] ?? ''; ?></p>
						</div>
					</div>
					
					<div class="form-input">
						<label class=<?= isset($errors['surname']) ? "form-input__label--error" : "form-input__label"; ?> for="surname">Surname</label>
						<input class=<?= isset($errors['surname']) ? "form-input__input--error" : "form-input__input"; ?> name="surname" id="db-edit-surname" type="text" value="<?= isset($errors['surname']) ? $inputs['surname'] : $sql->user_surname; ?>">
						<div class="form-input__alert">
							<p><?= $errors['surname'] ?? ''; ?></p>
						</div>
					</div>
					
					<div class="form-input">
						<label class=<?= isset($errors['email']) ? "form-input__label--error" : "form-input__label"; ?> for="email">Email</label>
						<input class=<?= isset($errors['email']) ? "form-input__input--error" : "form-input__input"; ?>  name="email" id="db-edit-email" type="email" value="<?= isset($errors['email']) ? $inputs['email'] : $sql->user_email; ?>">
						<div class="form-input__alert">
							<p><?= $errors['email'] ?? ''; ?></p>
						</div>
					</div>
					
					<div class="form-input">
						<label class=<?= isset($errors['birthday']) ? "form-input__label--error" : "form-input__label"; ?> for="birthday">Date of birth</label>
						<input class=<?= isset($errors['birthday']) ? "form-input__input--error" : "form-input__input"; ?> name="birthday" id="db-edit-birthday" type="date" value="<?= isset($errors['birthday']) ? $inputs['birthday'] : $sql->user_birthday; ?>">
						<div class="form-input__alert">
							<p><?= $errors['birthday'] ?? ''; ?></p>
						</div>
					</div>
					
					<div class="form-input">
						<label class=<?= isset($errors['city']) ? "form-input__label--error" : "form-input__label"; ?> for="city">City</label>
						<input class=<?= isset($errors['city']) ? "form-input__input--error" : "form-input__input"; ?> name="city" id="db-edit-city" type="text" value="<?php
					
							if (isset($errors['city'])) 
							{
								echo $inputs['city'];
							} 
							elseif ($sql->user_location) 
							{
								echo location_str_to_arr($sql->user_location)['city'];
							}
					
						?>">
						<div class="form-input__alert">
							<p><?= $errors['city'] ?? ''; ?></p>
						</div>
					</div>

					<div class="form-input">
						<label class=<?= isset($errors['country']) ? "form-input__label--error" : "form-input__label"; ?> for="country">Country</label>
						<input class=<?= isset($errors['country']) ? "form-input__input--error" : "form-input__input"; ?> name="country" id="db-edit-country" type="text" value="<?php 

							if (isset($errors['country'])) 
							{
								echo $inputs['country'];
							} 
							elseif ($sql->user_location) 
							{
								echo location_str_to_arr($sql->user_location)['country'];
							}

						?>">
						<div class="form-input__alert">
							<p><?= $errors['country'] ?? ''; ?></p>
						</div>
					</div>
				</div>

				<div class="form-input db-user-edit__personal-data__textarea">
					<label class=<?= isset($errors['about-me']) ? "form-input__label--error" : "form-input__label"; ?> for="about-me">About me</label>
					<textarea id="edit-profile-about-me" class=<?= isset($errors['about-me']) ? "form-input__input--error" : "form-input__input"; ?> name="about-me" name="about-me" maxlength="1000" spellcheck="true"><?= isset($errors['about-me']) ? $inputs['about-me'] : $sql->user_description; ?></textarea>
					<p><span id="edit-profile-chars-value">0</span> / 1000</p>
					<div class="form-input__alert">
						<p><?= $errors['about-me'] ?? ''; ?></p>
					</div>
				</div>

			</div>
			<input class="form-button form-button--red" type="submit" value="Update Profile">
		</form>
		<!-- Edit profile - START --> 
	</section>

	<hr class="divider">

	<section class="db-user-edit__personal-data">
		<!-- Online Profiles - START --> 
		<h3>Online Profiles</h3>
		<form action="<?= 'submit/update-profiles.php?user=' . $_SESSION['username']; ?>" method="post" novalidate>
			<div class="db-user-edit__personal-data__inputs-container">
				<div class="form-input">
					<div class="form-input__wrapper">
						<label class=<?= isset($errors['facebook']) ? "form-input__label--profiles--error" : "form-input__label--profiles"; ?> for="facebook">Facebook</label>
						<input class=<?= isset($errors['facebook']) ? "form-input__input--error" : "form-input__input"; ?> name="facebook" type="text" placeholder="https://www.facebook.com/" value="<?= isset($errors['facebook']) ? $inputs['facebook'] : $sql_profiles->profile_facebook; ?>">
					</div>
					<div class="form-input__alert">
						<p><?= $errors['facebook'] ?? ''; ?></p>
					</div>
				</div>

				<div class="form-input">
					<div class="form-input__wrapper">
						<label class=<?= isset($errors['twitter']) ? "form-input__label--profiles--error" : "form-input__label--profiles"; ?> for="twitter">Twitter</label>
						<input class=<?= isset($errors['twitter']) ? "form-input__input--error" : "form-input__input"; ?> name="twitter" type="text" placeholder="https://www.x.com/" value="<?= isset($errors['twitter']) ? $inputs['twitter'] : $sql_profiles->profile_twitter; ?>">
						<div class="form-input__alert">
							<p><?= $errors['twitter'] ?? ''; ?></p>
						</div>
					</div>
				</div>

				<div class="form-input">
					<div class="form-input__wrapper">
						<label class=<?= isset($errors['instagram']) ? "form-input__label--profiles--error" : "form-input__label--profiles"; ?> for="instagram">Instagram</label>
						<input class=<?= isset($errors['instagram']) ? "form-input__input--error" : "form-input__input"; ?> name="instagram" type="text" placeholder="https://www.instagram.com/" value="<?= isset($errors['instagram']) ? $inputs['instagram'] : $sql_profiles->profile_instagram; ?>">
						<div class="form-input__alert">
							<p><?= $errors['instagram'] ?? ''; ?></p>
						</div>
					</div>
				</div>

				<div class="form-input">
					<div class="form-input__wrapper">
						<label class=<?= isset($errors['youtube']) ? "form-input__label--profiles--error" : "form-input__label--profiles"; ?> for="youtube">Youtube</label>
						<input class=<?= isset($errors['youtube']) ? "form-input__input--error" : "form-input__input"; ?> name="youtube" type="text" placeholder="https://www.youtube.com/" value="<?= isset($errors['youtube']) ? $inputs['youtube'] : $sql_profiles->profile_youtube; ?>">
						<div class="form-input__alert">
							<p><?= $errors['youtube'] ?? ''; ?></p>
						</div>
					</div>
				</div>

				<div class="form-input">
					<div class="form-input__wrapper">
						<label class=<?= isset($errors['pinterest']) ? "form-input__label--profiles--error" : "form-input__label--profiles"; ?> for="pinterest">Pinterest</label>
						<input class=<?= isset($errors['pinterest']) ? "form-input__input--error" : "form-input__input"; ?> name="pinterest" type="text" placeholder="https://www.twitter.com/" value="<?= isset($errors['pinterest']) ? $inputs['pinterest'] : $sql_profiles->profile_pinterest; ?>">
						<div class="form-input__alert">
							<p><?= $errors['pinterest'] ?? ''; ?></p>
						</div>
					</div>
				</div>

				<div class="form-input">
					<div class="form-input__wrapper">
						<label class=<?= isset($errors['website']) ? "form-input__label--profiles--error" : "form-input__label--profiles"; ?> for="website">Website</label>
						<input class=<?= isset($errors['website']) ? "form-input__input--error" : "form-input__input"; ?> name="website" type="text" placeholder="https://www.website.com/" value="<?= isset($errors['website']) ? $inputs['website'] : $sql_profiles->profile_website; ?>">
						<div class="form-input__alert">
							<p><?= $errors['website'] ?? ''; ?></p>
						</div>
					</div>
				</div>
			</div>
			<input class="form-button form-button--red" type="submit" value="Update Links">
		</form>
		<!-- Online Profiles - START --> 
	</section>

	<hr class="divider">

	<section class="db-user-edit__personal-data">
		<!-- Options - START --> 
		<h3>Options</h3>
		<form action="<?= 'submit/update-password.php?user=' . $_SESSION['username']; ?>" method="post" novalidate>
			<section class="db-user-edit__personal-data__inputs-container">
				<h4 class="db-user-edit__personal-data__inputs-container__options-header">Change password</h4>
				<div class="form-input">
        			<label class=<?= isset($errors['password']) ? "form-input__label--error" : "form-input__label"; ?> for="password">Current Password *</label>
        			<input class=<?= isset($errors['password']) ? "form-input__input--error" : "form-input__input"; ?> type="password" name="password" id="password" value="<?= $inputs['password'] ?? '' ?>">
        			<div class="form-input__alert">
        			  <p><?= $errors['password'] ?? '' ?></p>
        			</div>
        		</div>
       			<div class="form-input">
        			<label class=<?= isset($errors['new-password']) ? "form-input__label--error" : "form-input__label"; ?> for="new-password">New Password *</label>
        			<input class=<?= isset($errors['new-password']) ? "form-input__input--error" : "form-input__input"; ?> type="password" name="new-password" value="<?= $inputs['new-password'] ?? '' ?>">
        			<div class="form-input__alert">
        				<p><?= $errors['new-password'] ?? '' ?></p>
        			</div>
        		</div>
				<div class="form-input">
        			<label class=<?= isset($errors['re-new-password']) ? "form-input__label--error" : "form-input__label"; ?> for="re-new-password">Repeat New Password *</label>
        			<input class=<?= isset($errors['re-new-password']) ? "form-input__input--error" : "form-input__input"; ?> type="password" name="re-new-password" value="<?= $inputs['re-new-password'] ?? '' ?>">
        			<div class="form-input__alert">
        				<p><?= $errors['re-new-password'] ?? '' ?></p>
        			</div>
        		</div>
				<input class="form-button form-button--red" type="submit" value="Update Password">
			</section>
		</form>
		<form action="<?= 'submit/update-password.php?user=' . $_SESSION['username']; ?>" method="post" novalidate>
			<section class="db-user-edit__personal-data__inputs-container">
				<h4 class="db-user-edit__personal-data__inputs-container__options-header">Preferences</h4>
				<div class="db-user-edit__personal-data__options">
					<div class="toggle-button--off" role="button" tabindex="0" aria-label="Click to allow other users to contact me via email">
						<div></div>
					</div>
 					<input class="hide" type="checkbox" id="options-email-contact" name="email-contact"/>
 					<label for="options-email-contact">Allow other users to contact me via email</label>
 				</div>
 				<div class="db-user-edit__personal-data__options">
					<div class="toggle-button--off" role="button" tabindex="0" aria-label="Click to show in search results images with mild nudity">
						<div></div>
					</div>
 					<input class="hide" type="checkbox" id="options-mild-nudity" name="mild-nudity"/>
 					<label for="options-mild-nudity">Show in search results images with mild nudity</label>
 				</div>
			</section>
		</form>
	</section>
</div>

<?php include('includes/user-dashboard-footer.php'); ?>
