<?php

const DEFAULT_VALIDATION_ERRORS = 
[
	'required' => 'Please enter the %s',
	'email' => 'The %s is not a valid email address',
	'min' => 'The %s must have at least %s characters',
	'max' => 'The %s must have at most %s characters',
	'between' => 'The %s must have between %d and %d characters',
	'same' => 'The %s must match with %s',
	'alphanumeric' => 'The %s should have only letters and numbers',
	'adult' => 'You must be at least 18 years old to use this service',
	'secure' => 'The %s must have between 8 and 64 characters and contain at least one number, one upper case letter, one lower case letter and one special character',
	'unique' => 'The %s already exists',
	'forbidden' => 'This %s contains profane word',
	'uniqueUpdate' => 'The %s is already taken',
	'forbiddenWord' => 'This %s contains profane word',
	'forbiddenPhrase' => 'This %s contains profane phrase',
	'tag' => 'Type at least 3 tags. Seperate them using a coma ","',
	'contains' => 'This %s does not contains required string'
];


/**
 * Validate
 * @param array $data
 * @param array $fields
 * @param array $messages
 * @return array
 */
function validate(array $data, array $fields, array $messages = []): array
{
	// Split the array by a separator, trim each element
	// and return the array
	$split = fn($str, $separator) => array_map('trim', explode($separator, $str));

	// get the message rules
	$rule_messages = array_filter($messages, fn($message) => is_string($message));
	// overwrite the default message
	$validation_errors = array_merge(DEFAULT_VALIDATION_ERRORS, $rule_messages);

	$errors = [];

	foreach ($fields as $field => $option) 
	{
		$rules = $split($option, '|');

		foreach ($rules as $rule) 
		{
			// get rule name params
			$params = [];
			// if the rule has parameters e.g., min: 1
			if (strpos($rule, ':')) 
			{
				[$rule_name, $param_str] = $split($rule, ':');
				$params = $split($param_str, ',');
			} 
			else 
			{
				$rule_name = trim($rule);
			}
			// by convention, the callback should be is_<rule> e.g.,is_required
			$fn = 'is_' . $rule_name;

			if (is_callable($fn)) 
			{
				$pass = $fn($data, $field, ...$params);
				if (!$pass) 
				{
					// get the error message for a specific field and rule if exists
					// otherwise get the error message from the $validation_errors
					$errors[$field] = sprintf(
						$messages[$field][$rule_name] ?? $validation_errors[$rule_name],
						$field,
						...$params
					);
				}
			}
		}
	}

	return $errors;
}

/**
 * Return true if a string is not empty
 * @param array $data
 * @param string $field
 * @return bool
 */
function is_required(array $data, string $field): bool
{
	return isset($data[$field]) && trim($data[$field]) !== '';
}

/**
 * Return true if the value is a valid email
 * @param array $data
 * @param string $field
 * @return bool
 */
function is_email(array $data, string $field): bool
{
	if (empty($data[$field])) 
	{
		return true;
	}

	return filter_var($data[$field], FILTER_VALIDATE_EMAIL);
}

/**
 * Return true if a string has at least min length
 * @param array $data
 * @param string $field
 * @param int $min
 * @return bool
 */
function is_min(array $data, string $field, int $min): bool
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	return mb_strlen($data[$field]) >= $min;
}

/**
 * Return true if a string cannot exceed max length
 * @param array $data
 * @param string $field
 * @param int $max
 * @return bool
 */
function is_max(array $data, string $field, int $max): bool
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	return mb_strlen($data[$field]) <= $max;
}

/**
 * @param array $data
 * @param string $field
 * @param int $min
 * @param int $max
 * @return bool
 */
function is_between(array $data, string $field, int $min, int $max): bool
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	$len = mb_strlen($data[$field]);
	return $len >= $min && $len <= $max;
}

/**
 * Return true if a string equals the other
 * @param array $data
 * @param string $field
 * @param string $other
 * @return bool
 */
function is_same(array $data, string $field, string $other): bool
{
	if (isset($data[$field], $data[$other])) 
	{
		return $data[$field] === $data[$other];
	}

	if (!isset($data[$field]) && !isset($data[$other])) 
	{
		return true;
	}

	return false;
}

/**
 * Return true if a string is alphanumeric
 * @param array $data
 * @param string $field
 * @return bool
 */
function is_alphanumeric(array $data, string $field): bool
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	return ctype_alnum($data[$field]);
}

/**
 * Return true if a password is secure
 * @param array $data
 * @param string $field
 * @return bool
 */
function is_secure(array $data, string $field): bool
{
	if (!isset($data[$field])) 
	{
		return false;
	}

	$pattern = "#.*^(?=.{8,64})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#";
	return preg_match($pattern, $data[$field]);
}

/**
 * Return true if a date is at least 18 years from now
 * @param array $data
 * @param string $field
 * @return bool
 */
function is_adult(array $data, string $field)
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	// Create a DateTime object from the string
	$date = new DateTime($data[$field]);

	// Create a DateTime object for todays's date
	$today = new DateTime();

	// Check if the date of birth is in the future
	if ($date > $today) 
	{
		return false;
	}

	// Calculate the difference in years
	$years_apart = $today->diff($date)->y;

	return $years_apart >= 18;
}

/**
 * Connect to the database and returns an instance of PDO class
 * or false if the connection fails
 *
 * @return PDO
 */
function db(): PDO
{
	static $pdo;
	// if the connection is not initialized
	// connect to the database
	if (!$pdo) 
	{
		$pdo = new PDO(
			sprintf("mysql:host=%s;dbname=%s;charset=UTF8", DB_HOST, DB_NAME),
			DB_USER,
			DB_PASSWORD,
			[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		);
	}
	return $pdo;
}

/**
 * Return true if the $value is unique in the column of a table
 * @param array $data
 * @param string $field
 * @param string $table
 * @param string $column
 * @return bool
 */
function is_unique(array $data, string $field, string $table, string $column): bool
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	$sql = "SELECT $column FROM $table WHERE $column = :value";

	$stmt = db()->prepare($sql);
	$stmt->bindValue(":value", $data[$field]);

	$stmt->execute();

	return $stmt->fetchColumn() === false;
}

// Checks if users input is unique and does not exist in the database. Used when user is logged in only.
// Does not accept error when user is using the data it's already attached to user's db info
function is_uniqueUpdate(array $data, string $field, string $table, string $column1, string $column2, string $username): bool
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	$sql = "SELECT $column1 FROM $table WHERE $column1 = :value AND $column2 != :username";

	$stmt = db()->prepare($sql);
	$stmt->bindValue(":value", $data[$field]);
	$stmt->bindValue(":username", $username);

	$stmt->execute();

	return $stmt->fetchColumn() === false;
}

// Checks is input string contains any profane phrase
function is_forbiddenPhrase(array $data, string $field, string $table, string $column): bool
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	$sql = "SELECT $column FROM $table WHERE INSTR(:value, $column) > 0";

	$stmt = db()->prepare($sql);
	$stmt->bindValue(":value", $data[$field]);

	$stmt->execute();

	return $stmt->fetchColumn() === false;
}

// Helper function for is_forbiddenWord
function run_sql(string $word, string $table, string $column) 
{
	$sql = "SELECT $column FROM $table WHERE $column = :value";
	
	$stmt = db()->prepare($sql);
	$stmt->bindValue(":value", $word);
	
	$stmt->execute();
	
	return $stmt->fetchColumn() === false;
}

// Checks is input word is a profane word
function is_forbiddenWord(array $data, string $field, string $table, string $column): bool
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	$user_input = strtolower($data[$field]);
	$profane_word = false;

	$input_words = explode(" ", $user_input);

	foreach($input_words as $word) 
	{
		if(!run_sql($word, $table, $column)) 
		{
			$profane_word = true;
		}
	}

	if ($profane_word) 
	{
		return false;
	}

	return true;
}

function is_tag(array $data, string $field): bool
{
	if (!isset($data[$field])) 
	{
		return true;
	}

	// Explode string to array of tags
	$tags = explode(',', $data[$field]);

	// Remove white spaces from begining and the end of each tag
	$clear_tags = array();
	

	foreach($tags as $tag) 
	{
		$clear_tag = trim($tag, ' ');
		array_push($clear_tags, $clear_tag);
	}

	// Check if array has an empty items
	foreach($clear_tags as $tag) 
	{
		if (empty($tag)) 
		{
			return false;
		}
	}

	// Check if user provided at least 3 tags
	if (count($clear_tags) < 3) 
	{
		return false;
	}

	return true;
}

// Checks is url contains pro
function is_contains(array $data, string $field, string $required_string): bool
{
	if (!isset($data[$field]) || $data[$field] === null) 
	{
        return true;
    }
	
    if (!str_contains($data[$field], $required_string)) 
	{	
		// if user input - $data[$field] - is "empty". Above does not do the job.
		if (strlen($data[$field] < strlen(($required_string))))
		{
			return true;
		}

        return false;
    }

    return true;
}
