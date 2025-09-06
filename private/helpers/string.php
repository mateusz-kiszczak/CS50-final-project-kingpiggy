<!-- Change string of tags into array of tags -->
<?php 
function db_tags_to_array($string): array 
{
  $tags = explode('|', $string);
  return $tags;
}

// Change user input of tags into an array of tags
function user_input_tags_to_array($string) {
  // Explode string to array of tags
  $tags = explode(',', strtolower($string));

  // Remove white spaces from begining and the end of each tag
  $clear_tags = array();

  foreach($tags as $tag) {
    $clear_tag = trim($tag, ' ');
    array_push($clear_tags, $clear_tag);
  }

  // Return an array of tags
  return $clear_tags;
}

function tags_array_to_db_string($arr) 
{
  return implode('|', $arr);
}

function tags_db_string_to_user_string($str) 
{
  return str_replace('|', ', ', $str);
}

// Get first alphabetic character from the string. If nothing availible return "i".
function firstLetterInString($string): string 
{
  foreach (str_split($string) as $char) {
    if (ctype_alpha($char)) {
      return strtolower($char);
    }
  }
  
  return "i";
}


// Remove all special characters from the string, change the to underscore '_' and lowercase the sting
function prepare_img_file_name($string): string 
{ 
  // String to lower cases
  $string = strtolower($string);

  // Remove all the special characters from the string apart from space
  $string = preg_replace('/[^A-Za-z0-9\s]/', '', $string);

  // Replace all the spaces with an underscore
  $string = str_replace(' ', '_', $string);

  return $string;
}