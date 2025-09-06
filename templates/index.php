<!-- Include Header -->
<?php include('includes/header_home.php'); ?>
<!-- Include image component -->
<?php include('includes/image_element.php'); ?>

<?php 
	if (isset($_GET['sort']) && ($_GET['sort'] !== 'random' && $_GET['sort'] !== 'latest')) {
		redirect('./index.php');
	} 
?>

<?php
	$load_img_offset = 0;
	$load_img_limit = $imgs_limit;
?>

<!-- Main Content - Start -->
<main>
	<!-- Header - Start -->
	<header>
		<div class="hero-bg-container" style="background-image: url(templates/src/production-img/home-bg.jpg)">
			<div class="hero-bg__overlay">
				<div class="hero-section__container">
					<section class="hero-section">
						<div class="hero-section__header-container">
							<h1>Outstanding royalty-free pictures</h1>
							<p>Hundreds of Pictures added daily by Kingpiggy and Contributors.</p>
						</div>
						<div class="hero-section__search-bar-container">
							<!-- Search Form - Start -->
							<form action="index.php" method="get" role="search">
								<div class="search-bar">
									<input type="search" name="search" placeholder="Search..." autocomplete="off" />
									<button class="search-button" type="submit">
										<img src="templates/src/icons/search.svg" alt="Search icon - magnifying glass">
									</button>
								</div>
							</form>
							<!-- Search Form - End -->
							<p class="hero-section__license-link">Read more about the <a href="license.php">Content License</a></p>
						</div>
					</section>
				</div>
			</div>
		</div>
	</header>
	<!-- Header - End -->
	<section class="tags-slider__container">
		<h4 class="tags-slider__header">Top Categories</h4>
		<div class="tags-slider">
			<button class="tags-slider__button tags-slider__button--left">
				<img src="templates/src/icons/arrow.svg" alt="Slide left">
			</button>
			<ul class="tags-slider__tags-list">
				<li class="tag-button"><a href="search.php?search=remote work">Remote Work</a></li>
				<li class="tag-button"><a href="search.php?search=sustainability">Sustainability</a></li>
				<li class="tag-button"><a href="search.php?search=diversity and inclusion">Diversity and Inclusion</a></li>
				<li class="tag-button"><a href="search.php?search=mental health">Mental Health</a></li>
				<li class="tag-button"><a href="search.php?search=witness and wellness">Fitness and Wellness</a></li>
				<li class="tag-button"><a href="search.php?search=e-commerce">E-commerce</a></li>
				<li class="tag-button"><a href="search.php?search=smart home technology">Smart Home Technology</a></li>
				<li class="tag-button"><a href="search.php?search=virtual reality">Virtual Reality</a></li>
				<li class="tag-button"><a href="search.php?search=healthy eating">Healthy Eating</a></li>
				<li class="tag-button" id="last-but"><a href="search.php?search=digital nomad">Digital Nomad</a></li>
			</ul>
			<button class="tags-slider__button tags-slider__button--right">
				<img src="templates/src/icons/arrow.svg" alt="Slide right">
			</button>
		</div>
	</section>
	<section class="pictures__container">
		<div class="pictures__sort--home">
			<a href="index.php">
				<button class="sort--button--home <?= isset($_GET['sort']) ? '' : 'sort--active--home' ?>">Popular</button>
			</a>
			<span>|</span>
			<a href="index.php?sort=random">
				<button class="sort--button--home <?= (isset($_GET['sort']) && $_GET['sort'] === 'random') ? 'sort--active--home' : '' ?>">Random</button>
			</a>
			<span>|</span>
			<a href="index.php?sort=latest">
				<button class="sort--button--home <?= (isset($_GET['sort']) && $_GET['sort'] === 'latest') ? 'sort--active--home' : '' ?>">Latest</button>
			</a>
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
		<div class="pictures__load-more">
			<button class="button-default--large" id="index-load-images-button">Load More</button>
		</div>
	</section>
	<section class="home__license">
		<h3>Royalty-free images, you can use anywhere*</h3>
		<p class="home__license__description">Kingpiggy is a community of artistic people sharing royalty-free images. Kingpiggy releases the website's content under the Content Licence, so you can safely use pictures without  asking for permission. Giving credit to the artist is not required, but we highly recommend doing so. Please learn more about our licence using the link below.</p>
		<p>*Some restrictions of use can apply. Please check our license.</p>
		<a class="home__license__link" href="license.php">Learn more about our license</a>
	</section>
</main>
<!-- Main Content - End -->

<!-- Include Slide Up Button -->
<?php include('includes/go_up_button.php'); ?>
<!-- Include Footer -->
<?php include('includes/footer.php'); ?>
								
<script>

	$(document).ready(function() 
	{	
		// Get current offset
		let offset = <?= $load_img_offset; ?>;
		let limit = <?= $load_img_limit; ?>;

		// Number of urrently loaded images
		let allImgsLength = offset;

		$('#index-load-images-button').click(function () 
		{
			// Update Load start and end
			offset = offset + limit;
	
			// Start AJAX
			$.ajax(
			{
				url: '../ajax/index-load-images.php',
				type: 'GET',
				data: 
				{ 
					load_img_limit: limit, 
					load_img_offset: offset + 1,
					sort: '<?= $_GET['sort'] ?? ''; ?>'
				},
				success: function(data)
				{	
					// Masonry columns
					const col1 = $('#col-1--home');
					const col2 = $('#col-2--home');
					const col3 = $('#col-3--home');
					const col4 = $('#col-4--home');

					// For each image from jSON response load imgae into DOM
					$.each(data, function(index, image) 
					{
						// Create new image
						let newImageElement = $(createImageElement(image.image_id, image.image_thumbnail_url, image.image_name, image.user_avatar_url, image.user_nikname));

						if (index % 4 == 1)
						{
							col1.append(newImageElement);
						}
						if (index % 4 == 2)
						{
							col2.append(newImageElement);
						}
						if (index % 4 == 3)
						{
							col3.append(newImageElement);
						}
						if (index % 4 == 0)
						{
							col4.append(newImageElement);
						}
						
						// Find the image element and attach the load event handler 
						newImageElement.find('img').on('load', function() 
						{ 
							// Add the 'visible' class to the closest ancestor with a specified class 
							$(this).closest('.pictures__img-container').addClass('visible').removeClass('not-visible');
						});
					})

					// Update number of currently loaded images
					allImgsLength = $('.pictures__img-container').length;
					
					// console.log(`Images on screen by CLass: ${allImgsLength}`);
					// console.log(`Images in current load: ${data.length}`);


					// Hide 'load more' button if loaded more than 80 images OR there is no more images to load
					if (allImgsLength >= 80)
					{
						$('#index-load-images-button').text('Show All');
						$('#index-load-images-button').wrap('<a href="search.php?search=all"></a>')
					}
					if (data.length < limit)
					{
						$('#index-load-images-button').fadeOut(250, function() 
						{	
							$(this).remove();
						});
					}
				}
			});
		});
	});
</script>
