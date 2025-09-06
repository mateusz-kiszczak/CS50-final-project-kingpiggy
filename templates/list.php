<?php require('../private/helpers/helpers.php'); ?>

<!-- Header -->
<?php 
	// include('..\private\helpers\view.php');
	view('header', ['title' => 'Searches and Tags']); 
?>

<main class="list-container">
    <h1>Searches and Tags</h1>
    <section class="list__top-searches">
        <h2>Top 100 searches</h2>
        <div class="list__top-searches__tags-container">
            <?php foreach($top_100_searches as $search_value) : ?>
                <a href="search.php?search=<?= $search_value->search_value; ?>">
                    <button class="tag-button"><?= $search_value->search_value; ?></button>
                </a>
            <?php endforeach; ?>
		</div>
    </section>
    <section class="list__tags">
        <h2>List of Tags</h2>
            <div class="list__tags-container">

                <!-- Loop through every availible letter in tags - START -->
                <?php foreach($letters_arr as $letter) : ?>
                <section class="list__tags__header_and_list">
                    <!-- Filter array of tags based on a current letter -->
                    <?php 
                        $filtered_tags = array_filter($all_tags_arr, function($tag) use ($letter) {
                            return $tag[0] == $letter;
                        }); 
                        ?>
                    <h3><?= strtoupper($letter) ?></h3>
                    <ul class="list__tags__header_and_list__tags">

                        <!-- Loop through the array of tags with mathing letter - START -->
                        <?php foreach($filtered_tags as $filtered_tag) : ?>
                            
                            <li>
                                <a href="search.php?search=<?= $filtered_tag ?>">
                                    <?= $filtered_tag ?>
                                    <?= ' (' . $image->getNumberOfImagesByTag($filtered_tag )[0]->total_results . ')'; ?>
                                </a>
                            </li>
                            
                        <?php endforeach; ?>
                        <!-- Loop through the array of tags with mathing letter - END -->

                    </ul>
                </section>
                <?php endforeach; ?>
                <!-- Loop through every availible letter in tags - END -->

            </div>
    </section>
</main>

<!-- Footer -->
<?php include('includes/footer.php'); ?>