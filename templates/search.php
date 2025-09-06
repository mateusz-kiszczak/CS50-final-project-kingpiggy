<!-- Include image component -->
<?php include('includes/image_element.php'); ?>

<?php
// Valid GET variables
$valid_sort = array("popular", "latest", "loved");
$valid_type = array("all", "images", "vectors");
$valid_orientation = array("all", "portrait", "landscape", "square");
?>

<?php 
    if (!isset($_GET['search']))
    {
        redirect('./index.php');
    }

	if (isset($_GET['sort']) && !in_array($_GET['sort'], $valid_sort)) {
		redirect('./index.php');
	} 

    if (isset($_GET['type']) && !in_array($_GET['type'], $valid_type)) {
		redirect('./index.php');
	} 

    if (isset($_GET['orientation']) && !in_array($_GET['orientation'], $valid_orientation)) {
		redirect('./index.php');
	} 
?>

<?php
    $search_query = isset($_GET['search']) ? $_GET['search'] : '';
    $page_query = isset($_GET['page']) ? $_GET['page'] : '';
    $sort_query = isset($_GET['sort']) ? $_GET['sort'] : '';
    $type_query = isset($_GET['type']) ? $_GET['type'] : '';
    $orientation_query = isset($_GET['orientation']) ? $_GET['orientation'] : '';

	$load_img_offset = $imgs_offset;
	$load_img_limit = $imgs_limit;
?>

<!-- Header -->
<?php 
	view('header', ['Kingpiggy' ?? 'Kingpiggy User']); 
?>

<?php if ($total_results) : ?>

<!-- Main Content - Start -->
<main>
	<!-- Header - Start -->
	<header class="search-title-container">
		<h1>
            <?php 
                if ($search_query === 'all')
                {
                    echo 'Pictures on KingPiggy';
                }
                else
                {
                    echo $total_results . ' ' . ($total_results === 1 ? 'Picture' : 'Pictures') . ' of "' . $search_query . '"'; 
                }
            ?>
        </h1>
	</header>
	<!-- Header - End -->
	<section class="tags-slider__container">
		<h4 class="tags-slider__header">Related Tags</h4>
		<div class="tags-slider">
			<button class="tags-slider__button tags-slider__button--left">
				<img src="templates/src/icons/arrow.svg" alt="Slide left">
			</button>
			<ul class="tags-slider__tags-list">
                <?php if ($related_tags) : ?>
                    <?php foreach($related_tags as $tag) : ?>
                        <li class="tag-button"><a href="search.php?search=<?= $tag; ?>"><?= $tag; ?></a></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No Results</p>
                <?php endif; ?>
			</ul>
			<button class="tags-slider__button tags-slider__button--right">
				<img src="templates/src/icons/arrow.svg" alt="Slide right">
			</button>
		</div>
	</section>
	<section class="pictures__container">
		<div class="pictures__sort-and-filter">
			<div class="pictures__sort-and-filter__filter">
                <div id="search-sort-pictures" class="pictures__sort-and-filter__button">
                    <button class="sort-and-filter-button">Pictures</button>
                    <img class="sort-and-filter-icon-down" src="templates/src/icons/arrow-full.svg" alt="">
                </div>
			    <span class="pictures__sort-and-filter__filter__divider">|</span>
                <hr class="pictures__sort-and-filter__filter__divider--hr">
                <div id="search-sort-orientation" class="pictures__sort-and-filter__button">
                    <button class="sort-and-filter-button">Orientation</button>
                    <img class="sort-and-filter-icon-down" src="templates/src/icons/arrow-full.svg" alt="">
                </div>
            </div>
            <div class="pictures__sort-and-filter__sort">
                <div id="search-sort-sort" class="pictures__sort-and-filter__button">
                    <button class="sort-and-filter-button">

                        <?php
                            if (!$sort_query || $sort_query === '' || $sort_query === 'popular')
                            {
                                echo 'Popular';
                            }
                            elseif ($sort_query === 'latest')
                            {
                                echo 'Latest';
                            }
                            else
                            {
                                echo 'Most Loved';
                            }
                        ?>

                    </button>
                    <img class="sort-and-filter-icon-down" src="templates/src/icons/arrow-full.svg" alt="">
                </div>
            </div>
		</div>
        
        <!-- SORT AND FILTERS - START -->

        <!-- PICTURE TYPE -->
        <div id="pictures-sort-options-filter-type" class="pictures__container__sort-options hide">

            <?php
                function search_url_type($type_option)
                {
                    $searchUrlType = '';

                    $search_query       = isset($_GET['search']) ? $_GET['search'] : '';
                    $page_query         = isset($_GET['page']) ? $_GET['page'] : '';
                    $sort_query         = isset($_GET['sort']) ? $_GET['sort'] : '';
                    $type_query         = isset($_GET['type']) ? $_GET['type'] : '';
                    $orientation_query  = isset($_GET['orientation']) ? $_GET['orientation'] : '';

                    if ($search_query && $page_query)
                    {
                        $searchUrlType = './search.php?search=' . $search_query;
                        $searchUrlType .= $page_query ? '&page=' . $page_query : '';
                        $searchUrlType .= $sort_query ? '&sort=' . $sort_query : '';  
                        $searchUrlType .= $type_option ? '&type=' . $type_option : '&type=all';
                        $searchUrlType .= $orientation_query ? '&orientation=' . $orientation_query : '';            
                    }

                    return $searchUrlType;
                }
            ?>

            <a href="<?= search_url_type('all'); ?>">
				<button class="sort-option-button<?= ((isset($type_query) && $type_query === 'all') || $type_query === '') ? '--active' : '' ?>">All</button>
			</a>
			<span class="pictures-sort-options__divider">|</span>
            <hr class="pictures-sort-options__divider--hr">
			<a href="<?= search_url_type('images'); ?>">
				<button class="sort-option-button<?= (isset($type_query) && $type_query === 'images') ? '--active' : '' ?>">Images</button>
			</a>
			<span class="pictures-sort-options__divider">|</span>
            <hr class="pictures-sort-options__divider--hr">
			<a href="<?= search_url_type('vectors'); ?>">
				<button class="sort-option-button<?= (isset($type_query) && $type_query === 'vectors') ? '--active' : '' ?>">Vectors</button>
			</a>
        </div>

        <!-- PICTURE ORIENTATION -->
        <div id="pictures-sort-options-filter-orientation" class="pictures__container__sort-options hide">

            <?php
                function search_url_orientation($orientation_option)
                {
                    $searchUrlOrientation = '';

                    $search_query       = isset($_GET['search']) ? $_GET['search'] : '';
                    $page_query         = isset($_GET['page']) ? $_GET['page'] : '';
                    $sort_query         = isset($_GET['sort']) ? $_GET['sort'] : '';
                    $type_query         = isset($_GET['type']) ? $_GET['type'] : '';
                    $orientation_query  = isset($_GET['orientation']) ? $_GET['orientation'] : '';

                    if ($search_query && $page_query)
                    {
                        $searchUrlOrientation = './search.php?search=' . $search_query;
                        $searchUrlOrientation .= $page_query ? '&page=' . $page_query : '';
                        $searchUrlOrientation .= $sort_query ? '&sort=' . $sort_query : '';  
                        $searchUrlOrientation .= $type_query ? '&type=' . $type_query : '';            
                        $searchUrlOrientation .= $orientation_option ? '&orientation=' . $orientation_option : '&orientation=all';
                    }

                    return $searchUrlOrientation;
                }

            ?>

            <a href="<?= search_url_orientation('all'); ?>">
				<button class="sort-option-button<?= ((isset($orientation_query) && $orientation_query === 'all') || $orientation_query === '') ? '--active' : '' ?>">All</button>
			</a>
			<span class="pictures-sort-options__divider">|</span>
            <hr class="pictures-sort-options__divider--hr">     
			<a href="<?= search_url_orientation('portrait'); ?>">
				<button class="sort-option-button<?= (isset($orientation_query) && $orientation_query === 'portrait') ? '--active' : '' ?>">Portrait</button>
			</a>
			<span class="pictures-sort-options__divider">|</span>
            <hr class="pictures-sort-options__divider--hr">                     
			<a href="<?= search_url_orientation('landscape'); ?>">
				<button class="sort-option-button<?= (isset($orientation_query) && $orientation_query === 'landscape') ? '--active' : '' ?>">Landscape</button>
			</a>
            <span class="pictures-sort-options__divider">|</span>
            <hr class="pictures-sort-options__divider--hr"> 
			<a href="<?= search_url_orientation('square'); ?>">
				<button class="sort-option-button<?= (isset($orientation_query) && $orientation_query === 'square') ? '--active' : '' ?>">Square</button>
			</a>
        </div>

        <!-- PICTURE SORT -->
        <div id="pictures-sort-options-sort" class="pictures__container__sort-options pictures__container__sort-options--sort hide">
            <?php
                function search_url_sort($sort_option)
                {
                    $searchUrlSort = '';

                    $search_query       = isset($_GET['search']) ? $_GET['search'] : '';
                    $page_query         = isset($_GET['page']) ? $_GET['page'] : '';
                    $sort_query         = isset($_GET['sort']) ? $_GET['sort'] : '';
                    $type_query         = isset($_GET['type']) ? $_GET['type'] : '';
                    $orientation_query  = isset($_GET['orientation']) ? $_GET['orientation'] : '';

                    if ($search_query && $page_query)
                    {
                        $searchUrlSort = './search.php?search=' . $search_query;
                        $searchUrlSort .= $page_query ? '&page=' . $page_query : '';
                        $searchUrlSort .= $sort_option ? '&sort=' . $sort_option : '&sort=popular';
                        $searchUrlSort .= $type_query ? '&type=' . $type_query : '';            
                        $searchUrlSort .= $orientation_query ? '&orientation=' . $orientation_query : '';  
                    }

                    return $searchUrlSort;
                }
            ?>

            <a href="<?= search_url_sort('popular'); ?>">
				<button  class="sort-option-button<?= ((isset($sort_query) && $sort_query === 'popular') || $sort_query === '') ? '--active' : '' ?>">Popular</button>
			</a>
			<span class="pictures-sort-options__divider">|</span>
            <hr class="pictures-sort-options__divider--hr">
			<a href="<?= search_url_sort('latest'); ?>">
				<button class="sort-option-button<?= (isset($sort_query) && $sort_query === 'latest') ? '--active' : '' ?>">Latest</button>
			</a>
			<span class="pictures-sort-options__divider">|</span>
            <hr class="pictures-sort-options__divider--hr">
			<a href="<?= search_url_sort('loved'); ?>">
				<button class="sort-option-button<?= (isset($sort_query) && $sort_query === 'loved') ? '--active' : '' ?>">Most Loved</button>
			</a>
        </div>

        <!-- SORT AND FILTERS - END -->

        <hr class="divider">

        <div class="pictures_pages">
            <div>
                <p>
                    <?php 
                        $output = '<span class="pictures_pages__shows">Shows </span>';
                        $output .= $total_results ? $load_img_offset + 1 : $load_img_offset;

                        if (($total_results < $load_img_limit || $load_img_limit * $page_query > $total_results) && ($load_img_offset + 1) !== $total_results)
                        {
                            $output .= ' - ' . $total_results;
                        }
                        else if (($load_img_offset + 1) === ($load_img_limit * $page_query) && ($load_img_limit * $page_query) === $total_results)
                        {
                            $output .= '';
                        }
                        else if (($load_img_offset + 1) == $total_results)
                        {
                            $output .= '';
                        }
                        else
                        {
                            $output .= ' - ' . $load_img_limit * $page_query; 
                        }

                        // $output .= $total_results < $load_img_limit ? $total_results : $load_img_limit;
                        $output .= ' / ';
                        $output .= $total_results;
                        echo $output;
                    ?>
                </p>
            </div>

            <div class="pictures_pages__page-form">
                <form id="manual-page-number" action="<?= absolute_url(); ?>" method="post">
                    <label for="search-page-number">Page</label>
                    <input class="pictures_pages__page-form__input" type="text" name="search-page-number" id="search-page-number" value="<?= $page_query; ?>">
                    <!-- Passing current data -->
                    <input hidden type="text" name="search" value="<?= $search_query; ?>">
                    <input hidden type="text" name="page" value="<?= $page_query; ?>">
                    <input hidden type="text" name="sort" value="<?= $sort_query; ?>">
                    <input hidden type="text" name="type" value="<?= $type_query; ?>">
                    <input hidden type="text" name="orientation" value="<?= $orientation_query; ?>">
                    <!-- Submit -->
                    <input type="submit" value="go to page" hidden>
                </form>
                <p>&nbsp; / <?= $total_pages; ?></p>
            </div>
        </div>

		<div id="index-loaded-images-container" class="pictures__grid-container">
		<!-- PHP block - Start -->
		<?php if($images) : ?>     
			<!-- Column 1 -->
			<div id="col-1--home" class="pictures__column">
				<?php foreach($images as $key => $img) : ?>
					<?php 
						$true_key = $key + 1;
						if (fmod($true_key, 4) == 1) {
							echo image_element($img->image_id, $img->image_thumbnail_url, $img->image_name, $img->user_avatar_url, $img->user_nikname);
						}
					?>
				<?php endforeach; ?>
			</div>
			<!-- Column 2 -->
			<div id="col-2--home" class="pictures__column">
				<?php foreach($images as $key => $img) : ?>
					<?php 
						$true_key = $key + 1;
						if (fmod($true_key, 4) == 2) {
							echo image_element($img->image_id, $img->image_thumbnail_url, $img->image_name, $img->user_avatar_url, $img->user_nikname);
						}
					?>
				<?php endforeach; ?>
			</div>
			<!-- Column 3 -->
			<div id="col-3--home" class="pictures__column">
				<?php foreach($images as $key => $img) : ?>
					<?php 
						$true_key = $key + 1;
						if (fmod($true_key, 4) == 3) {
							echo image_element($img->image_id, $img->image_thumbnail_url, $img->image_name, $img->user_avatar_url, $img->user_nikname);
						}
					?>
				<?php endforeach; ?>
			</div>
			<!-- Column 4 -->
			<div id="col-4--home" class="pictures__column">
				<?php foreach($images as $key => $img) : ?>
					<?php 
						$true_key = $key + 1;
						if (fmod($true_key, 4) == 0) {
							echo image_element($img->image_id, $img->image_thumbnail_url, $img->image_name, $img->user_avatar_url, $img->user_nikname);
						}
					?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?> 
		<!-- PHP block - End -->
		</div>
        <div class="pictures_pages">
            <p>
                <?php 
                    $output = '<span class="pictures_pages__shows">Shows </span>';
                    $output .= $total_results ? $load_img_offset + 1 : $load_img_offset;
                    $output .= ' - ';
                    $output .= $total_results < $load_img_limit ? $total_results : $load_img_limit;
                    $output .= ' / ';
                    $output .= $total_results;
                    echo $output;
                ?>
            </p>
            <?php
                $searchUrl = '';

                if ($search_query && $page_query)
                {
                    $searchUrl = './search.php?search=' . $search_query;
                    $searchUrl .= '&page=' . $page_query + 1;
                    $searchUrl .= $sort_query ? '&sort=' . $sort_query : '';
                    $searchUrl .= $type_query ? '&type=' . $type_query : '';  
                    $searchUrl .= $orientation_query ? '&orientation=' . $orientation_query : '';            
                }
            ?>
            <a href="<?= $searchUrl; ?>">
                <button class="search__next-button" id="search-next-page-button">Next</button>
            </a>
            <div class="pictures_pages__page-form--bottom-form">
                <form id="manual-page-number" action="<?= absolute_url(); ?>" method="post">
                    <label for="search-page-number">Page</label>
                    <input class="pictures_pages__page-form__input" type="text" name="search-page-number" id="search-page-number" value="<?= $page_query; ?>">
                    <!-- Passing current data -->
                    <input hidden type="text" name="search" value="<?= $search_query; ?>">
                    <input hidden type="text" name="page" value="<?= $page_query; ?>">
                    <input hidden type="text" name="sort" value="<?= $sort_query; ?>">
                    <input hidden type="text" name="type" value="<?= $type_query; ?>">
                    <input hidden type="text" name="orientation" value="<?= $orientation_query; ?>">
                    <!-- Submit -->
                    <input type="submit" value="go to page" hidden>
                </form>
                <p>&nbsp; / <?= $total_pages; ?></p>
            </div>
        </div>
	</section>
</main>
<!-- Main Content - End -->

<?php else : ?>

<main>
	<!-- Header - Start -->
	<header class="search-title-container">
		<h1><?php echo $total_results . ' ' . ($total_results === 1 ? 'Picture' : 'Pictures') . ' of "' . $search_query . '"'; ?></h1>
	</header>
</main>

<?php endif; ?>

<!-- Include Slide Up Button -->
<?php include('includes/go_up_button.php'); ?>
<!-- Include Footer -->
<?php include('includes/footer.php'); ?>
								
<script>
    // Handle manual page number submit and add remainig data to the php file
    // $(document).ready(function() {
    //     $('#manual-page-number').on('submit', function(event) {
    //         event.preventDefault();

    //         $('<input>').attr({
    //             type: 'hidden',
    //             name: 'page',
    //             value: ''
    //         }).appendTo('#manual-page-number');

    //         $('<input>').attr({
    //             type: 'hidden',
    //             name: 'sort',
    //             value: ''
    //         }).appendTo('#manual-page-number');

    //         $('<input>').attr({
    //             type: 'hidden',
    //             name: 'type',
    //             value: ''
    //         }).appendTo('#manual-page-number');

    //         $('<input>').attr({
    //             type: 'hidden',
    //             name: 'orientation',
    //             value: ''
    //         }).appendTo('#manual-page-number');

    //         console.log($('#search-page-number').val());

    //         this.submit();
    //     })
    // });
</script>
