<?php
/*
** USER LOCATION
*/

// Convert location string form Database and convert it to associative array
function location_str_to_arr($str) {
	$location_array_temp = explode('|', $str);
	$location_array = array("city"=>$location_array_temp[0], "country"=>$location_array_temp[1]);

	return $location_array;
};

// Convert location associative array to string
function location_arr_to_str($arr) 
{
	return $arr['city'] . '|' . $arr['country'];
};

// Prepare location string for database
function set_location($city, $country) 
{
	return $city . '|' . $country;
};

// Prapare image location for db
function set_image_location($arr) 
{
	// Assign new string
	$location_str = '';

	// Combine array items into string with '|' after every item
	foreach($arr as $item)
	{
		$location_str = $location_str . trim($item, ' ') . '|';
	}

	// Return the string and remove '|' from the end
	return substr_replace($location_str, '', -1);
}


/*
** IMAGE LOCATION
*/

function img_location_str_to_arr($str) 
{	
	$new_arr = array();

	$locations = explode('|', $str);

	if (isset($locations[0]) && !empty($locations[0]))
	{
		$new_arr['country'] = $locations[0];
	} 
	else 
	{
		$new_arr['country'] = '';
	}

	if (isset($locations[1]) && !empty($locations[1])) {
		$new_arr['city'] = $locations[1];
	}
	else 
	{
		$new_arr['city'] = '';
	}

	if (isset($locations[2]) && !empty($locations[2])) {
		$new_arr['place'] = $locations[2];
	}
	else 
	{
		$new_arr['place'] = '';
	}

	return $new_arr;
}


/*
** SET IF INPUT DIFFERENT THAN IN DATABASE
*/

function set_new_input($user_input, $db_input, $sql) 
{
	if ($user_input !== $db_input) 
	{
		$sql;
	}
};


/*
** Likes/Loves and Saved Images - db string
*/

function db_str_to_arr($str)
{
	return explode('|', $str);
}

function is_inside_arr($arr, $str)
{
	return in_array($str, $arr);
}

function arr_to_db_str($arr)
{
	return implode('|', $arr);
}

// Create search URL
function createSearchUrl($search, $page, $sort, $type, $orientation, $all_pages)
{
    $searchUrl = './search.php';

    // If no search variable set url to home page
    if (!$search)
    {
        $searchUrl = './index.php';
    }
	else 
	{
		$searchUrl = './search.php?search=' . $search;
	}

    if (!$page || $page == 0)
    {
        $searchUrl .= '&page=1';
    }
    elseif ($page > $all_pages)
    {
        $searchUrl .= '&page=' . $all_pages;
    }
	else
	{
		$searchUrl .= '&page=' . $page;
	}

    $searchUrl .= $sort ? '&sort=' . $sort : '&sort=popular';
    $searchUrl .= $type ? '&type=' . $type : '&type=all';  
    $searchUrl .= $orientation ? '&orientation=' . $orientation : '&orientation=all';

    return $searchUrl;
}
