<?php

// Reduce avatr size and quality
// @source - the image we want to resize
// @destination - the path we want to save a resized image (must be different than SOURCE)
// @max - maximum length in pixels of smaller side (lenght or width)
// @convert_to_webp - used for thumbnails, converts destination image to webp format. deafult false
// @quality - quality of the resized image, default 80 out of 100
// @remove_source - default true, removes the source image
function reduce_image_size($source, $destination, $max, $convert_to_webp = false, $quality = 80, $remove_source = true) 
{
  // Get image size information
  $image_info = getimagesize($source);

  // Extract width and height
  $image_width = $image_info[0];
  $image_height = $image_info[1];

  // Calculate the ratio to scale the image down to the maximum dimension
  $image_ratio = max($image_width / $max, $image_height / $max);

  // Calculate the new dimensions
  $new_image_width = round($image_width / $image_ratio);
  $new_image_height = round($image_height / $image_ratio);

  // Create new image
  $new_image = imagecreatetruecolor($new_image_width, $new_image_height);

  // Get imgage extention and convert it to lower case
  $image_extention = strtolower(pathinfo($source, PATHINFO_EXTENSION)); 

  // Switch statement for different type of image (JPG, JPEG, PNG, GIF, WEBP, BMP)
  switch ($image_extention) {
    case 'jpg':
    case 'jpeg':
      // Load original image
      $source_image = imagecreatefromjpeg($source);

      // Resize the image
      imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_image_width, $new_image_height, imagesx($source_image), imagesy($source_image));

      if ($convert_to_webp)
      {
        imagewebp($new_image, $destination, $quality);
        break;
      }

      // Save the resized image and update it's quality
      imagejpeg($new_image, $destination, $quality);
      break;

    case 'png':
      // Load original image
      $source_image = imagecreatefrompng($source);

      // Resize the image
      imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_image_width, $new_image_height, imagesx($source_image), imagesy($source_image));

      if ($convert_to_webp)
      {
        imagewebp($new_image, $destination, $quality);
        break;
      }

      // Save the resized image and update it's quality
      imagepng($new_image, $destination, $quality);
      break;

    case 'gif':
      // Load original image
      $source_image = imagecreatefromgif($source);

      // Resize the image
      imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_image_width, $new_image_height, imagesx($source_image), imagesy($source_image));

      if ($convert_to_webp)
      {
        imagewebp($new_image, $destination, $quality);
        break;
      }

      // Save the resized image and update it's quality
      imagegif($new_image, $destination);
      break;

    case 'webp':
      // Load original image
      $source_image = imagecreatefromwebp($source);
  
      // Resize the image
      imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_image_width, $new_image_height, imagesx($source_image), imagesy($source_image));
  
      // Save the resized image and update it's quality
      imagewebp($new_image, $destination, $quality);
      break;

    case 'bmp':
      // Load original image
      $source_image = imagecreatefrombmp($source);
  
      // Resize the image
      imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_image_width, $new_image_height, imagesx($source_image), imagesy($source_image));
      
      if ($convert_to_webp)
      {
        imagewebp($new_image, $destination, $quality);
        break;
      }

      // Save the resized image and update it's quality
      imagebmp($new_image, $destination, $quality);
      break;
    }
    
    // Remove the source file
    if ($remove_source) {
      unlink($source);
    }

    // Free up memory
    imagedestroy($source_image);
    imagedestroy($new_image);
}


// Get image width
function get_image_width($source) 
{
  // Get image size information
  $image_info = getimagesize($source);

  // Extract width
  return $image_info[0];
}


// Get image height
function get_image_height($source) {
  // Get image size information
  $image_info = getimagesize($source);

  // Extract width
  return $image_info[1];
}


// Get image ratio
function get_image_ratio($source) 
{
  $image_width = get_image_width($source);
  $image_height = get_image_height($source);

  // Calculate image ratio
  $image_ratio = $image_width / $image_height;

  // If ratio has decimal points, return ratio up to 4 decimal
  if (is_float($image_ratio))
  {
    return number_format($image_ratio, 4);
  }

  // Return ratio
  return $image_ratio;
}

// Get image aspect ratio as a fraction
function get_image_ratio_fraction($source) 
{
  $image_width = get_image_width($source);
  $image_height = get_image_height($source);

  // Calculate greatest common division
  function gcd($a, $b)
  {
    while ($b != 0) {
      $t = $b;
      $b = $a % $b;
      $a = $t;
    }
    return $a;
  }

  // Find the GCD
  $gcd = gcd($image_width, $image_height);

  // Return aspect ratio
  return $image_width / $gcd . ':' . $image_height / $gcd;
}

// Check image orientation
function get_image_orientation($source) 
{
  $image_ratio = get_image_ratio($source);

  if ($image_ratio > 1)
  {
    return 'landscape';
  }
  elseif ($image_ratio < 1)
  {
    return 'portrait';
  }
  else {
    return 'square';
  }
}