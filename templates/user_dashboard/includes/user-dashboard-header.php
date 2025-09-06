<?php
  // If no user set, redirect to home page
  if ($_SESSION["username"] !== $privateUser[0]->user_nikname) {
    redirect('../index.php');
  }

  // Check the url contains the right path.
  // Get the current url and check if it contains provided page.
  // Will use to identify and mark current page in the dashboard

  function is_page_active($path) {
    $current_path = $_SERVER['REQUEST_URI'];

    return str_contains($current_path, $path);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kingpiggy</title>
  <meta name="description" content="Explore our super collection of high-quality, royalty-free images, perfect for all your creative projects. We add new photos daily, so start browsing now!">
  <link rel="canonical" href="https://www.kingpiggy.com">
  <meta name="robots" content="index, follow">
  <link rel="stylesheet" href="../templates/style/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../templates/js/script.js" defer></script>
</head>
<body>
  <div class="page-container">
    <!-- Main Navigation - Start -->
    <nav>
      <div class="nav-grid-container nav-closed">
        <!-- Top Header - Logo and Nav button -->
        <div class="nav-bar__container">
          <div class="nav-bar">
            <div class="nav-bar__logo">
              <a href="../index.php"><img class="nav-bar__full-logo" src="../templates/src/logo--img-and-text.svg" alt="Kingpiggy logo"></a>
              <a href="../index.php"><img class="nav-bar__logo-icon hide" src="../templates/src/logo--img.svg" alt="Kingpiggy logo"></a>
            </div>
            <div class="nav-bar__buttons">
              <div class="nav-bar__user hide">

                <?php if (is_user_logged_in()) : ?>
                  <a href="<?= "../user-dashboard.php?user=" . $_SESSION["username"]; ?>">
                    <img class="nav-bar__user--logged-in" src="../<?= $_SESSION['user_avatar']; ?>" alt="Go to user dashboard or login or register page">
                  </a>
                <?php else : ?>
                  <a href="../login.php">
                    <img class="nav-bar__user--logged-out" src="../templates/src/icons/user.svg" alt="User avatar">
                  </a>
                <?php endif; ?>
                
              </div>
              <div class="nav-bar__nav-control">
                <img class="" src="../templates/src/icons/open-nav.svg" alt="Open navigation button">
                <img class="hide" src="../templates/src/icons/close-nav.svg" alt="Close navigation button">
              </div>
            </div>
          </div>
        </div>
        <!-- Drop Navigation - Start -->
        <div class="nav__container hide">
          <div class="nav">
            <!-- Search Form - Start -->
            <form action="../index.php" role="search">
              <div class="search-bar">
                <input type="search" name="search" placeholder="Search..." autocomplete="off" />
                <button class="search-button">
                  <img src="../templates/src/icons/search.svg" alt="Search icon - magnifying glass">
                </button>
              </div>
            </form>
            <!-- Search Form - End -->
            <!-- Navigation Links - Start -->
            <div class="nav-links">
              <div class="nav-links__section-container">
                <section class="nav-links__section">
                  <div>
                    <h2>Media</h2>
                    <ul>
                      <li><a href="../search.php?type=photography">Photos</a></li>
                      <li><a href="../search.php?type=vector">Vectors</a></li>
                      <li><a href="../search.php?type=graphic">Illustrations</a></li>
                    </ul>
                  </div>
                </section>
              </div>
              <div class="nav-links__section-container">
                <section class="nav-links__section">
                  <div>
                    <h2>Discover</h2>
                    <ul>
                      <li><a href="../search.php?sort=popular">Popular Images</a></li>
                      <li><a href="../list.php?type=searches">Popular Searches</a></li>
                      <li><a href="../list.php?type=categories">Categories</a></li>
                      <li><a href="../search.php?sort=downloads">Top 100 Downloads</a></li>
                    </ul>
                  </div>
                </section>
              </div>
              <div class="nav-links__section-container">
                <section class="nav-links__section">
                  <div>
                    <h2>Account</h2>
                    <ul>
                      <li><a href="../<?= is_user_logged_in() ? "logout.php" : "login.php"; ?>"><?= is_user_logged_in() ? "Logout" : "Login"; ?></a></li>
                      <li><a href="../<?= is_user_logged_in() ? "user-dashboard.php?user=" . $_SESSION["username"] : "login.php"; ?>">My Account</a></li>
                      <li><a href="../<?= is_user_logged_in() ? "user_dashboard/upload-image.php?user=" . $_SESSION["username"] : "login.php"; ?>">Upload Image</a></li>
                      <li><a href="../register.php">Register</a></li>
                    </ul>
                  </div>
                </section>
              </div>
              <div class="nav-links__section-container">
                <section class="nav-links__section">
                  <div>
                    <h2>About Us</h2>
                    <ul>
                      <li><a href="../about-us.php">About Us</a></li>
                      <li><a href="../faq.php">FAQ</a></li>
                      <li><a href="../privacy-policy.php">Privacy Policy</a></li>
                      <li><a href="../cookies-policy.php">Cookies Policy</a></li>
                      <li><a href="../license.php">License Summary</a></li>
                      <li><a href="../terms-and-conditions.php">Tearms & Conditions</a></li>
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
    
    <!-- Main Content - Start -->
    <main>
      <!-- Main header - START -->
      <section class="db-user-container">
        <div class="db-user__avatar">
          <a href="../user.php?user=<?= $_SESSION['username']; ?>">
            <img src="../<?= $_SESSION['user_avatar']; ?>" alt="<?php echo $privateUser[0]->user_nikname; ?> avatar"/>
          </a>
        </div>
        <div class="db-user__info">
          <h1>@<?= $_SESSION['username']; ?></h1>
          <p>Member since <?php echo timestampToDateSlash($privateUser[0]->user_date_created); ?></p>
        </div>
      </section>
      <!-- Main header - END -->
      
      <div class="db-nav-and-form-container">
        <!-- Dashboard navigation - STARTS -->
        <nav class="db-nav">
          <button class="db-nav__button button--dashboard-nav--open">
            <span>Dashboard Navigation</span>
            <img class="db-nav__button__icon--open" src="../templates/src/icons/arrow-down-white.svg" alt="Open Navigation">
            <img class="db-nav__button__icon--close hide" src="../templates/src/icons/arrow-up-black.svg" alt="Close Navigation">
          </button>
          <ul class="db-nav__links">
            <a href="upload-image.php?user= <?= $_SESSION['username']; ?>">
              <li id="dashboard-upload-image" class="db-nav__links__link <?= is_page_active('upload-image.php?') ? 'db-nav__links__link--active' : '' ?>">
                <div class="db-nav__links__link__img">
                  <img src="../templates/src/icons/db-upload-image-<?= is_page_active('upload-image.php?') ? 'white' : 'grey' ?>.svg" alt="upload_image">
                </div>
                <p>Upload Image</p>
              </li>
            </a>
            <a href="edit-profile.php?user= <?= $_SESSION['username']; ?>">
              <li id="dashboard-edit-profile" class="db-nav__links__link <?= is_page_active('edit-profile.php?') ? 'db-nav__links__link--active' : '' ?>">
                <div class="db-nav__links__link__img">
                  <img src="../templates/src/icons/db-edit-profile-<?= is_page_active('edit-profile.php?') ? 'white' : 'grey' ?>.svg" alt="edit_profile">
                </div>
                <p>Edit Profile</p>
              </li>
            </a>
            <a href="my-images.php?user= <?= $_SESSION['username']; ?>">
              <li id="dashboard-my-images" class="db-nav__links__link <?= is_page_active('my-images.php?') ? 'db-nav__links__link--active' : '' ?>">
                <div class="db-nav__links__link__img">
                  <img src="../templates/src/icons/db-my-images-<?= is_page_active('my-images.php?') ? 'white' : 'grey' ?>.svg" alt="my_images">
                </div>
                <p>My Images</p>
              </li>
            </a>
            <a href="favourites.php?user= <?= $_SESSION['username']; ?>">
              <li id="dashboard-favourites" class="db-nav__links__link <?= is_page_active('favourites.php?') ? 'db-nav__links__link--active' : '' ?>">
                <div class="db-nav__links__link__img">
                  <img src="../templates/src/icons/db-favourite-<?= is_page_active('favourites.php?') ? 'white' : 'grey' ?>.svg" alt="favourites">
                </div>
                <p>Favourites</p>
              </li>
            </a>
            <a href="downloads.php?user= <?= $_SESSION['username']; ?>">
              <li id="dashboard-downloads" class="db-nav__links__link <?= is_page_active('downloads.php?') ? 'db-nav__links__link--active' : '' ?>">
                <div class="db-nav__links__link__img">
                  <img src="../templates/src/icons/db-downloads-<?= is_page_active('downloads.php?') ? 'white' : 'grey' ?>.svg" alt="downloads">
                </div>
                <p>Downloads</p>
              </li>
            </a>
            <a href="notifications.php?user= <?= $_SESSION['username']; ?>">
              <li id="dashboard-notifications" class="db-nav__links__link <?= is_page_active('notifications.php?') ? 'db-nav__links__link--active' : '' ?>">
                <div class="db-nav__links__link__img">
                  <img src="../templates/src/icons/db-notifications-<?= is_page_active('notifications.php?') ? 'white' : 'grey' ?>.svg" alt="notifications">
                </div>
                <p>Notifications</p>
              </li>
            </a>
            <a href="delete-account.php?user= <?= $_SESSION['username']; ?>">
              <li id="dashboard-delete-account" class="db-nav__links__link--danger <?= is_page_active('delete-account.php?') ? 'db-nav__links__link--active' : '' ?>">
                <div class="db-nav__links__link__img">
                  <img src="../templates/src/icons/db-delete-account-<?= is_page_active('delete-account.php?') ? 'white' : 'red' ?>.svg" alt="delete_account">
                </div>
                <p>Delete Account</p>
              </li>
            </a>
          </ul>
        </nav>
        <!-- Dashboard navigation - END -->

        <!-- Form section - START -->
        <section id="dashboard-active-section">