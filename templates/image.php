<!-- Header -->
<?php 
	// Check if image id exists
	if (!$imageDetails[0]) 
	{
		redirect('./index.php');
	} 
	else 
	{
		$img = $imageDetails[0];
		$user_likes_saves = isset($userLikesSaves) ? $userLikesSaves[0] : '';
	}

	// include('..\private\helpers\view.php');
	view('header', ['title' => 'Kingpiggy - ' . $img->image_name . ' by ' . $img->user_nikname ?? '']); 
?>
<!-- Include image component -->
<?php include('includes/image_element.php'); ?>

<main>

	<!-- Main header - START -->
	<section>
		<div class="image-title-container">

			<?php   
				display_all_flash_messages(); 
  			?>

			<h1 class="image__title"><?php echo $img ? $img->image_name : ''; ?></h1>
			<a class="image__location-wrapper" href="https://www.google.com/search?q=<?= str_replace('|', ', ', $img->image_location) ?>">
				<div class="image__location">
					<img src="templates/src/icons/location.svg" alt="Location symbol">
					<p><?php echo $img ? str_replace('|', ', ', $img->image_location) : ''; ?></p>
				</div>
			</a>
			<div class="image__author">
				<img src="<?php echo $img ? $img->user_avatar_url : ''; ?>" alt="<?php echo $img ? $img->user_nikname : 'User'; ?> avatar">
				<p>Image uploaded by <a href="user.php?user=<?php echo $img->user_nikname; ?>">@<?php echo $img ? $img->user_nikname : ''; ?></a></p>
			</div>
		</div>
	</section>
	<!-- Main header - END -->

	<!-- Image Details - START -->
	<section class="image-details-container">
		<picture id="chosen-image" class="selected-image">
			<source media="(min-width: 992px)" srcset="<?php echo $img ? $img->image_url : ''; ?>">
			<img src="<?php echo $img ? $img->image_thumbnail_url : ''; ?>" alt="<?php echo $img ? $img->image_name : ''; ?>">
		</picture>
		<div class="image-info">
			<div class="image-info__love-and-save">

				<?php if (is_user_logged_in()) : ?>
				<?php
					$user_likes_str = $user_likes_saves->user_likes;
					$user_saves_str = $user_likes_saves->user_saves;
					
					$likes_arr = db_str_to_arr($user_likes_str);
					$saves_arr = db_str_to_arr($user_saves_str);
				?>
					<?php if(is_inside_arr($likes_arr, $imageDetails[0]->image_id)) : ?>
						<button id="love-image" class="button-default--small--red">Love it</button>
					<?php else : ?>
						<button id="love-image" class="button-default--small--pink">Love it</button>
					<?php endif; ?>

					<?php if(is_inside_arr($saves_arr, $imageDetails[0]->image_id)) : ?>
						<button id="save-image" class="button-default--small--red">Save</button>
					<?php else : ?>
						<button id="save-image" class="button-default--small--pink">Save</button>
					<?php endif; ?>
				
				<?php else : ?>
					<button id="love-image" class="button-default--small--pink">Love it</button>
					<button id="save-image" class="button-default--small--pink">Save</button>
				<?php endif; ?>

			</div>
			<hr class="divider">
			<ul class="image-info__info-list">
				<li class="info-element">
					<span>Views:</span>
					<span><?php echo $img ? $img->image_views : ''; ?></span>
				</li>
				<li class="info-element">
					<span>Downloads:</span>
					<span id="info-element-downloads"><?php echo $img ? $img->image_downloads : ''; ?></span>
				</li>
				<li class="info-element">
					<span>Loves:</span>
					<span id="info-element-loves"><?php echo $img ? $img->image_likes : ''; ?></span>
				</li>
				<li class="info-element">
					<span>Resolution:</span>
					<span><?php echo $img ? $img->image_width . ' x ' . $img->image_height : ''; ?></span>
				</li>
				<li class="info-element">
					<span>Ratio:</span>
					<span><?php echo $img ? $img->image_ratio : ''; ?></span>
				</li>
				<li class="info-element">
					<span>Camera type:</span>
					<span><?php echo $img ? $img->image_camera_type : ''; ?></span>
				</li>
				<li class="info-element">
					<span>Camera model:</span>
					<span><?php echo $img ? $img->image_camera_name : ''; ?></span>
				</li>
				<li class="info-element">
					<span>Published date:</span>
					<span><?php echo $img ? timestampToDate($img->image_date) : ''; ?></span>
				</li>
			</ul>
			<hr class="divider">
			<div class="image-info__download-button-container">
				<button id="download-image" class="button-default--medium--pink">Download</button>
			</div>
		</div>

		<!-- IF image has description -->
		<?php if ($img->image_description) : ?>
		<section class="image-description">
			<h3>Description</h3>
			<p><?php echo $img->image_description; ?></p>
		</section>
		<?php endif; ?>
		<!-- End IF -->

	</section>
	<!-- Image Details - END -->


	<!-- Tags - START -->
	<section class="tags-slider__container">
		<div class="tags-slider">
			<button class="tags-slider__button tags-slider__button--left">
				<img src="templates/src/icons/arrow.svg" alt="Slide left">
			</button>
			<ul class="tags-slider__tags-list">

				<?php 
					// Assign an array
					$tags = db_tags_to_array($img->image_tags);
				?>

				<?php if($tags && $tags[0]) : ?>
					<!-- Loop trough the array - START -->
					<?php foreach($tags as $tag) : ?>
						<li class="tag-button"><a href="search.php?search=<?php echo $tag; ?>"><?php echo $tag; ?></a></li>
					<?php endforeach; ?>
					<!-- Loop trough the array - END -->
				<?php else : ?>

					<p>No tags availible</p>

				<?php endif; ?>

			</ul>
			<button class="tags-slider__button tags-slider__button--right">
				<img src="templates/src/icons/arrow.svg" alt="Slide right">
			</button>
		</div>
	</section>
	<!-- Tags - END -->

	<!-- Comments - START -->
	<section class="comments-container">
		<!-- If have comments -->
		<!-- Print total number of comments -->
		<?php if($comments && $comments[0]) : ?>
			<h3><?php echo count($comments); ?><?php echo count($comments) > 1 ? " Comments" : " Comment"; ?></h3>
		<!-- Else, print "No Comments" -->
		<?php else : ?>
			<h3>No Comments</h3>
		<?php endif; ?>
		<!-- END If Else -->
		
		<!-- If have comments -->
		<?php if($comments && $comments[0]) : ?>
		<ul class="comments-list">
			<!-- START foreach loop -->
			<?php foreach($comments as $comment) : ?>
			<li class="comment">
				<img class="comment__avatar" src="<?php echo $comment->user_avatar_url ?>" alt="<?php echo $comment->comment_user ?> avatar">
				<div class="comment__details">
					<p class="comment__info">
						<span class="comment__info__username">@<?php echo $comment->comment_user ?></span>
						<span class="comment__info__date"><?php echo timestampToDateSlash($comment->comment_date); ?>&nbsp;<span class="comment__info__date--time"><?php echo timestampToFullTime($comment->comment_date); ?></span></span>
					</p>
					<p class="comment__info__content"><?php echo $comment->comment_body; ?></p>
				</div>
			</li>
			<li><hr class="divider"></li>
			<?php endforeach; ?>
			<!-- END foreach loop -->
		</ul>
		<?php endif; ?>
		<!-- END If -->

		<!-- Add comment - START -->

		<!-- If user is NOT logged in  -->
		<?php if (!is_user_logged_in()) : ?>
			<section class="comment__not-loged-in">
				<h4>You need to be LOGGED IN to write a comment</h4>
			</section>
		<?php endif; ?>

		<section class="comment__logged-in">
			<h4>Add comment for the <span class="comment__logged-in__image-name">"<?php echo $img ? $img->image_name : ""; ?>"</span></h4>
			<form class="comment__logged-in__form" action="image.php?image_id=<?= $imageDetails[0]->image_id; ?>" method="POST">
				<div class="comment__logged-in__form__text">
					<label class="comment__logged-in__form__text__label" for="comment-text">Write your comment below</label>
					<textarea class="comment__logged-in__form__text__textarea" id="comment-text" name="comment-text" maxlength="500" type="text"  spellcheck="true"><?= $inputs['comment-text'] ?? ''; ?></textarea>
					<div class="comment__logged-in__form__text__alert-and-counter">
						<div class="comment__logged-in__form__alert-message">
							<p><?= $errors['comment-text'] ?? ''; ?></p>
						</div>
						<p><span id="comment__logged-in__form__text__counter">0</span>/500</p>
					</div>
				</div>
				<input class="button-default--small--pink" type="submit" value="Add Comment">
			</form>
		</section>
		<!-- Add comment - END -->
	</section>
	<!-- Comments - END -->

	<!-- Related Images - START -->
	<section class="pictures__container--bg-grey">
		<h3>Related Images</h3>
		<div class="pictures__grid-container">
		<!-- PHP block - Start -->
		<?php if($related_images) : ?>     
			<!-- Column 1 -->
			<div id="col-1--home" class="pictures__column">
				<?php foreach($related_images as $key => $img) : ?>
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
				<?php foreach($related_images as $key => $img) : ?>
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
				<?php foreach($related_images as $key => $img) : ?>
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
				<?php foreach($related_images as $key => $img) : ?>
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

		<!-- <div class="pictures__load-more">
			<button class="button-default--large" id="test">Show All</button>
		</div> -->
		
	</section>
	<!-- Related Images - END -->
</main>

<!-- Footer -->
<?php include('includes/footer.php'); ?>

<script>
	$(document).ready(function() {
		$("#download-image").click(function() {
			// Assign image source and destination paths
			let imageUrl = "<?= 'https://' . $_SERVER['SERVER_NAME'] . '/' . $imageDetails[0]->image_url; ?>";
			let destination = "<?= strtolower($imageDetails[0]->image_name) . ' by ' . $imageDetails[0]->user_nikname . '.' . strtolower($imageDetails[0]->image_extention); ?>";
			
			// Send an AJAX request to update the downloads count
			$.ajax({
				url: 'image.php?image_id=<?= $imageDetails[0]->image_id; ?>',
				type: 'POST',
				data: { image_id: <?= $imageDetails[0]->image_id;?> },
				success: function(response) {
					console.log('Image: "<?= $imageDetails[0]->image_name; ?>" was downloaded!');
				}
			});

			// Download Image
			$.ajax({
				url: imageUrl,
				type: 'GET',
				dataType: 'binary',
				responseType: 'blob',
				success: function(response) {
					let objectURL = URL.createObjectURL(response);
					let link = document.createElement("a");

					link.href = objectURL;
					link.download = destination;
					document.body.appendChild(link);
					link.click();
					document.body.removeChild(link);
				}
			});

			let downloadsValue = $('#info-element-downloads');

			// increase "downloads" value
			downloadsValue.text(+downloadsValue.text() + 1);
		});
	});

	// On click LOVE increase like in the db
	$(document).ready(function() {
		$("#love-image").click(function() {
			$.ajax({
				url: 'image.php?image_id=<?= $imageDetails[0]->image_id; ?>',
				type: 'POST',
				data: { love_it: true },
				success: function(response) {
					console.log('You loved "<?= $imageDetails[0]->image_name; ?>" !');
				}
			});

			// Increase or decrease "loves" on client side
			let lovesValue = $("#info-element-loves");

			if ($(this).hasClass('button-default--small--pink'))
			{	
				// increase "loves" value
				lovesValue.text(+lovesValue.text() + 1);

				// change button class
				$(this).addClass('button-default--small--red');
				$(this).removeClass('button-default--small--pink');
			}
			else {
				// decrease "loves" value
				lovesValue.text(+lovesValue.text() - 1);

				// change button class
				$(this).removeClass('button-default--small--red');
				$(this).addClass('button-default--small--pink');
			}
		});
	});

	// On click SAVE save image id in the db
	$(document).ready(function() {
		$("#save-image").click(function() {
			$.ajax({
				url: 'image.php?image_id=<?= $imageDetails[0]->image_id; ?>',
				type: 'POST',
				data: { save_it: true },
				success: function(response) {
					console.log('You saved "<?= $imageDetails[0]->image_name; ?>" !');
				}
			});

			// Change button class on click
			if ($(this).hasClass('button-default--small--pink'))
			{	
				// change button class
				$(this).addClass('button-default--small--red');
				$(this).removeClass('button-default--small--pink');
			}
			else {
				// change button class
				$(this).removeClass('button-default--small--red');
				$(this).addClass('button-default--small--pink');
			}
		});
	});
</script>