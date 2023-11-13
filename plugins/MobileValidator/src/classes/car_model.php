<?

class car_model {

	public static function GetMakes() {
		global $db;
		$sql = 'SELECT DISTINCT ON (make) make  FROM `cars` ORDER BY make  ';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			$makes[] = $row['make'];
		}
		return $makes;
	}

	public static function GetModels($make) {
		global $db;
//		$sql = 'SELECT DISTINCT ON (family) family  FROM `car_model` WHERE `make`=\''.$make.'\' ORDER BY family  ';
		$models = array();
		if (!empty($make)) {
			$sql = 'SELECT DISTINCT ON (model) model FROM `cars` WHERE `make`=\'' . $make . '\' ORDER BY model  ';
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result)) {
				$models[] = $row['model'];
			}
		}
		return $models;
	}

	public static function GetSeries($make, $model) {
		global $db;
//		$sql = 'SELECT DISTINCT ON (variant) variant  FROM `car_model` WHERE  `make`=\'' . $make . '\' AND `family`=\'' . $model . '\' ORDER BY variant  ';
		$sql = 'SELECT DISTINCT ON (apl) apl  FROM `cars` WHERE  `make`=\'' . $make . '\' AND `model`=\'' . $model . '\' ORDER BY apl  ';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			$series[] = $row['apl'];
		}
		return $series;
	}

	public static function GetBodies($make, $model, $series) {
		global $db;
		
		$query = 'SELECT DISTINCT ON (body) body FROM cars';
		
		$conditions = array();
		if (!empty($make)){
			$conditions [] = "make = '$make'";
		}
		
		if (!empty($model) && strtolower($series) != 'any'){
			$conditions [] = "model = '$model'";
		}
		
		if (!empty($series) && strtolower($series) != 'any'){
			$conditions [] = "apl = '$series'";
		}
		
		if (!empty ($conditions)){
			$query .= ' WHERE ' . implode(' AND ', $conditions);
		}
		
		$query .= ' ORDER BY body';
		/* @var $db sql_db */
		$result = $db->sql_query($query);
		
		$bodies = array();
		while ($row = $db->sql_fetchrow($result)){
			$bodies[] = $row['body'];
		}
		
		return $bodies;
	}
}

?>
