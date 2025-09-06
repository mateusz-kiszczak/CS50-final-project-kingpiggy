<?php 
	// If no user set, redirect to home page
    if (!isset($_SESSION['username'])) 
    {
        redirect('../index.php');
    } 
    elseif (!isset($_GET['user']) && $_SESSION['username'] !== $_GET['user']) 
    {
        redirect('../index.php');
    }

    // Check if GET has an image id
    $image_id = false;

    if (isset($_GET['image_id']))
    {
        // Check if image with this id belongs to register user
        if ($img_class->getImageByUserAndImageId($_SESSION['user_id'], urlencode($_GET['image_id'])))
        {
            $this_image = $img_class->getImageByUserAndImageId($_SESSION['user_id'], urlencode($_GET['image_id']))[0];
            $image_id = true;
        }
        else 
        {
            redirect('my-images.php?user=' . $_SESSION['username']);
        }
    }
?>

<?php include('includes/user-dashboard-header.php'); ?>

<div class="dashboard-section-wrapper">

	<?php   
		display_all_flash_messages(); 
	?>

	<h2>My Images</h2>

    <?php if ($image_id): ?>

    <section class="image-info-and-form__container">
        <h3 class="hide">Selected Image</h3>
        <section class="image-info-and-form__info">
            <h4 class="hide">Image Details</h4>
            <div class="image-info-and-form__info__image">
                <a href="../../image.php?image_id=<?= $this_image->image_id; ?>">
                    <img src="<?= '../../' . $this_image->image_thumbnail_url; ?>" alt="<?= $this_image->image_name; ?>">
                </a>
            </div>
            <div class="image-info-and-form__info__details">
                <ul class="image-info-and-form__info__details__list">
                    <div>
                        <li class="">Views: <span><?= $this_image->image_views; ?></span></li>
                        <li class="">Downloads: <span><?= $this_image->image_downloads; ?></span></li>
                        <li class="">Loves: <span><?= $this_image->image_likes; ?></span></li>
                    </div>
                    <div>
                        <li class="">Resolution: <span><?= $this_image->image_width . ' x ' . $this_image->image_height; ?></span></li>
                        <li class="">Ratio: <span><?= $this_image->image_ratio; ?></span></li>
                        <li class="">Format: <span><?= strtoupper($this_image->image_extention); ?></span></li>
                    </div>
                </ul>
                <hr class="divider image-info-and-form__info__details__divider">
                <form action="<?= 'submit/delete-image.php?user=' . $_SESSION['username'] . '&image_id=' . urlencode($_GET['image_id']); ?>" method="post">
                    <button class="form-button form-button--red">Delete Image</button>
                </form>
            </div>
        </section>

        <hr class="divider image-info-and-form__container__divider">

        <section class="image-info-and-form__form">
            <h4 class="hide">Update Image Info</h4>

            <div class="image-info-and-form__form__inputs-wrapper">
                <!-- Image Title cant be changed -->
                <div class="form-input">
                    <div class="form-input__label">Title</div>
			        <div class="form-input__input"><?= $this_image->image_name; ?></div>
		        </div>
                <div class="image-info-and-form__form__inputs__camera">
                    <!-- Camera type cant be changed -->
                    <div class="form-input">
                        <div class="form-input__label">Camera Type</div>
                        <div class="form-input__input"><?= $this_image->image_camera_type; ?></div>
                    </div>
                    <!-- Camera model cant be changed -->
                    <div class="form-input">
                        <div class="form-input__label">Camera Model</div>
                        <div class="form-input__input"><?= $this_image->image_camera_name; ?></div>
                    </div>
                </div>
            </div>

            <form action="<?= 'my-images.php?user=' . $_SESSION['username'] . '&image_id=' . urlencode($_GET['image_id']); ?>" method="post">
                <div class="image-info-and-form__form__inputs-wrapper">
                    
                    <div class="image-info-and-form__form__inputs__camera">
                        <div class="form-input">
                            <label class=<?= isset($errors['city']) ? "form-input__label--error" : "form-input__label"; ?> for="db-images-city">City</label>
                            <input class=<?= isset($errors['city']) ? "form-input__input--error" : "form-input__input"; ?> name="city" id="db-images-city" type="text" value="<?= isset($errors['city']) ? $inputs['city'] : img_location_str_to_arr($this_image->image_location)['city']; ?>">
                            <div class="form-input__alert">
                                <p><?= $errors['city'] ?? ''; ?></p>
                            </div>
                        </div>
                        
                        <div class="form-input">
                            <label class=<?= isset($errors['country']) ? "form-input__label--error" : "form-input__label"; ?> for="db-images-country">Country</label>
                            <input class=<?= isset($errors['country']) ? "form-input__input--error" : "form-input__input"; ?> name="country" id="db-images-country" type="text" value="<?= isset($errors['country']) ? $inputs['country'] : img_location_str_to_arr($this_image->image_location)['country']; ?>">
                            <div class="form-input__alert">
                                <p><?= $errors['country'] ?? ''; ?></p>
                            </div>
                        </div>
                    </div>
                        
                    <div class="form-input">
                        <label class=<?= isset($errors['place']) ? "form-input__label--error" : "form-input__label"; ?> for="db-images-place">Place</label>
				    	<input class=<?= isset($errors['place']) ? "form-input__input--error" : "form-input__input"; ?> name="place" id="db-images-place" type="text" value="<?= isset($errors['place']) ? $inputs['place'] : img_location_str_to_arr($this_image->image_location)['place']; ?>">
				    	<div class="form-input__alert">
                            <p><?= $errors['place'] ?? ''; ?></p>
				    	</div>
				    </div>
                
                    <div class="form-input">
                        <label class=<?= isset($errors['tags']) ? "form-input__label--error" : "form-input__label"; ?> for="db-images-tags">Tags</label>
				    	<input class=<?= isset($errors['tags']) ? "form-input__input--error" : "form-input__input"; ?> name="tags" id="db-images-tags" type="text" value="<?= isset($errors['tags']) ? $inputs['tags'] : tags_db_string_to_user_string($this_image->image_tags); ?>">
				    	<div class="form-input__alert">
                            <p><?= $errors['tags'] ?? ''; ?></p>
				    	</div>
				    </div>

                    <div class="form-input db-user-upload__upload-file-section__form__textarea">
						<label class=<?= isset($errors['description']) ? "form-input__label--error" : "form-input__label"; ?> for="description">Description</label>
						<textarea id="db-upload-img-description" class=<?= isset($errors['description']) ? "form-input__input--error" : "form-input__input"; ?> name="description" name="description" maxlength="500" spellcheck="true"><?= $inputs['description'] ?? $this_image->image_description; ?></textarea>
						<p><span id="db-upload-img-chars-value">0</span> / 500</p>
						<div class="form-input__alert">
							<p><?= $errors['description'] ?? ''; ?></p>
						</div>
					</div>

                    <input class="form-button form-button--red" type="submit" value="Save Changes">
                </div>
            </form>
        </section>
    </section>

    <?php endif; ?>

    <section class="user-images__container">
        <h3 class="hide">Uploaded Images</h3>

        <?php foreach($imgs as $img): ?>

            <a class="user-images__link<?= ($image_id && urlencode($_GET['image_id']) == $img->image_id) ? '--active' : ''; ?>" href="<?= 'my-images.php?user=' . $_SESSION['username'] . '&image_id=' . $img->image_id ?>">
                <div></div>
                <img class="user-images__link__image" src="<?= '../../' . $img->image_thumbnail_url; ?>" alt="<?= $img->image_name; ?>">
            </a>

        <?php endforeach; ?>

    </section>
</div>

