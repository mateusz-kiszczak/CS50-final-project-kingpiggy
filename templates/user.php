<?php require('../private/helpers/helpers.php'); ?>


<!-- 16.06.24 FIND BETTER WAY TO DISPLAY ALL "KINGPIGGY" PICTURES !!! -->
<?php 
	if ($publicUser[0]->user_nikname == 'kingpiggy') {
		redirect('search.php?search=kingpiggy');
	} 
	
	// If no user set, redirect to home page
	if (!isset($publicUser[0]->user_nikname)) {
		redirect('./index.php');
	}
?>

<!-- Header -->
<?php 
	// include('..\private\helpers\view.php');
	view('header', ['title' => $publicUser[0]->user_nikname . 'on Kingpiggy' ?? 'Kingpiggy User']); 
?>

<!-- Include image component -->
<?php include('includes/image_element.php'); ?>

<main>
	<!-- User Details - START -->
	<div class="user__top-section-wrapper">
		<section class="user__top-section__name-and-avatar" 
				style="

				<?php 
					if ($userBgImg) 
					{
						echo 'background-image: url(' . $userBgImg[0]->image_url;
					}
					else
					{
						echo 'background-color: #070707';
					} 
				?>

		)">
			<div class="user__top-section__bg-overlay">
				<h1><?php if ($publicUser) echo $publicUser[0]->user_name . ' ' . $publicUser[0]->user_surname; ?></h1>
				<div class="user__top-section__bg-overlay__img-border">
					<img src="<?php if ($publicUser) echo $publicUser[0]->user_avatar_url ?>" alt="">
				</div>
			</div>
		</section>
		<section class="user__top-section__info-and-buttons">
			<div class="user__top-section__info__wrapper">
				<h3 class="user__top-section__info__nikname">@<?php if ($publicUser) echo $publicUser[0]->user_nikname; ?></h3>
				<h3>Based in <?php if ($publicUser) echo str_replace('|', ', ', $publicUser[0]->user_location); ?></h3>
			</div>
			<div class="user__top-section__buttons__wrapper">
				<div>
					<img src="templates/src/icons/message.svg" alt="">
					<p>Message</p>
				</div>
				<div>
					<img src="templates/src/icons/share.svg" alt="">
					<p>Share</p>
				</div>
			</div>
		</section>
	</div>
	<div class="user__mid-section-wrapper">

		<?php
			if ($profiles)
			{
				// Convert stdClass Object to array
				$profiles_arr = get_object_vars($profiles[0]);

				// Filter array. Remove all empty values from the array
				$filtered_profiles_arr = array_filter($profiles_arr);


			}
		?>

		<?php if (!empty($filtered_profiles_arr)) : ?>

			<section class="user__mid-section__connect" <?= empty($publicUser[0]->user_description) ? 'style="width: 100%"' : '' ?>>
				<h3>Connect</h3>
				<hr class="divider">
				<div class="user__mid-section__connect__links<?= empty($publicUser[0]->user_description) ? '--no-description' : ''; ?>">

					<?php foreach($filtered_profiles_arr as $profile_key => $profile_value) : ?>
						<?php
							// Get platform name from the array key 
							$platform = str_replace('profile_', '', $profile_key);

							// Check id the profile link start with https://
							$profile_link = '';

							// If profile link starts with https or http, accept the link
							if (preg_match("/^https:\/\//", $profile_value) || preg_match("/^http:\/\//", $profile_value))
							{
								$profile_link = $profile_value;
							}
							// Else if profile link starts with www, add https:// to the begining
							else if (preg_match("/^www./", $profile_value))
							{
								$profile_link = 'https://' . $profile_value;
							}
							// Else search for the results in google
							else 
							{
								$profile_link = 'https://www.google.com/search?q=' . $profile_value;
							}
						?>
						<a class="user__mid-section__connect__links__link" href="<?= $profile_link; ?>">
							<img src="templates/src/icons/<?= $platform; ?>-grey.svg" alt="">
							<p><?= ucfirst($platform ); ?></p>
						</a>
					<?php endforeach; ?>
				</div>
			</section>

		<?php endif;  ?>

		<?php if ($publicUser[0]->user_description) : ?>

			<section class="user__mid-section__description">
				<p><?= $publicUser[0]->user_description; ?></p>
			</section>

		<?php endif; ?>

	</div>
	<hr class="divider divider--user-page">
	<div class="user__bottom-section-wrapper">
		<section class="user__bottom-section">
			<div class="user__bottom-section__stat">
				<p class="user__bottom-section__stat__text">Loves: <span><?= $allLikes[0]->total_user_likes; ?></span></p>
			</div>
			<div class="user__bottom-section__divider">|</div>
			<div class="user__bottom-section__stat">
				<p class="user__bottom-section__stat__text">Downloads: <span><?= $allDownloads[0]->total_user_downloads; ?></span></p>
			</div>
		</section>
	</div>
	<!-- User Details - END -->

	<!-- Related Images - START -->
	<section class="pictures__container--bg-grey">
		<h3>Images by @<?php if ($publicUser) echo $publicUser[0]->user_nikname; ?></h3>
		<div class="pictures__grid-container">
		<!-- PHP block - Start -->
		<?php if($user_images) : ?>     
			<!-- Column 1 -->
			<div id="col-1--home" class="pictures__column">
				<?php foreach($user_images as $key => $img) : ?>
					<?php 
						$true_key = $key + 1;
						if (fmod($true_key, 4) == 1) {
							echo image_element_user($img->image_id, $img->image_thumbnail_url, $img->image_name);
						}
					?>
				<?php endforeach; ?>
			</div>
			<!-- Column 2 -->
			<div id="col-2--home" class="pictures__column">
				<?php foreach($user_images as $key => $img) : ?>
					<?php 
						$true_key = $key + 1;
						if (fmod($true_key, 4) == 2) {
							echo image_element_user($img->image_id, $img->image_thumbnail_url, $img->image_name);
						}
					?>
				<?php endforeach; ?>
			</div>
			<!-- Column 3 -->
			<div id="col-3--home" class="pictures__column">
				<?php foreach($user_images as $key => $img) : ?>
					<?php 
						$true_key = $key + 1;
						if (fmod($true_key, 4) == 3) {
							echo image_element_user($img->image_id, $img->image_thumbnail_url, $img->image_name);
						}
					?>
				<?php endforeach; ?>
			</div>
			<!-- Column 4 -->
			<div id="col-4--home" class="pictures__column">
				<?php foreach($user_images as $key => $img) : ?>
					<?php 
						$true_key = $key + 1;
						if (fmod($true_key, 4) == 0) {
							echo image_element_user($img->image_id, $img->image_thumbnail_url, $img->image_name);
						}
					?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?> 
		<!-- PHP block - End -->
		</div>

		<!-- // SHOW MORE BUTTON -->

		<!-- <div class="pictures__load-more">
			<button class="button-default--large" id="test">Load More</button>
		</div> -->
		
	</section>
	<!-- Related Images - END -->

	<!-- Other Contributors - START -->
	<section class="user__other-contributors">
		<h3>Other Contributors</h3>
		<div class="user__other-contributors__user__users-wrapper">

			<?php foreach($contributors as $contributor) : ?>

				<a href="user.php?user=<?= $contributor->user_nikname; ?>">
					<div class="user__other-contributors__user">
						<div class="user__other-contributors__user__avatar">
							<img src="<?= $contributor->user_avatar_url; ?>" alt="">
						</div>
						<div class="user__other-contributors__user__nikname-and-location">
							<h4>@<?= $contributor->user_nikname; ?></h4>
							<p><?= $contributor->user_location ? str_replace('|', ', ', $contributor->user_location) : ''; ?></p>
						</div>
						<div class="user__other-contributors__user__stats">
							<div class="user__other-contributors__user__stats__value">
								<p>Loves: <span><?= $contributor->total_user_likes; ?></span></p>
							</div>
							<div class="user__other-contributors__user__stats__value">
								<p>Downloads: <span><?= $contributor->total_user_downloads; ?></span></p>
							</div>
						</div>
					</div>
				</a>

			<?php endforeach; ?>

		</div>
	</section>
	<!-- Other Contributors - END -->
</main>

<!-- Footer -->
<?php include('includes/footer.php'); ?>
