<?php

class Img {
	private $db;

	public function __construct() 
	{
		$this->db = new Database;
	}

	/*
	** SELECT
	*/

	public function getAllImages() 
	{
		$sql = 'SELECT * FROM images';

		$this->db->query($sql);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	// Get images and user data for the mansory thumbnails
	// Order by "popular" - number of likes
	public function getLimitImages($limited, $offset) 
	{
		$sql = 'SELECT images.image_id, images.image_verified, images.image_adult_content, images.image_thumbnail_url, images.image_name, images.image_likes, users.user_id, users.user_nikname, users.user_avatar_url 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 AND images.image_adult_content=0 
		ORDER BY images.image_likes DESC, images.image_name ASC 
		LIMIT :limited OFFSET :offset';

		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':limited', $limited);
		$this->db->bind(':offset', $offset);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getLimitImagesSortByDate($limited, $offset) 
	{
		$sql = 'SELECT images.image_id, images.image_verified, images.image_adult_content, images.image_thumbnail_url, images.image_name, images.image_likes, users.user_id, users.user_nikname, users.user_avatar_url 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 AND images.image_adult_content=0 
		ORDER BY images.image_date DESC, images.image_name ASC 
		LIMIT :limited OFFSET :offset';

		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':limited', $limited);
		$this->db->bind(':offset', $offset);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getLimitImagesRandom($limited, $offset) 
	{
		$sql = 'SELECT images.image_id, images.image_verified, images.image_adult_content, images.image_thumbnail_url, images.image_name, images.image_likes, users.user_id, users.user_nikname, users.user_avatar_url 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 AND images.image_adult_content=0 
		ORDER BY MD5(CONCAT(images.image_id, "secret_key")) 
		LIMIT :limited OFFSET :offset';

		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':limited', $limited);
		$this->db->bind(':offset', $offset);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getAllImagesSortByLikes() 
	{
		$sql = 'SELECT images.image_id, images.image_verified, images.image_adult_content, images.image_thumbnail_url, images.image_name, images.image_likes, users.user_id, users.user_nikname, users.user_avatar_url 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 AND images.image_adult_content=0 
		ORDER BY images.image_likes DESC, images.image_name ASC';

		$this->db->query($sql);
		
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getRelatedImagesSortByDownloads($tags_arr, $image_id)
	{
		$conditions = [];

		foreach ($tags_arr as $tag)
		{
			$conditions[] = 'images.image_tags LIKE "%' . $tag . '%" ';
		}

		$sql = 'SELECT images.*, users.user_id, users.user_nikname, users.user_avatar_url 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 
		AND images.image_adult_content=0 
		AND 
		( ' . implode(' OR ', $conditions) . ' ) 
		AND images.image_id NOT LIKE :image_id 
		ORDER BY images.image_date DESC, images.image_name ASC 
		LIMIT 20';
		
		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':image_id', $image_id);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getSearchImagesSortByDownloads($search_query, $limited, $offset)
	{
		$serach_pattern = '%' . $search_query . '%';

		$sql = 'SELECT images.*, users.user_id, users.user_nikname, users.user_avatar_url 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 
		AND images.image_adult_content=0 
		AND (
			images.image_name LIKE :search_query 
			OR images.image_description LIKE :search_query 
			OR images.image_tags LIKE :search_query
		)  
		ORDER BY images.image_downloads DESC, images.image_name ASC 
		LIMIT :limited OFFSET :offset';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':search_query', $serach_pattern);
		$this->db->bind(':limited', $limited);
		$this->db->bind(':offset', $offset);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getSearchImagesSortByMultiValues($search_query, $limited, $offset, $sort, $type, $orientation)
	{
		$serach_pattern = '%' . $search_query . '%';
		$sort_pattern = '%' . $sort . '%';
		$type_pattern = '%' . $type . '%';
		$orientation_pattern = '%' . $orientation . '%';

		$sort_column = '';

		$type_condition_one = $type === 'images' ? ' NOT ' : ' ';
		$type_condition_two = $type === 'images' ? ' "svg" ' : ' :type ';

		if ($sort === 'latest')
		{
			$sort_column = 'images.image_date';
		}
		elseif ($sort === 'loved')
		{
			$sort_column = 'images.image_likes';
		}
		else 
		{
			$sort_column = 'images.image_downloads';
		}

		$sql = 'SELECT images.*, users.user_id, users.user_nikname, users.user_avatar_url 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 
		AND images.image_adult_content=0 
		AND (
			images.image_name LIKE :search_query 
			OR images.image_description LIKE :search_query 
			OR images.image_tags LIKE :search_query
		) 
		AND images.image_extention' . $type_condition_one . 'LIKE' . $type_condition_two . 
		'AND images.image_orientation LIKE :orientation 
		ORDER BY ' . $sort_column . ' DESC, images.image_name ASC 
		LIMIT :limited OFFSET :offset';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':search_query', $serach_pattern);
		$this->db->bind(':type', $type_pattern);
		$this->db->bind(':sort', $sort_pattern);
		$this->db->bind(':orientation', $orientation_pattern);
		$this->db->bind(':limited', $limited);
		$this->db->bind(':offset', $offset);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getAllImagesSortByDownloads($limited, $offset)
	{
		$sql = 'SELECT images.*, users.user_id, users.user_nikname, users.user_avatar_url 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 
		AND images.image_adult_content=0  
		ORDER BY images.image_downloads DESC, images.image_name ASC 
		LIMIT :limited OFFSET :offset';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':limited', $limited);
		$this->db->bind(':offset', $offset);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function countSearchImages($search_query)
	{
		$serach_pattern = '%' . $search_query . '%';

		$sql = 'SELECT COUNT(*) AS total_results 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 
		AND images.image_adult_content=0 
		AND (
			images.image_name LIKE :search_query 
			OR images.image_description LIKE :search_query 
			OR images.image_tags LIKE :search_query
		)';

		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':search_query', $serach_pattern);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function countSearchImagesAfterFilters($search_query, $sort, $type, $orientation)
	{
		$serach_pattern = '%' . $search_query . '%';
		$sort_pattern = '%' . $sort . '%';
		$type_pattern = '%' . $type . '%';
		$orientation_pattern = '%' . $orientation . '%';

		$type_condition_one = $type === 'images' ? ' NOT ' : ' ';
		$type_condition_two = $type === 'images' ? ' "svg" ' : ' :type ';

		$sql = 'SELECT COUNT(*) AS total_results 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id 
		WHERE images.image_verified=1 
		AND images.image_adult_content=0 
		AND (
			images.image_name LIKE :search_query 
			OR images.image_description LIKE :search_query 
			OR images.image_tags LIKE :search_query
		) 
		AND images.image_extention' . $type_condition_one . 'LIKE' . $type_condition_two . 
		'AND images.image_orientation LIKE :orientation';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':search_query', $serach_pattern);
		$this->db->bind(':type', $type_pattern);
		$this->db->bind(':sort', $sort_pattern);
		$this->db->bind(':orientation', $orientation_pattern);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getRelatedTags($search_query)
	{
		$serach_pattern = '%' . $search_query . '%';

		$sql = 'SELECT image_tags FROM images WHERE image_tags LIKE :search_query ORDER BY RAND() LIMIT 40';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':search_query', $serach_pattern);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getImage($imageId) 
	{
		$sql = 'SELECT images.image_id, images.image_name, images.image_extention, images.image_location, images.image_thumbnail_url, images.image_url, images.image_height, images.image_width, images.image_ratio, images.image_camera_type, images.image_date, images.image_description, images.image_camera_name, images.image_likes, images.image_downloads, images.image_views, images.image_tags, users.user_nikname, users.user_avatar_url, users.user_saves, users.user_likes 
		FROM images 
		INNER JOIN users ON images.fk_users_images=users.user_id
		WHERE images.image_id=:imageId';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':imageId', $imageId);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}


	public function getImagesByUserId($user_id)
	{
		$sql = 'SELECT * 
		FROM images 
		WHERE fk_users_images=:user_id';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':user_id', $user_id);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getImageByUserAndImageId($user_id, $image_id)
	{
		$sql = 'SELECT * 
		FROM images 
		WHERE fk_users_images=:user_id 
		AND image_id=:image_id';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':image_id', $image_id);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getImageNameById($image_id)
	{
		$sql = 'SELECT image_name 
		FROM images 
		WHERE image_id=:image_id';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':image_id', $image_id);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getAllImagesLikesByUserId($user_id) 
	{	
		$sql = 'SELECT SUM(image_likes) 
		AS total_user_likes 
		FROM images 
		WHERE fk_users_images = :user_id';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':user_id', $user_id);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getAllImagesDownloadsByUserId($user_id) 
	{	
		$sql = 'SELECT SUM(image_downloads) 
		AS total_user_downloads 
		FROM images 
		WHERE fk_users_images = :user_id';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':user_id', $user_id);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getAllTags()
	{
		$sql = 'SELECT image_tags FROM images';

		$this->db->query($sql);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getNumberOfImagesByTag($tag)
	{
		$tag_pattern = '%' . $tag . '%';

		$sql = 'SELECT COUNT(*) AS total_results FROM images WHERE image_tags LIKE :tag';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':tag', $tag_pattern);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	/*
	** CREATE
	*/

	public function uploadImage($imgName, $imgExt, $imgUrl, $imgThumbUrl, $imgHeight, $imgWidth, $imgRatio, $imgOrient, $imgCamType, $imgCamName, $imgLocation, $imgDescription, $imgTags, $userId)
	{
		$sql = 'INSERT 
		INTO images(image_name, image_extention, image_url, image_thumbnail_url, image_height, image_width, image_ratio, image_orientation, image_camera_type, image_camera_name, image_location, image_description, image_tags, fk_users_images) 
		VALUES(:imgName, :imgExt, :imgUrl, :imgThumbUrl, :imgHeight, :imgWidth, :imgRatio, :imgOrient, :imgCamType, :imgCamName, :imgLocation, :imgDescription, :imgTags, :userId)';

		$this->db->query($sql);

		// Bind values
		$this->db->bind(':imgName', $imgName);
		$this->db->bind(':imgExt', $imgExt);
		$this->db->bind(':imgUrl', $imgUrl);
		$this->db->bind(':imgThumbUrl', $imgThumbUrl);
		$this->db->bind(':imgHeight', $imgHeight);
		$this->db->bind(':imgWidth', $imgWidth);
		$this->db->bind(':imgRatio', $imgRatio);
		$this->db->bind(':imgOrient', $imgOrient);
		$this->db->bind(':imgCamType', $imgCamType);
		$this->db->bind(':imgCamName', $imgCamName);
		$this->db->bind(':imgLocation', $imgLocation);
		$this->db->bind(':imgDescription', $imgDescription);
		$this->db->bind(':imgTags', $imgTags);
		$this->db->bind(':userId', $userId);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}


	/*
	** UPDATE
	*/

	public function updateLocation(string $location, string $image_id) 
	{
		$sql = 'UPDATE images SET image_location=:location WHERE image_id=:image_id';

		$this->db->query($sql);

		$this->db->bind(':location', $location);
		$this->db->bind(':image_id', $image_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateTags(string $tags, string $image_id) 
	{
		$sql = 'UPDATE images SET image_location=:tags WHERE image_id=:image_id';

		$this->db->query($sql);

		$this->db->bind(':tags', $tags);
		$this->db->bind(':image_id', $image_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateDescription(string $description, string $image_id) 
	{
		$sql = 'UPDATE images SET image_location=:description WHERE image_id=:image_id';

		$this->db->query($sql);

		$this->db->bind(':description', $description);
		$this->db->bind(':image_id', $image_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function increaseDownloads(string $image_id) 
	{
		$sql = 'UPDATE images SET image_downloads = image_downloads + 1 WHERE image_id=:image_id';

		$this->db->query($sql);

		$this->db->bind(':image_id', $image_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function increaseLoves(string $image_id) 
	{
		$sql = 'UPDATE images SET image_likes = image_likes + 1 WHERE image_id=:image_id';

		$this->db->query($sql);

		$this->db->bind(':image_id', $image_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function decreaseLoves(string $image_id) 
	{
		$sql = 'UPDATE images SET image_likes = image_likes - 1 WHERE image_id=:image_id';

		$this->db->query($sql);

		$this->db->bind(':image_id', $image_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function increaseViews(string $image_id) 
	{
		$sql = 'UPDATE images SET image_views = image_views + 1 WHERE image_id=:image_id';

		$this->db->query($sql);

		$this->db->bind(':image_id', $image_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}


	/*
	** DELETE
	*/

	public function deleteImgById($image_id)
	{
		$sql = 'DELETE FROM images WHERE image_id=:image_id';

		$this->db->query($sql);

		$this->db->bind(':image_id', $image_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}
}
