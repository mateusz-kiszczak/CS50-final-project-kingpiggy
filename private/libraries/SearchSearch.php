<?php

class SearchSearch {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	/*
	** CREATE
	*/

    public function addSearch($search_value)
    {
        $sql = 'INSERT 
        INTO searches(search_value, search_last_date) 
        VALUES (:search_value, NOW())';

        $this->db->query($sql);

        $this->db->bind(':search_value', $search_value);

		$results = $this->db->resultSet();

		return $results ?? false;
    }


    /*
	** UPDATE
	*/

    public function increaseSearchTimes($search_id)
    {
        $sql = 'UPDATE searches SET search_times = search_times + 1 WHERE search_id = :search_id';

        $this->db->query($sql);

		$this->db->bind(':search_id', $search_id);

		$results = $this->db->resultSet();

		return $results ?? false;
    }


  	/*
	** SELECT
	*/
    
    public function getSearchTimesById($search_id)
    {
        $sql = 'SELECT search_times FROM searches WHERE search_id = :search_id';

        $this->db->query($sql);

		$this->db->bind(':search_id', $search_id);

		$results = $this->db->resultSet();

		return $results ?? false;
    }

    public function getSearchIdByValue($search_value)
    {
        $sql = 'SELECT search_id FROM searches WHERE search_value = :search_value';

        $this->db->query($sql);

		$this->db->bind(':search_value', $search_value);

		$results = $this->db->resultSet();

		return $results ?? false;
    }

    public function getMostPopularSearches()
    {
        $sql = 'SELECT search_value FROM searches ORDER BY search_times DESC LIMIT 100';

        $this->db->query($sql);

		$results = $this->db->resultSet();

		return $results ?? false;
    }
}
