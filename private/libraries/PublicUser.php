<?php

class PublicUser {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getPublicUserByNikname($userNikname) 
	{
		$sql = 'SELECT users.user_id, users.user_nikname, users.user_name, users.user_surname, users.user_verified, users.user_avatar_url, users.user_is_blocked, users.user_location, users.user_description 
		FROM users 
		WHERE users.user_nikname=:userNikname';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':userNikname', $userNikname);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	// Get url data of a random user's image
	public function getRandomUserImage($userId) 
	{
		$sql = 'SELECT images.image_url 
		FROM images 
		WHERE images.fk_users_images=:userId 
		ORDER BY RAND() 
		LIMIT 1';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':userId', $userId);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getNumberOfRandomContributors($number, $user_id) 
	{
		$sql = 'SELECT 
		users.user_id, users.user_nikname, users.user_location, users.user_avatar_url, 
		SUM(images.image_likes) AS total_user_likes, 
		SUM(images.image_downloads) AS total_user_downloads 
		FROM users 
		INNER JOIN images ON users.user_id = images.fk_users_images 
		WHERE NOT users.user_id = :user_id 
		GROUP BY users.user_id 
		ORDER BY RAND() 
		LIMIT :number';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':number', $number);
		$this->db->bind(':user_id', $user_id);
		
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}
}
