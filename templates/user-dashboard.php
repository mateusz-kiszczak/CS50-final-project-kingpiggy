		<?php
		// Start session
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		// Include Header
		include('includes/header_home.php');

		// Include image component
		include('includes/image_element.php');
	
		// If no user set, redirect to home page
		if (!isset($_SESSION['username'])) 
		{
			redirect('index.php');
		} 
		elseif (!isset($privateUser[0]->user_nikname) && $_SESSION['username'] !== $privateUser[0]->user_nikname) 
		{
			redirect('index.php');
		}
		?>
		
		<!-- Main Content - Start -->
		<main>
			<!-- Main header - START -->
			<section class="db-user-container">
				<div class="db-user__avatar">
					<a href="user.php?user=<?= $_SESSION['username']; ?>">
						<img src="<?php echo $privateUser[0]->user_avatar_url; ?>" alt="<?php echo $privateUser[0]->user_nikname; ?> avatar"/>
					</a>
				</div>
				<div class="db-user__info">
					<h1>@<?php echo $privateUser[0]->user_nikname; ?></h1>
					<p>Member since <?php echo timestampToDateSlash($privateUser[0]->user_date_created); ?></p>
				</div>
			</section>
			<!-- Main header - END -->

			<div class="db-nav-and-form-container">
				<!-- Dashboard navigation - STARTS -->
				<nav class="db-nav">
					<button class="db-nav__button button--dashboard-nav--open">
						<span>Dashboard Navigation</span>
						<img class="db-nav__button__icon--open" src="templates/src/icons/arrow-down-white.svg" alt="Open Navigation">
						<img class="db-nav__button__icon--close hide" src="templates/src/icons/arrow-up-black.svg" alt="Close Navigation">
					</button>
					<ul class="db-nav__links">
						<a href="user_dashboard/upload-image.php?user= <?= $_SESSION['username']; ?>">
							<li id="dashboard-upload-image" class="db-nav__links__link">
								<div class="db-nav__links__link__img">
									<img src="templates/src/icons/db-upload-image-grey.svg" alt="upload_image">
								</div>
								<p>Upload Image</p>
							</li>
						</a>
						<a href="user_dashboard/edit-profile.php?user= <?= $_SESSION['username']; ?>">
							<li id="dashboard-edit-profile" class="db-nav__links__link">
								<div class="db-nav__links__link__img">
									<img src="templates/src/icons/db-edit-profile-grey.svg" alt="edit_profile">
								</div>
								<p>Edit Profile</p>
							</li>
						</a>
						<a href="user_dashboard/my-images.php?user= <?= $_SESSION['username']; ?>">
							<li id="dashboard-my-images" class="db-nav__links__link">
								<div class="db-nav__links__link__img">
									<img src="templates/src/icons/db-my-images-grey.svg" alt="my_images">
								</div>
								<p>My Images</p>
							</li>
						</a>
						<a href="user_dashboard/favourites.php?user= <?= $_SESSION['username']; ?>">
							<li id="dashboard-favourites" class="db-nav__links__link">
								<div class="db-nav__links__link__img">
									<img src="templates/src/icons/db-favourite-grey.svg" alt="favourites">
								</div>
								<p>Favourites</p>
							</li>
						</a>
						<a href="user_dashboard/downloads.php?user= <?= $_SESSION['username']; ?>">
							<li id="dashboard-downloads" class="db-nav__links__link">
								<div class="db-nav__links__link__img">
									<img src="templates/src/icons/db-downloads-grey.svg" alt="downloads">
								</div>
								<p>Downloads</p>
							</li>
						</a>
						<a href="user_dashboard/notifications.php?user= <?= $_SESSION['username']; ?>">
							<li id="dashboard-notifications" class="db-nav__links__link">
								<div class="db-nav__links__link__img">
									<img src="templates/src/icons/db-notifications-grey.svg" alt="notifications">
								</div>
								<p>Notifications</p>
							</li>
						</a>
						<a href="user_dashboard/delete-account.php?user= <?= $_SESSION['username']; ?>">
							<li id="dashboard-delete-account" class="db-nav__links__link--danger">
								<div class="db-nav__links__link__img">
									<img src="templates/src/icons/db-delete-account-red.svg" alt="delete_account">
								</div>
								<p>Delete Account</p>
							</li>
						</a>
					</ul>
				</nav>
				<!-- Dashboard navigation - END -->

				<!-- Form section - START -->
				<section id="dashboard-active-section">
					<h2>Choose the link from the list</h2>
				</section>
				<!-- Form section - END -->
			</div>

		</main>
		<!-- Main Content - END -->

		<!-- Include Slide Up Button -->
		<?php include('includes/go_up_button.php'); ?>
		<!-- Include Footer -->
		<?php include('includes/footer.php'); ?>
		