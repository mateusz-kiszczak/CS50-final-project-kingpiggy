<?php
 
$sql_user = $privateUser[0];

// If no user set, redirect to home page
if (!isset($_SESSION['username'])) 
{
	redirect('../index.php');
} 
elseif (!isset($sql_user->user_nikname) && $_SESSION['username'] !== $sql_user->user_nikname) 
{
	redirect('../index.php');
}

 	 // Calculate User allowance
	$user_allowance = $sql_user->user_allowance;
	$allowance_left = $user_allowance - $sql_user->user_images_uploaded;
?>

<!-- Includes -->
<?php include('includes/user-dashboard-header.php'); ?>

<div class="dashboard-section-wrapper">

  <?php   
	display_all_flash_messages(); 
  ?>
  
	<h2 id="upload">Upload Image</h2>
	<section>
		<a class="db-user-upload__license-link" href="../license.php">Learn more about our license</a>
		<div class="db-user-upload__upload-file-section">
	  		<div class="db-user-upload__upload-file-section__drag-and-drop">
				<h3>Drag & Drop OR</h3>
				<div class="db-user-upload__upload-file-section__buttons">
			  		<button id="db-user-upload__upload" class="form-button form-button--pink upload-button">Browse File</button>
			  		<button id="db-user-upload__submit" class="form-button form-button--red upload-button hide">Upload Image</button>
				</div>
				<div>
				  <h4 id="db-user-upload__file-name" class="hide">File: <span></span></h4>
				</div>
				<form id="db-user-upload-form" enctype="multipart/form-data" action="<?= 'upload-image.php?user=' . $_SESSION['username']; ?>" method="post" class="db-user-upload__upload-file-section__form <?= $errors ? '' : 'hide' ?>" autocomplete="off">
			  		<label class="hide" for="file">Select a file:</label>
			  		<input type="file" id="image-to-upload" name="image-to-upload" accept="image/png, image/jpeg, image/gif, image/svg+xml, image/webp" class="hide">
			  		<button id="submit-image" class="hide" type="submit">Upload</button>
			  		<div class="form-input__alert--db-upload--img">
						<p><?= $errors['image-to-upload'] ?? ''; ?></p>
			  		</div>

					<!-- Image info form - START -->
					<div class="db-user-upload__image-info__inputs-container">
						<div class="form-input--db-upload">
						  	<label class=<?= isset($errors['name']) ? "form-input__label--db-upload--error" : "form-input__label--db-upload"; ?> for="name">Name *</label>
						  	<input class=<?= isset($errors['name']) ? "form-input__input--db-upload--error" : "form-input__input--db-upload"; ?> name="name" id="db-upload-img-name" type="text" value="<?= $inputs['name'] ?? ''; ?>">
						  	<div class="form-input__alert--db-upload">
								<p><?= $errors['name'] ?? ''; ?></p>
						  	</div>
						</div>

						<fieldset class="form-fieldset--db-upload">
			  				<legend class="form-fieldset__legend--db-upload">Camera type *</legend>
						  	<div class="form-fieldset__inputs--db-upload">
								<div>
								  	<input type="radio" id="db-upload-img-camera-professional" name="camera-type" value="professional" <?= isset($inputs['camera-type']) && $inputs['camera-type'] == 'professional' ? 'checked' : ''; ?>/>
								  	<label for="db-upload-img-camera-professional">professional</label>
								</div>
								<div>
							  		<input type="radio" id="db-upload-img-camera-smarthphone" name="camera-type" value="smarthphone" 

									<?php 
										if (!isset($inputs['camera-type'])) 
										{
										echo 'checked';
										} 
										elseif ($inputs['camera-type'] == 'smarthphone') 
										{
										echo 'checked';
										}
									?>

							 		/>
							  		<label for="db-upload-img-camera-smarthphone">smarthphone</label>
								</div>
						  	</div>
						</fieldset>

						<div class="form-input--db-upload">
							<label class=<?= isset($errors['camera-model']) ? "form-input__label--db-upload--error" : "form-input__label--db-upload"; ?> for="camera-model">Camera Model *</label>
							<input class=<?= isset($errors['camera-model']) ? "form-input__input--db-upload--error" : "form-input__input--db-upload"; ?> name="camera-model" id="db-upload-img-camera-model" type="text" value="<?= $inputs['camera-model'] ?? ''; ?>">
							<div class="form-input__alert--db-upload">
								<p><?= $errors['camera-model'] ?? ''; ?></p>
							</div>
						</div>

						<div class="form-input--db-upload">
							<label class=<?= isset($errors['country']) ? "form-input__label--db-upload--error" : "form-input__label--db-upload"; ?> for="country">Country</label>
							<input class=<?= isset($errors['country']) ? "form-input__input--db-upload--error" : "form-input__input--db-upload"; ?> name="country" id="db-upload-img-country" type="text" value="<?= $inputs['country'] ?? ''; ?>">
							<div class="form-input__alert--db-upload">
								<p><?= $errors['country'] ?? ''; ?></p>
							</div>
						</div>

						<div class="form-input--db-upload">
							<label class=<?= isset($errors['city']) ? "form-input__label--db-upload--error" : "form-input__label--db-upload"; ?> for="city">City</label>
							<input class=<?= isset($errors['city']) ? "form-input__input--db-upload--error" : "form-input__input--db-upload"; ?> name="city" id="db-upload-img-city" type="text" value="<?= $inputs['city'] ?? ''; ?>">
							<div class="form-input__alert--db-upload">
								<p><?= $errors['city'] ?? ''; ?></p>
							</div>
						</div>

						<div class="form-input--db-upload">
							<label class=<?= isset($errors['place']) ? "form-input__label--db-upload--error" : "form-input__label--db-upload"; ?> for="place">Place</label>
							<input class=<?= isset($errors['place']) ? "form-input__input--db-upload--error" : "form-input__input--db-upload"; ?> name="place" id="db-upload-img-place" type="text" value="<?= $inputs['place'] ?? ''; ?>">
							<div class="form-input__alert--db-upload">
								<p><?= $errors['place'] ?? ''; ?></p>
							</div>
						</div>

						<div class="form-input--db-upload">
							<label class=<?= isset($errors['tags']) ? "form-input__label--db-upload--error" : "form-input__label--db-upload"; ?> for="tags">Tags *</label>
							<input class=<?= isset($errors['tags']) ? "form-input__input--db-upload--error" : "form-input__input--db-upload"; ?> name="tags" id="db-upload-img-tags" type="text" value="<?= $inputs['tags'] ?? ''; ?>">
							<div class="form-input__alert--db-upload">
								<p><?= $errors['tags'] ?? 'Type at least 3 tags. Seperate them using a coma ","'; ?></p>
							</div>
						</div>
		  			</div>

					<div class="form-input--db-upload db-user-upload__upload-file-section__form__textarea">
						<label class=<?= isset($errors['description']) ? "form-input__label--db-upload--error" : "form-input__label--db-upload"; ?> for="description">Description</label>
						<textarea id="db-upload-img-description" class=<?= isset($errors['description']) ? "form-input__input--db-upload--error" : "form-input__input--db-upload"; ?> name="description" name="description" maxlength="500" spellcheck="true"><?= $inputs['description'] ?? ''; ?></textarea>
						<p><span id="db-upload-img-chars-value">0</span> / 500</p>
						<div class="form-input__alert--db-upload">
							<p><?= $errors['description'] ?? ''; ?></p>
						</div>
					</div>
				</form>
				<!-- Image info form - END -->

				<p> from <span><?= $user_allowance ?></span> uploads <span><?= $allowance_left; ?></span> left (<a href="../index.php">request more</a>)</p>
	  		</div>

	  		<hr class="divider">

	  		<ul class="db-user-upload__upload-file-section__rules-list">
				<div>
					<li>High quality images up to 20 MB</li>
					<li>Only upload image you own right to</li>
					<li>JPG, PNG, SVG, WEBP and GIF only</li>
				</div>
				<div>
				  	<li>Images are clear & original</li>
				  	<li><a href="../terms-and-conditions.php">Read the Kingpiggy Terms</a></li>
				  	<li>Excludes nudity, hate and violence</li>
				</div>
	  		</ul>
		</div>
	</section>

	<hr class="divider">

	<section class="db-user-upload__tags-section">
		<h3>Tags in high demand</h3>

	  <!-- Make below buttons dynamic !!! Include search links !!! -->

		<div class="db-user-upload__tags-section__tags-container">
			<button class="tag-button">Remote Work</button>
			<button class="tag-button">Sustainability</button>
			<button class="tag-button">Diversity and Inclusion</button>
			<button class="tag-button">Mental Health</button>
			<button class="tag-button">Fitness and Wellness</button>
			<button class="tag-button">E-commerce</button>
			<button class="tag-button">Smart Home Technology</button>
			<button class="tag-button">Virtual Reality</button>
			<button class="tag-button">Healthy Eating</button>
			<button class="tag-button">Digital Nomad</button>
		</div>
  </section>
</div>

<?php include('includes/user-dashboard-footer.php'); ?>
