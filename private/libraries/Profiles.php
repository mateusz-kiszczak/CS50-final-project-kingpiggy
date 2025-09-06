<?php
class Profiles {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}


    /*
	** CREATE
	*/

    public function createProfiles($user_id)
    {
        $sql = 'INSERT 
        INTO profiles(fk_users_profiles) 
        VALUES(:user_id)';

        $this->db->query($sql);

        $this->db->bind(':user_id', $user_id);

        $results = $this->db->resultSet();

        return $results ?? false;
    }


    /*
	** SELECT
	*/

    public function getAllProfilesById($user_id) 
    {
        $sql = 'SELECT profile_facebook, profile_twitter, profile_instagram, profile_youtube, profile_pinterest, profile_website  
        FROM profiles 
        WHERE fk_users_profiles=:user_id';

        $this->db->query($sql);

        $this->db->bind(':user_id', $user_id);

        $results = $this->db->resultSet();

        return $results ?? false;
    }


	/*
	** UPDATE
	*/

    public function updateFacebook(string $url, string $user_id) 
	{
		$sql = 'UPDATE profiles SET profile_facebook=:url WHERE fk_users_profiles=:user_id';

		$this->db->query($sql);

		$this->db->bind(':url', $url);
		$this->db->bind(':user_id', $user_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

    public function updateTwitter(string $url, string $user_id) 
	{
		$sql = 'UPDATE profiles SET profile_twitter=:url WHERE fk_users_profiles=:user_id';

		$this->db->query($sql);

		$this->db->bind(':url', $url);
		$this->db->bind(':user_id', $user_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

    public function updateInstagram(string $url, string $user_id) 
	{
		$sql = 'UPDATE profiles SET profile_instagram=:url WHERE fk_users_profiles=:user_id';

		$this->db->query($sql);

		$this->db->bind(':url', $url);
		$this->db->bind(':user_id', $user_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

    public function updateYoutube(string $url, string $user_id) 
	{
		$sql = 'UPDATE profiles SET profile_youtube=:url WHERE fk_users_profiles=:user_id';

		$this->db->query($sql);

		$this->db->bind(':url', $url);
		$this->db->bind(':user_id', $user_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

    public function updatePinterest(string $url, string $user_id) 
	{
		$sql = 'UPDATE profiles SET profile_pinterest=:url WHERE fk_users_profiles=:user_id';

		$this->db->query($sql);

		$this->db->bind(':url', $url);
		$this->db->bind(':user_id', $user_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}

    public function updateWebsite(string $url, string $user_id) 
	{
		$sql = 'UPDATE profiles SET profile_website=:url WHERE fk_users_profiles=:user_id';

		$this->db->query($sql);

		$this->db->bind(':url', $url);
		$this->db->bind(':user_id', $user_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}
}
