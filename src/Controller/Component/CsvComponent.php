<?php

declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Cache\Cache;

/**
 * Csv component
 */

class CsvComponent extends Component
{
	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [
		'delimiter' => ',',
		'enclosure' => '"',
		'filename' => '{name}_{date}',
	];

	protected $filename = '';
	protected $line = array();
	protected $buffer;
	protected $configs;

	public function initialize(array $config): void
	{
		$this->configs = $this->getConfig(null, []);
	}

	public function download($data = [], $filename)
	{

		Configure::write('debug', false);

		$this->_setFileName($filename);
		$this->_setHeaders();
		echo $this->_download($data);
	}

	public function _setFileName($name)
	{
		$this->filename = str_replace('{name}', $name, $this->configs['filename']);
		$this->filename = str_replace('{date}', date("Y_m_d"), $this->filename);
		$this->filename .= '.csv';
	}

	public function _setHeaders()
	{
		$filename = $this->filename;
		$now = gmdate("D, d M Y H:i:s");
		// header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		// header("Last-Modified: {$now} GMT");

		// // force download
		// header("Content-Type: application/force-download");
		// header("Content-Type: application/octet-stream");
		// header("Content-Type: application/download");
		// header('Content-Type: text/csv; charset=utf-8');

		// // disposition / encoding on response body
		// header("Content-Disposition: attachment;filename={$filename}");
		// header("Content-Transfer-Encoding: binary");

		// // Other

		// header("Pragma: no-cache");
		// header("Expires: 0");
		// header("Content-Transfer-Encoding: UTF-8");
		header('Content-Type: text/comma-separated-values');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header("Content-Disposition: attachment; filename={$filename}");
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	}

	public function _download($array)
	{

		if (count($array) == 0) {
			return null;
		}

		// ob_end_clean();

		// $handle = fopen('php://output', 'w');

		// // use keys as column titles
		// fputcsv($handle, array_values($array['0']));
		// unset($array['0']);
		// foreach ($array as $value) {

		//     fputcsv($handle, (array) $value, ',');
		// }

		// fclose($handle);

		// // flush buffer
		// ob_flush();

		// // use exit to get rid of unexpected output afterward
		// exit();

		ob_start();
		$df = fopen("php://output", 'w');
		foreach ($array as $row) {

			fputcsv($df, $row, ',');
		}
		fclose($df);
		return ob_get_clean();
	}

	public function convertCsvToArray($file, $schema_of_import)
	{

		var_dump($file);
		$finalData = [];
		$fileTOOpen = $file->getStream()->getMetadata('uri');
		$fh = fopen($fileTOOpen, 'r');
		set_time_limit(0);
		ini_set('memory_limit', '512M');
		$counter = 0;
		while (($line = fgetcsv($fh, null, ',', '"')) != false) {
			$lineData = [];


			// debug(count($line));
			// debug(count($schema_of_import));
			if (count($schema_of_import) == count($line)) {

				// debug($line);
				if ($counter > 0) { // To ignor header line

					for ($i = 0; $i < count($schema_of_import); $i++) {

						$lineData[$schema_of_import[$i]] = $line[$i];
					}
					$finalData[] = $lineData;
				}
				$counter++;
			}
		}

		// Cache::write('csv', json_encode($finalData), '_users_importing_');
		return $finalData;
	}
	public function convertCsvToArrayNew($file, $schema_of_import)
	{

		$finalData = [];
		$fileTOOpen = $file['tmp_name']; //$file->getStream()->getMetadata('uri');

		$fh = fopen($fileTOOpen, 'r');
		

		set_time_limit(0);
		ini_set('memory_limit', '512M');
		$counter = 0;
		while (($line = fgetcsv($fh, null, ',', '"')) != false) {
			$lineData = [];


			var_dump($file);
			echo '<br/>';
			var_dump($line);
			die;
			
			// debug(count($line));
			// debug(count($schema_of_import));
			if (count($schema_of_import) == count($line)) {

				// debug($line);
				if ($counter > 0) { // To ignor header line

					for ($i = 0; $i < count($schema_of_import); $i++) {

						$lineData[$schema_of_import[$i]] = $line[$i];
					}
					$finalData[] = $lineData;
				}
				$counter++;
			}
		}

		// Cache::write('csv', json_encode($finalData), '_users_importing_');
		return $finalData;
	}
}
