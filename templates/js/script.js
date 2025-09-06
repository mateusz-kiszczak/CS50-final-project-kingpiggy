// CONTENTS
// 1. Global
// 2. Main Navigation
// 3. Tags/Categories Slider
// 4. Masonry
// 5. Scroll Up Button
// 6. Zoom Image
// 7. Characters counter - Comments

/*
 * 1. Global
 */

const global = {
	screenOuterWidth: function() {
		return $(window).outerWidth();
	},

	screenOuterHeight: function() {
		return $(window).outerHeight();
	}
};

const createImageElement = (image_id, image_thumbnail_url, image_name, user_avatar_url, user_nikname) => 
	{
		return (
		`<div class="pictures__img-container not-visible">
			<a href="image.php?image_id=${image_id}">
				<img class="pictures__img" src="${image_thumbnail_url}" alt="${image_name}"/>
				<div class="pictures__img__more">
					<div class="pictures__img__more__top-section">
							<h4 class="pictures__img__more__top-section__title">${image_name}</h4>
					</div>
					<div class="pictures__img__more__bottom-section">
						<button class="user-link--home">
							<img src="${user_avatar_url}" alt="${user_nikname} avatar" />
							<p>${user_nikname}</p>
						</button>
						<button class="love-button--home">
							<img src="templates/src/icons/love.svg" alt="" />
						</button>
					</div>
				</div>
			</a>
		</div>`);
	}


/*
 * 2. Main Navigation
 */

const navigation = {
	openCloseNavigation: function() {
		$(".nav-grid-container").toggleClass("nav-closed");
		$(".nav__container").toggleClass("hide");
	},

	switchNavMenuButton: function() {
		$(".nav-bar__nav-control").children().toggleClass("hide");
	},

	preventBodyFromScroll: function() {
		let attribute = $("body").attr("style");
		if (typeof attribute !== "undefined" && attribute !== false) {
			$("body").removeAttr("style");
		} else {
			$("body").css({
				"overflow":"hidden", 
				"height": "100%"
			});
		}
	},

	toggleUserButton: function() {
		if (global.screenOuterWidth() >= 567) {
			$(".nav-bar__user").removeClass("hide");
		} else {
			$(".nav-bar__user").addClass("hide");
		}
	},

	// Homepage (frontpage)
	toggleLogoSize: function() {
		if (global.screenOuterWidth() < 375) {
			$(".nav-bar__full-logo").addClass("hide");
			$(".nav-bar__logo-icon").removeClass("hide");
		} else {
			$(".nav-bar__full-logo").removeClass("hide");
			$(".nav-bar__logo-icon").addClass("hide");
		}
	},

	// Other pages
	toggleLogoSizeOthers: function() {
		if (global.screenOuterWidth() < 992) {
			$(".nav-bar__full-logo--others").addClass("hide");
			$(".nav-bar__logo-icon--others").removeClass("hide");
		} else {
			$(".nav-bar__full-logo--others").removeClass("hide");
			$(".nav-bar__logo-icon--others").addClass("hide");
		}
	}
}

// On first load
$(window).on("load", function () {
	navigation.toggleUserButton();
	navigation.toggleLogoSize();
});


// jQuery Document Ready Event
$(document).ready(function() {
	navigation.toggleLogoSizeOthers();

	$(".nav-bar__nav-control").on("click", function() {
		navigation.openCloseNavigation();
		navigation.switchNavMenuButton();
		navigation.preventBodyFromScroll();
	});

	$(window).on("resize", function() {
		navigation.toggleUserButton();
		navigation.toggleLogoSize();
		navigation.toggleLogoSizeOthers();
	})
});


/*
 * 3. Tags Slider
 */

const ts = $(".tags-slider__tags-list");  // Tags list <ul>
const tsFirstChild = $(".tag-button").first();
const tsLastChild = $(".tag-button").last();
const tsLeftButton = $(".tags-slider__button--left");
const tsRightButton = $(".tags-slider__button--right");

const tagsSlider = {
	tsWidth: function() {
		return ts.width();
	},

	tsFirstChildPositionLeft: function() {
		if (tsFirstChild.position()) {
			return tsFirstChild.position().left;
		}
	},

	tsLastChildPositionRight: function() {
		if (tsLastChild.position()) {
			return tsLastChild.position().left + tsLastChild.outerWidth();
		}
	},

	tsLastChildPositionRightInner: function() {
		if (tsLastChild.position()) {
			return tsLastChild.position().left + tsLastChild.innerWidth();
		}
	},

	tsAddLeftButton: function() {
		tsLeftButton.addClass("visible");
	},

	tsRemoveLeftButton: function() {
		tsLeftButton.removeClass("visible");
 
	},

	tsAddRightButton: function() {
		tsRightButton.addClass("visible");
	},

	tsRemoveRightButton: function() {
		tsRightButton.removeClass("visible");
	},

	tsToggleLeftRightButtons: function() {
		// Left Button
		if (tagsSlider.tsFirstChildPositionLeft() < 0) {
			tagsSlider.tsAddLeftButton();
		}
		if (tagsSlider.tsFirstChildPositionLeft() >= 0) {
			tagsSlider.tsRemoveLeftButton();
		}
		// Right Button
		if (tagsSlider.tsLastChildPositionRight() > tagsSlider.tsWidth()) {
			tagsSlider.tsAddRightButton();
		}
		if (tagsSlider.tsLastChildPositionRightInner() <= tagsSlider.tsWidth()) {
			tagsSlider.tsRemoveRightButton();
		}
	}
};

$(document).ready(function() {
	// On first load check if right button is needed
	if (tagsSlider.tsLastChildPositionRight() > tagsSlider.tsWidth()) {
		tagsSlider.tsAddRightButton();
	}

	// Manage buttons on scroll
	ts.on("scroll", function() {
		tagsSlider.tsToggleLeftRightButtons();
	});

	// Manage buttons on window resize
	$(window).on("resize", function() {
		tagsSlider.tsToggleLeftRightButtons();
	});

	// Left Button on Click
	tsLeftButton.on("click", function() {
		let currentScrollPosition = ts.scrollLeft();
		if (currentScrollPosition > 200) { 
			ts.animate({ scrollLeft: currentScrollPosition - 200 }, 400);
		} else {
			ts.animate({ scrollLeft: 0 }, 400);
		}
	});

	// Right Button on Click
	tsRightButton.on("click", function() {
		let currentScrollPosition = ts.scrollLeft();
		let maxScrollPosition = ts[0].scrollWidth - ts[0].clientWidth;
		if (currentScrollPosition < maxScrollPosition - 200) { 
			ts.animate({ scrollLeft: currentScrollPosition + 200 }, 400);
		} else {
			ts.animate({ scrollLeft: maxScrollPosition }, 400);
		}
	});
});


/*
 * 4. Masonry
 */

// $(document).ready(function() {
// $("#test").on("click", function() {
//   let lastEl = $(".loading").last();
//   let num = +lastEl.text();
//   console.log(num);
//   if (num < 40) {
//     for (let i = 1; i <= 10; i++) {
//       let newEl = `<div class="pictures__img-container loading">${num + i}<img src="" alt=""></div>`;
//       $(".pictures__grid-container").append(newEl);
//     }
//   } 
// });
// });


/*
 * 5. Scroll Up Button
 */

const scrollUpButton = $(".scroll-up-button");

const scrollUp = {
	bodyCurrentTopPosition: function() {
		let currentPosition = document.getElementsByTagName("body")[0].getBoundingClientRect().top;
		return currentPosition;
	},

	footerCurrentTopPosition: function() {
		let currentPosition = document.getElementsByTagName("footer")[0].getBoundingClientRect().top;
		return currentPosition;
	} 
};

$(document).ready(function() {
	// On Click scroll to the top of the page
	scrollUpButton.on("click", function() {
		$("html, body").animate({ scrollTop: 0 }, "fast");
	});

	// On Scroll
	$(window).on("scroll", function() {
		// If Scroll button does not have class "visible"
		if (!scrollUpButton.hasClass("visible")) {
			// If body position is more than 400px from the top
			if (scrollUp.bodyCurrentTopPosition() < -400 
					// AND the scroll button is not over the footer section
					&& scrollUp.footerCurrentTopPosition() > global.screenOuterHeight()) {
						// Add class "visible" to the scroll button
						scrollUpButton.removeClass("hide");
						// Timeout - add the class after the previous was deleted
						setTimeout(function() {
							scrollUpButton.addClass("visible");
						}, 50);
			}
		// ELSE "If" Scroll button has class "visible"
		} else {
			// If body position is less than 400px from the top 
			if (scrollUp.bodyCurrentTopPosition() > -400
					// OR the scroll button is over the footer section
					|| scrollUp.footerCurrentTopPosition() < global.screenOuterHeight()) {
						// Remove class "visible" from the scroll button
						scrollUpButton.removeClass("visible");
						// Timeout - add the class after the previous was deleted
						setTimeout(function() {
							scrollUpButton.addClass("hide");
						}, 50);
			}
		}
	});
});


/*
 * 6. Zoom Image 
 */

//Image page
const zoomImage = {
	preventBodyFromScroll: function() {
		let attribute = $("body").attr("style");
		if (typeof attribute !== "undefined" && attribute !== false) {
			$("body").removeAttr("style");
		} else {
			$("body").css({
				"overflow":"hidden", 
				"height": "100%"
			});
		}
	},
}
const chosenImage = $("#chosen-image");

const zoomImageSrc = chosenImage.children('source').first().attr("srcset");
const zoomImageAlt = chosenImage.children('img').first().attr("alt");
const zoomImageElement = $("<div id='zoom-container'></div>");

zoomImageElement.append("<img class='zoom-image' src='" + zoomImageSrc + "' alt='" + zoomImageAlt + "' />");

$(document).ready(function() {
	chosenImage.on("click", function() {  
		zoomImage.preventBodyFromScroll();
		$("body").append(zoomImageElement);
		$("#zoom-container").on("click", function() {
			zoomImage.preventBodyFromScroll();
			$("#zoom-container").remove();
		});
	});
});


/*
 * 7. Characters counter - Comments 
 */

$(document).ready(function() {
	const imgNewCommentInput = $("#comment-text");
	const imgCommentInputLengthOutput = $("#comment__logged-in__form__text__counter")
	imgNewCommentInput.on("input", function() {
		imgCommentInputLengthOutput.text(imgNewCommentInput.val().length);
	});
});


// User Page - Other Contributors

$(document).ready(function() {
	const usersWrapper = $(".user__other-contributors");
});


/*
 * 8. User dashboard
 */

const userDb = {
	toggleNavButton: function() {
		// Open/Close button
		$(".db-nav__button").toggleClass("button--dashboard-nav--open button--dashboard-nav--close");
		// Swap the arrow icon inside the button
		$(".db-nav__button__icon--open").toggleClass("hide");
		$(".db-nav__button__icon--close").toggleClass("hide");
		// Toggle show/hide navigation
		$(".db-nav__links").slideToggle("fast");
	}
};


$(document).ready(function() {
	$(".db-nav__button").on("click", function() {
		userDb.toggleNavButton();
	});
	if (global.screenOuterWidth() < 1300) {
		// Hide navigation when first time open
		$(".db-nav__links").hide();
		// Dashboard Navigation
	}

	$(window).on("resize", function() {
		if (global.screenOuterWidth() < 1300) {
			// Hide navigation when screen size smaller than desktop
			$(".db-nav__links").hide();
			if ($(".db-nav__button").hasClass("button--dashboard-nav--close")) {
				// Open/Close button
				$(".db-nav__button").toggleClass("button--dashboard-nav--open button--dashboard-nav--close");
				// Swap the arrow icon inside the button
				$(".db-nav__button__icon--open").toggleClass("hide");
				$(".db-nav__button__icon--close").toggleClass("hide");
			}
		} else {
			$(".db-nav__links").show();
		}
	});
});

// 8.1 Update Image

$(document).ready(function() {
	const imageFormButton = $("#db-user-upload__upload");
	const imageInputFile = $("#image-to-upload");
	const imageInputSubmit = $("#db-user-upload__submit");
	let imageFileName = '';

	// On click trigger input tyle file
	imageFormButton.on("click", function(event) {
		event.preventDefault();

		imageInputFile.click();
	});

	// When input type file change, update image url
	imageInputFile.on("change", function() {
		// Get avatar url
		let url = $(this).val();

		// Split the url to get file name and the extention only
		imageFileName = url.split("\\").pop().split('#')[0].split('?')[0];
		
		// Update the image file name to the DOM
		$("#db-user-upload__file-name > span").text(imageFileName);

		// Remove hide class from submit button
		imageInputSubmit.removeClass("hide");

		// Remove hide class from the form
		$('#db-user-upload-form').removeClass("hide");

		// Remove hide class from file name
		$("#db-user-upload__file-name").removeClass("hide");
	});

	// Submit image when click on the button
	imageInputSubmit.on("click", function(event) {
		event.preventDefault();

		$("#submit-image").click();
	});
});

// 8.1 Update Imgae - Characters Counter

$(document).ready(function() {
	let userInput = $("#db-upload-img-description");
	let charLengthOutput = $("#db-upload-img-chars-value");

	// Update the characters lenght when load the page
	charLengthOutput.text(userInput.val().length);

	// Update the characters lenght when input
	userInput.on("input", function() {
		charLengthOutput.text(userInput.val().length);
	});
});


// 8.2 Edit Profile - Characters Counter

$(document).ready(function() {
	const aboutMeInput = $("#edit-profile-about-me");
	const aboutMeInputLengthOutput = $("#edit-profile-chars-value");

	// Update the characters lenght when load the page
	aboutMeInputLengthOutput.text(aboutMeInput.val().length);

	// Update the characters lenght when input
	aboutMeInput.on("input", function() {
		aboutMeInputLengthOutput.text(aboutMeInput.val().length);
	});
});

	// 8.2 Edit Profile - Upload Avatar

 $(document).ready(function() {
	 const avatarFormButton = $("#db-edit-avatar__upload");
	 const avatarInputFile = $("#file-to-upload");
	 let avatarFileName = '';

	 // On click trigger input tyle file
	 avatarFormButton.on("click", function(event) {
		 event.preventDefault();

		 avatarInputFile.click();
	 });

	 // When input type file change, update image url
	 avatarInputFile.on("change", function() {
		 // Get avatar url
		 let url = $(this).val();

		 // Split the url to get file name and the extention only
		 avatarFileName = url.split("\\").pop().split('#')[0].split('?')[0];
		 
		 // Update the avatar file name to the DOM
		 $("#db-edit-avatar__file-name").text(avatarFileName);

		 // Remove hide class from submit button
		 $("#submit-avatar").removeClass("hide");
	 });
 });


/*
 * 9. SEARCH PAGE
 */

const revertAllFilterArrows = () => 
{
	let filterArrows = document.querySelectorAll('.sort-and-filter-icon-down');
	
	filterArrows.forEach(element => {
		element.classList.remove('sort-and-filter-icon-up');
	});
}

const closeAllFilters = () =>
{
	let filterContainers = document.querySelectorAll('.pictures__container__sort-options');

	filterContainers.forEach(element => {
		if (!element.classList.contains('hide')) {
			element.classList.add('hide');
		}
	});
}


// Sort and filter buttons

$(document).ready(function() {
	$('#search-sort-pictures').on('click', function(event) {
		// If filters are not visible
		if ($('#pictures-sort-options-filter-type').hasClass('hide'))
		{	
			// Close all filters
			revertAllFilterArrows();
			closeAllFilters();

			// Make filters visible
			$('#pictures-sort-options-filter-type').removeClass('hide');
	
			// Change icon arrow to up
			$(this).children('img').addClass('sort-and-filter-icon-up');
		}
		// If filters are visible
		else
		{
			// Close all filters
			revertAllFilterArrows();
			closeAllFilters();
		}
	});

	$('#search-sort-orientation').on('click', function(event) {	
		// If filters are not visible
		if ($('#pictures-sort-options-filter-orientation').hasClass('hide'))
		{	
			// Close all filters
			revertAllFilterArrows();
			closeAllFilters();
			// Make filters visible
			$('#pictures-sort-options-filter-orientation').removeClass('hide');

			// Change icon arrow to up
			$(this).children('img').addClass('sort-and-filter-icon-up');
		}
		// If filters are visible
		else
		{
			// Close all filters
			revertAllFilterArrows();
			closeAllFilters();
		}	
	});

	$('#search-sort-sort').on('click', function(event) {
		// If filters are not visible
		if ($('#pictures-sort-options-sort').hasClass('hide'))
		{	
			// Close all filters
			revertAllFilterArrows();
			closeAllFilters();
			// Make filters visible
			$('#pictures-sort-options-sort').removeClass('hide');

			// Change icon arrow to up
			$(this).children('img').addClass('sort-and-filter-icon-up');
		}
		// If filters are visible
		else
		{
			// Close all filters
			revertAllFilterArrows();
			closeAllFilters();
		}
	});
});
