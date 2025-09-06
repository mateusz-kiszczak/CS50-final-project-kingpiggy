<?php 
// Start session
session_start();

// Includes
require('private/core/init.php');


// Ceate new class with db connection and queries
// Get Image db
$search = new SearchSearch;
$img = new Img;

// Get 100 most popular searches
$top_100_searches = $search->getMostPopularSearches();


// *
// * ALL TAGS
// *

// Get tags from all images
$img_tags_raw = $img->getAllTags();

$all_tags_arr = array();

foreach($img_tags_raw as $img_tags)
{
    $tags_array = explode('|', $img_tags->image_tags);

    foreach($tags_array as $tag)
    {   
        // Remove any white spaces from tag
        $clean_tag = str_replace(' ', '', $tag);
        
        if (!in_array($tag, $all_tags_arr) && !empty($clean_tag))
        {
            array_push($all_tags_arr, $tag);
        }
    }
}

// Sort tags array
sort($all_tags_arr);

// create array with all first letters of availible tags
$letters_arr = array();

foreach($all_tags_arr as $tag)
{
    $item_first_letter = substr($tag, 0, 1);

    if (!in_array($item_first_letter, $letters_arr) && ctype_alpha($item_first_letter)) {
        array_push($letters_arr, $item_first_letter);
    }
}

// Sort tags array
sort($letters_arr);


// Create template
$template = new Template('templates/list.php');

// Pass values to HTML
$template->top_100_searches = $top_100_searches;
$template->all_tags_arr = $all_tags_arr;
$template->letters_arr = $letters_arr;
$template->image = $img;

// Print HTML
echo $template;