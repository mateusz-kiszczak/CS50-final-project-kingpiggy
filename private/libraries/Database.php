<?php
class Database {
  private $host = DB_HOST;
	private $user = DB_USER;
	private $password = DB_PASSWORD;
	private $dbname = DB_NAME;

  // Database Handle
  private $db_handle;
  // Statement Handle
  private $stmt_handle;
  private $error;

  public function __construct() {
    // Set DSN
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    // Set options
    $options = array (
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    // Create a new PDO instance
    try {
      $this->db_handle = new PDO($dsn, $this->user, $this->password, $options);
    // Catch any errors
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      die($this->error);
    }
  }

  public function query($query) {
    $this->stmt_handle = $this->db_handle->prepare($query);
  }

  public function bind($param, $value, $type = null) {
		if (is_null ( $type )) {
			switch (true) {
				case is_int ( $value ) :
					$type = PDO::PARAM_INT;
					break;
				case is_bool ( $value ) :
					$type = PDO::PARAM_BOOL;
					break;
				case is_null ( $value ) :
					$type = PDO::PARAM_NULL;
					break;
				default :
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt_handle->bindValue ( $param, $value, $type );
	}

  public function execute() {
    return $this->stmt_handle->execute();
  }

  public function resultSet() {
    $this->execute();
    return $this->stmt_handle->fetchAll(PDO::FETCH_OBJ);
  }
}