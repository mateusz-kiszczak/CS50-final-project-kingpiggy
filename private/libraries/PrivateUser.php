<?php
class PrivateUser {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}


	/*
	** SELECT
	*/

	public function getAllPrivateUserByNikname(string $userNikname) 
	{
		$sql = 'SELECT * 
		FROM users 
		WHERE users.user_nikname=:userNikname';
		
		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':userNikname', $userNikname);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getUserIdByNikname(string $userNikname) 
	{
		$sql = 'SELECT user_id 
		FROM users 
		WHERE user_nikname=:userNikname';
		
		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':userNikname', $userNikname);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getUserPasswordByNikname(string $user_nikname)
	{
		$sql = 'SELECT user_password 
		FROM users 
		WHERE user_nikname=:user_nikname';
		
		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':user_nikname', $user_nikname);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getUserEmailByNikname(string $user_nikname)
	{
		$sql = 'SELECT user_email 
		FROM users 
		WHERE user_nikname=:user_nikname';
		
		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':user_nikname', $user_nikname);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function getUserLikesAndSaves(string $user_nikname)
	{
		$sql = 'SELECT user_likes, user_saves, user_downloads 
		FROM users 
		WHERE user_nikname=:user_nikname';
		
		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':user_nikname', $user_nikname);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	/*
	** CREATE
	*/

	public function registerUser(string $email, string $username, string $password) 
	{
		$sql = 'INSERT 
		INTO users(user_email, user_nikname, user_password, user_avatar_url) 
		VALUES(:email, :username, :password, :avatar)';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':email', $email);
		$this->db->bind(':username', $username);
		$this->db->bind(':password', password_hash($password, PASSWORD_BCRYPT));
		$this->db->bind(':avatar', 'images/avatars/' . $username . '.png');
		
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}


	/*
	** UPDATE
	*/

	public function loginUser(string $username) 
	{
		$sql = 'SELECT user_id, user_nikname, user_password, user_avatar_url 
		FROM users 
		WHERE user_nikname=:username';

		$this->db->query($sql);
		// Bind Values
		$this->db->bind(':username', $username);
		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateName(string $name, string $username) 
	{
		$sql = 'UPDATE users SET users.user_name=:name WHERE users.user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':name', $name);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateSurname(string $surname, string $username) 
	{
		$sql = 'UPDATE users SET users.user_surname=:surname WHERE user_nikname=:username';
		
		$this->db->query($sql);

		$this->db->bind(':surname', $surname);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateEmail(string $email, string $username) 
	{
		$sql = 'UPDATE users SET user_email=:email WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':email', $email);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateBirthday(string $birthday, string $username) 
	{
		$sql = 'UPDATE users SET user_birthday=:birthday WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':birthday', $birthday);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateLocation(string $location, string $username) 
	{
		$sql = 'UPDATE users SET user_location=:location WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':location', $location);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateDescription(string $description, string $username) 
	{
		$sql = 'UPDATE users SET user_description=:description WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':description', $description);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateAvatar(string $file, string $username) 
	{
		$sql = 'UPDATE users SET user_avatar_url=:file WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':file', 'images/avatars/' . $file);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateLastActivity(string $username) 
	{
		$sql = 'UPDATE users SET user_last_activity=current_timestamp WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateAllowance(int $allowance, string $username) 
	{
		$sql = 'UPDATE users SET user_allowance=:allowance WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':allowance', $allowance);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateUploadedImagesNumber(int $uploaded_images, string $username) 
	{
		$sql = 'UPDATE users SET user_images_uploaded=:uploaded_images WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':uploaded_images', $uploaded_images);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updatePassword(string $password, string $username) 
	{
		$sql = 'UPDATE users SET user_password=:password WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':password', password_hash($password, PASSWORD_BCRYPT));
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function lastKnownIp($client_ip, $username) 
	{
		$sql = 'UPDATE users SET user_last_known_ip=:client_ip WHERE user_nikname=:username';

		$this->db->query($sql);

		$this->db->bind(':client_ip', $client_ip);
		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateUserLikes(string $likes, int $user_id) 
	{
		$sql = 'UPDATE users SET user_likes=:likes WHERE user_id=:user_id';

		$this->db->query($sql);

		$this->db->bind(':likes', $likes);
		$this->db->bind(':user_id', $user_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateUserSaves(string $saves, int $user_id) 
	{
		$sql = 'UPDATE users SET user_saves=:saves WHERE user_id=:user_id';

		$this->db->query($sql);

		$this->db->bind(':saves', $saves);
		$this->db->bind(':user_id', $user_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

	public function updateUserDownloads(string $downloads, int $user_id) 
	{
		$sql = 'UPDATE users SET user_downloads=:downloads WHERE user_id=:user_id';

		$this->db->query($sql);

		$this->db->bind(':downloads', $downloads);
		$this->db->bind(':user_id', $user_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}


	/*
	** DELETE
	*/

	public function deleteUserByUsername($username)
	{
		$sql = 'DELETE FROM users WHERE user_nikname = :username';

		$this->db->query($sql);

		$this->db->bind(':username', $username);

		$results = $this->db->resultSet();

		return $results ?? false;
	}
}
