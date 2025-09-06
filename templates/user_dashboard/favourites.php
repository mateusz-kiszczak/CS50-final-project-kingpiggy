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

    $user_likes = $userLikesSaves[0]->user_likes;
    $user_saves = $userLikesSaves[0]->user_saves;

    $like_ids = db_str_to_arr($user_likes);
    $save_ids = db_str_to_arr($user_saves);
?>

<?php include('includes/user-dashboard-header.php'); ?>


<div class="dashboard-section-wrapper">
    <h2>Favourites</h2>

    <section class="downloads-and-favourites">
        <h3>Last 30 loves</h3>
        <ul>
            <?php if ($user_likes) : ?>
            <?php foreach($like_ids as $like_id) : ?>
                <li>
                    <a href="../image.php?image_id=<?= $like_id; ?>">
                        <?= $image->getImageNameById($like_id)[0]->image_name; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <?php else : ?>
                <li>You don't love any pictures</li>
            <?php endif; ?>
        </ul>
    </section>

    <section class="downloads-and-favourites">
        <h3>Last 30 saves</h3>
        <ul>
            <?php if ($user_saves) : ?>
            <?php foreach($save_ids as $save_id) : ?>
                <li>
                    <a href="../image.php?image_id=<?= $save_id; ?>">
                        <?= $image->getImageNameById($save_id)[0]->image_name; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <?php else : ?>
                <li>You don't have any saved pictures</li>
            <?php endif; ?>
        </ul>
    </section>
</div>

<?php include('includes/user-dashboard-footer.php'); ?>
