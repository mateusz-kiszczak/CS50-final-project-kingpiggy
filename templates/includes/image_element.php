<?php
function image_element($image_id, $image_thumbnail_url, $image_name, $user_avatar_url, $user_nikname) {
  return '<div class="pictures__img-container">
            <a href="image.php?image_id=' . urlencode($image_id) . '">
              <img class="pictures__img" src="' . $image_thumbnail_url . '" alt="' . $image_name . '"/>
              <div class="pictures__img__more">
                <div class="pictures__img__more__top-section">
                  <h4 class="pictures__img__more__top-section__title">' . $image_name . '</h4>
                </div>
                <div class="pictures__img__more__bottom-section">
                  <button class="user-link--home">
                    <img src="' . $user_avatar_url . '" alt="' . $user_nikname . ' avatar" />
                    <p>' . $user_nikname . '</p>
                  </button>
                  <button class="love-button--home">
                    <img src="templates/src/icons/love.svg" alt="" />
                  </button>
                </div>
              </div>
            </a>
          </div>';
}

function image_element_user($image_id, $image_thumbnail_url, $image_name) {
  return '<div class="pictures__img-container">
            <a href="image.php?image_id=' . urlencode($image_id) . '">
              <img class="pictures__img" src="' . $image_thumbnail_url . '" alt="' . $image_name . '"/>
              <div class="pictures__img__more">
                <div class="pictures__img__more__top-section">
                  <h4 class="pictures__img__more__top-section__title">' . $image_name . '</h4>
                </div>
              </div>
            </a>
          </div>';
}