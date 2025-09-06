<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title ?? 'Kingpiggy' ?></title>
	<meta name="description" content="Explore our super collection of high-quality, royalty-free images, perfect for all your creative projects. We add new photos daily, so start browsing now!">
	<link rel="canonical" href="https://www.kingpiggy.com">
	<meta name="robots" content="index, follow">
	<link rel="stylesheet" href="templates/style/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="templates/js/script.js" defer></script>
</head>
<body>
	<div class="page-container">
		<!-- Main Navigation - Start -->
		<nav>
			<div class="nav-grid-container nav-closed">
				<!-- Top Header - Logo and Nav button -->
				<div class="nav-bar__container">
					<div class="nav-bar--others">
						<div class="nav-bar__logo">
							<a href="index.php"><img class="nav-bar__full-logo--others hide" src="templates/src/logo--img-and-text.svg" alt="Kingpiggy logo"></a>
							<a href="index.php"><img class="nav-bar__logo-icon--others" src="templates/src/logo--img.svg" alt="Kingpiggy logo"></a>
						</div>
						<!-- Search Form - Start -->
						<form action="" role="search">
							<div class="search-bar--others">
								<input type="search" name="search" placeholder="Search..." autocomplete="off" />
								<button class="search-button--others">
									<img src="templates/src/icons/search.svg" alt="Search icon - magnifying glass">
								</button>
							</div>
						</form>
						<!-- Search Form - End -->
						<div class="nav-bar__buttons">
							<div class="nav-bar__user hide">

								<?php if (is_user_logged_in()) : ?>
									<a href="<?= "user-dashboard.php?user=" . $_SESSION["username"]; ?>">
										<img class="nav-bar__user--logged-in" src="<?= $_SESSION['user_avatar']; ?>" alt="Go to user dashboard or login or register page">
									</a>
								<?php else : ?>
									<a href="login.php">
										<img class="nav-bar__user--logged-out" src="templates/src/icons/user.svg" alt="User avatar">
									</a>
								<?php endif; ?>

							</div>
							<div class="nav-bar__nav-control">
								<img class="" src="templates/src/icons/open-nav.svg" alt="Open navigation button">
								<img class="hide" src="templates/src/icons/close-nav.svg" alt="Close navigation button">
							</div>
						</div>
					</div>
				</div>
				<!-- Drop Navigation - Start -->
				<div class="nav__container hide">
					<div class="nav--others">
						<!-- Navigation Links - Start -->
						<div class="nav-links">
							<div class="nav-links__section-container">
								<section class="nav-links__section">
									<div>
										<h2>Media</h2>
										<ul>
											<li><a href="search.php?search=all&type=images">Photos</a></li>
											<li><a href="search.php?search=all&type=vectors">Vectors</a></li>
											<li><a href="search.php?search=all&type=images">Illustrations</a></li>
										</ul>
									</div>
								</section>
							</div>
							<div class="nav-links__section-container">
								<section class="nav-links__section">
									<div>
										<h2>Discover</h2>
										<ul>
											<li><a href="search.php?search=all&sort=popular&type=images">Popular Images</a></li>
											<li><a href="search.php?search=all&sort=latest&type=images">Recently added Images</a></li>
											<li><a href="list.php?type=categories">Top Searches</a></li>
											<li><a href="search.php?search=all&?sort=popular">Top 100 Downloads</a></li>
										</ul>
									</div>
								</section>
							</div>
							<div class="nav-links__section-container">
								<section class="nav-links__section">
									<div>
										<h2>Account</h2>
										<ul>
											<li><a href="<?= is_user_logged_in() ? "logout.php" : "login.php"; ?>"><?= is_user_logged_in() ? "Logout" : "Login"; ?></a></li>
											<li><a href="<?= is_user_logged_in() ? "user-dashboard.php?user=" . $_SESSION["username"] : "login.php"; ?>">My Account</a></li>
											<li><a href="<?= is_user_logged_in() ? "user_dashboard/upload-image.php?user=" . $_SESSION["username"] : "login.php"; ?>">Upload Image</a></li>
											<li><a href="register.php">Register</a></li>
										</ul>
									</div>
								</section>
							</div>
							<div class="nav-links__section-container">
								<section class="nav-links__section">
									<div>
										<h2>About Us</h2>
										<ul>
											<li><a href="about-us.php">About Us</a></li>
											<li><a href="faq.php">FAQ</a></li>
											<li><a href="privacy-policy.php">Privacy Policy</a></li>
											<li><a href="cookies-policy.php">Cookies Policy</a></li>
											<li><a href="license.php">License Summary</a></li>
											<li><a href="terms-and-conditions.php">Tearms & Conditions</a></li>
										</ul>
									</div>
								</section>
							</div>
						</div>
						<!-- Navigation Links - End -->
						<div class="nav-copyrights__container">
							<p>© 2024 Kingpiggy. All rights reserved.</p> <!-- Navigation Copyrights -->
						</div>
					</div>
				</div>
				<!-- Drop Navigation - End -->
			</div>
		</nav>
	<!-- Main Navigation - End -->
