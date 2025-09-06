<?php
// Start session
session_start();

// Includes
require('private/core/init.php');
require('private/helpers/helpers.php');
require('private/helpers/sql.php');

// Variables
$imgsLimit = 20;
$imgsOffset = 0;

// Ceate new class with db connection and queries
$image = new Img;
$user = new PublicUser;
$search = new SearchSearch;

// AVAILIBLE GETS
// search
// page
// sort
// type
// orientation
// search-page-number
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$page_query = isset($_GET['page']) ? $_GET['page'] : '';
$sort_query = isset($_GET['sort']) ? $_GET['sort'] : '';
$type_query = isset($_GET['type']) ? $_GET['type'] : '';
$orientation_query = isset($_GET['orientation']) ? $_GET['orientation'] : '';
$search_page_number = isset($_POST['search-page-number']) ? $_POST['search-page-number'] : '';

// Declare arrays
$inputs = [];
$errors = [];


/*
** UPDATE SEARCH_TIMES IN DB
*/

if (is_get_request() && $search_query)
{   
    $search_input = [];
    $search_error = [];

    $get_sanitize = 
    [
        'search' => 'string'
    ];
    
    $get_validate = 
    [
        'search' => 'forbidden: profane_words, profane_words_word | unique: reserved_usernames, reserved_usernames_username'
    ];
    
    $search_input = sanitize($_GET, $get_sanitize);
    $search_error = validate($_GET, $get_validate); 

    if (!$search_error && $search_input) 
    {
        // Get seach id
        $search_id = $search->getSearchIdByValue($search_input['search']);
        $search_id_result = $search_id ? $search_id[0]->search_id : false;
        
        // If searching phrase was already searched, increase search_times in db by 1
        if ($search_id_result)
        {   
            // If session is not yet set
            if (!isset($_SESSION['search_value']))
            {
                // Create a new session with an empty array value;
                $_SESSION['search_value'] = array();

                // Add search value to the array 
                array_push($_SESSION['search_value'], $search_input['search']);

                // Increase search_times in DB
                $search->increaseSearchTimes($search_id_result);
            }
            // Else, session search value array exists
            else
            {
                // If search value is NOT inside the session array
                if (!in_array($search_input['search'], $_SESSION['search_value']))
                {
                    // Add search value to the array 
                    array_push($_SESSION['search_value'], $search_input['search']);

                    // Increase search_times in DB
                    $search->increaseSearchTimes($search_id_result);
                }
            }
        }
        else
        {   
            // Create a new session with an empty array value;
            $_SESSION['search_value'] = array();

            // Add search value to the array 
            array_push($_SESSION['search_value'], $search_input['search']);

            // Else, create a new search 
            $search->addSearch($search_input['search']);
        }
    }
    elseif ($search_error)
    {
        redirect('./index.php');
    }
}


/*
** COUNT IMAGES AND PAGES
*/

// Get number of all results
$total_results = $image->countSearchImages($search_query)[0]->total_results;

// Calculate pages
$total_pages = intval($total_results / $imgsLimit);

if (fmod($total_results, $imgsLimit) || $total_pages === 0)
{
    $total_pages = $total_pages + 1;
}


/*
** HANDLE POST
*/
    
// Handle page number input
if (is_post_request() && isset($_POST['search-page-number']))
{
    // echo $_GET['page'];
    $fields_sanitize = 
    [
        'search-page-number' => 'string',
        'search' => 'string',
        'page' => 'string',
        'sort' => 'string',
        'type' => 'string',
        'orientation' => 'string'
    ];
    
    $fields_validate = 
    [
        'search-page-number' => 'required | alphanumeric',
        'search' => 'required',
        'page' => 'alphanumeric',
        'sort' => 'alphanumeric',
        'type' => 'alphanumeric',
        'orientation' => 'alphanumeric'

    ];
    
    $inputs = sanitize($_POST, $fields_sanitize);
    $errors = validate($_POST, $fields_validate);    

    if (!$errors && $inputs) 
    {   
        $searchUrl = './search.php?search=' . $search_query;
        $searchUrl .= '&page=' . $search_page_number;
        $searchUrl .= $sort_query ? '&sort=' . $sort_query : '&sort=popular';
        $searchUrl .= $type_query ? '&type=' . $type_query : '&type=all';  
        $searchUrl .= $orientation_query ? '&orientation=' . $orientation_query : '&orientation=all';

        redirect($searchUrl);
    }
    else
    {
        redirect('./index.php');
    }
}


/*
** RELATED TAGS
*/

// Get all tags from images where "search query" was included
$related_tags_query = '';

if ($search_query === 'all')
{
    $related_tags_query = $image->getRelatedTags('');
}
else
{
    $related_tags_query = $image->getRelatedTags($search_query);
}

// Declare array of related tags
$related_tags = '';
$related_tags_array = array();

foreach($related_tags_query as $tags)   
{
    $tags_array = explode('|', $tags->image_tags);

    foreach($tags_array as $tag)
    {   
        // Remove any white spaces from tag
        $clean_tag = str_replace(' ', '', $tag);
        
        if (!in_array($tag, $related_tags_array) && $tag !== $search_query && !empty($clean_tag))
        {
            array_push($related_tags_array, $tag);
        }
    }
}

if (count($related_tags_array) > 40)
{
    $related_tags = array_slice($related_tags_array, 0, 40);
} 
else
{
    $related_tags = $related_tags_array;
}


/*
** TEMPLATES
*/


if ($page_query && $page_query > 1)
{
    $imgsOffset = $imgsLimit * $page_query - $imgsLimit;
}

$total_pages = '';

// Create template
$template = new Template('templates/search.php');

// Pass total_results, images, total_pages to HTML
if ($search_query)
{   
    $total_results = '';


    $sql_search_query       = $search_query === 'all' ? '' : $search_query;
    $sql_sort_query         = $sort_query === 'all' ? '' : $sort_query;
    $sql_type_query         = $type_query === 'all' ? '' : $type_query;
    $sql_orientation_query  = $orientation_query === 'all' ? '' : $orientation_query;

    if ($type_query === 'vectors') $sql_type_query = 'svg';

    $template->images = $image->getSearchImagesSortByMultiValues($sql_search_query, $imgsLimit, $imgsOffset, $sql_sort_query, $sql_type_query, $sql_orientation_query);

    // Get number of all results
    $total_results = $image->countSearchImagesAfterFilters($sql_search_query, $sql_sort_query, $sql_type_query, $sql_orientation_query)[0]->total_results;

    $template->total_results = $total_results;


    // Calculate pages
    $total_pages = intval($total_results / $imgsLimit);

    if (fmod($total_results, $imgsLimit) || $total_pages === 0)
    {
        $total_pages = $total_pages + 1;
    }

    $template->total_pages = $total_pages;

    // Check if correct GET values were passed, and create a redirection
    if (!$page_query || $page_query < 0 || $page_query > $total_pages)
    {
        redirect(createSearchUrl($search_query, $page_query, $sort_query, $type_query, $orientation_query, $total_pages));
    }
}
else
{
    redirect('./index.php');
}

// Pass offset and number of images visible on a single page to HTML
$template->imgs_limit = $imgsLimit;
$template->imgs_offset = $imgsOffset;

// Pass related tags to HTML
$template->related_tags = $related_tags;

// Print HTML
echo $template;