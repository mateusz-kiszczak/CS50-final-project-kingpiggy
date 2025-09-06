<?php

class Comment {
	private $db;

	public function __construct() 
	{
		$this->db = new Database;
	}


	/*
	** SELECT
	*/

	public function getAllComments() 
	{
		$sql = 'SELECT * FROM comments';

		$this->db->query($sql);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	// Get comments by Image Id, join image table then join users table to get related user's avatar url.
	// Relation: Users -> Images -> Comments
	public function getCommentsByImg($img_id) 
	{
		$sql = 'SELECT comments.*, users.user_avatar_url 
		FROM comments 
		INNER JOIN 
		users ON comments.fk_users_comments = users.user_id 
		WHERE comments.fk_images_comments = :img_id 
		AND comments.comment_blocked=0
		ORDER BY comments.comment_date DESC';
		

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':img_id', $img_id);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}

	
	/*
	** CREATE
	*/
	
	public function addComment($username, $comment_body, $user_id, $image_id)
	{
		$sql = 'INSERT 
		INTO comments(comment_user, comment_body, fk_users_comments, fk_images_comments) 
		VALUES(:username, :comment_body, :user_id, :image_id)';

		$this->db->query($sql);

		// Bind Values
		$this->db->bind(':username', $username);
		$this->db->bind(':comment_body', $comment_body);
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':image_id', $image_id);

		// Assign result set
		$results = $this->db->resultSet();

		return $results ?? false;
	}


	/*
	** DELETE
	*/

	public function deleteCommentByImgId($image_id)
	{
		$sql = 'DELETE FROM comments WHERE fk_images_comments=:image_id';

		$this->db->query($sql);

		$this->db->bind(':image_id', $image_id);

		$results = $this->db->resultSet();

		return $results ?? false;
	}
}
