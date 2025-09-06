<?php 
	// If no user set, redirect to home page
	if (!isset($_SESSION['username'])) 
	{
		redirect('../index.php');
	} 
	elseif (!isset($privateUser[0]->user_nikname) && $_SESSION['username'] !== $privateUser[0]->user_nikname) 
	{
		redirect('../index.php');
	}

    $user_downloads = $userLikesSaves[0]->user_downloads;

    $download_ids = db_str_to_arr($user_downloads);
?>

<?php include('includes/user-dashboard-header.php'); ?>


<div class="dashboard-section-wrapper">
    <h2 id="downloads">Downloads</h2>

    <section class="downloads-and-favourites">
        <h3>Last 30 downloads</h3>
        <ul>
            <?php if ($user_downloads) : ?>
            <?php foreach($download_ids as $download_id) : ?>
                <li>
                    <a href="../image.php?image_id=<?= $download_id; ?>">
                        <?= $image->getImageNameById($download_id)[0]->image_name; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <?php else : ?>
                <li>You did't download any pictures yet</li>
            <?php endif; ?>
        </ul>
    </section>
</div>

<?php include('includes/user-dashboard-footer.php'); ?>
