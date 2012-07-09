<?php
namespace stojg\puny;

/**
 * FileSource stores and fetches pages from the file system
 */
class FileSource implements DataSource {

	/**
	 * What divides the the meta data from the actually content in the files
	 *
	 * @var string
	 */
	protected $metaDivider = '---';

	/**
	 * In which directory are the pages saved
	 *
	 * @var string
	 */
	protected $directory = null;

	/**
	 *
	 * @var array
	 */
	protected $items = array();

	/**
	 *
	 * @var int
	 */
	protected $limit = null;

	/**
	 *
	 * @var int
	 */
	protected $offset = 0;

	/**
	 * If we should include draft posts in the list
	 *
	 * @var boolean
	 */
	protected $draft = false;

	/**
	 *
	 * @param string $sourceDir - where the pages are saved on disk
	 */
	public function __construct($sourceDir) {
		$this->directory = str_replace('//', '', $sourceDir);
	}

	/**
	 *
	 * @return int
	 */
	public function count() {
		$this->finalize();
		return count($this->items);
	}

	/**
	 *
	 * @return string - json of the first files in the list
	 */
	public function first() {
		$this->finalize();
		reset($this->items);
		$fileName = current($this->items);
		return $this->loadFile($fileName);
	}

	/**
	 *
	 * @return array - an array of json strings
	 */
	public function toArray() {
		$this->finalize();
		$pages = array();
		foreach($this->items as $item) {
			$pages[] = $this->loadFile($item);
		}
		return $pages;
	}

	/**
	 *
	 * @param int $limit
	 * @return \stojg\puny\FileSource
	 */
	public function limit($limit) {
		$this->limit = (int) $limit;
		return $this;
	}

	/**
	 *
	 * @param int $offset
	 * @return \stojg\puny\FileSource
	 */
	public function offset($offset) {
		$this->offset = (int) $offset;
		return $this;
	}

	/**
	 * If set to true will return the drafts as well
	 *
	 * @param boolean $show
	 */
	public function draft($show) {
		$this->draft = $show;
	}

	/**
	 * Finalize the 'query' and set the internal $items to the resulting pages
	 */
	protected function finalize() {
		$items = glob($this->directory . DIRECTORY_SEPARATOR .'*' );

		if($this->offset) {
			$items = array_slice($items, $this->offset);
		}

		if($this->limit) {
			$items = array_slice($items, 0, $this->limit);
		}
		rsort($items);

		$this->items = $items;
	}

	/**
	 * Load the file and return the data as a json encoded array
	 * 
	 * @param  string $filename - the path to the file to load
	 * @return string - json encoded array
	 */
	protected function loadFile($filename) {
		$fileContent = $this->read($filename);
		$array = $this->convertToArray($fileContent);
		return json_encode($array);
	}

	/**
	 * Get the contents from the file in a lock safe way
	 *
	 * @param string $filename
	 * @return string|boolean
	 */
	protected function read($filename) {
		if(!file_exists($filename)) {
			return false;
		}

		if(!is_readable($filename)) {
			return false;
		}

		$fh = fopen($filename, 'r');
		flock($fh, LOCK_SH);
		$fileSize = filesize($filename);
		if(!$fileSize) {
			return false;
		}

		$content = fread($fh, $fileSize);
		flock($fh, LOCK_UN);
		fclose($fh);
		return trim($content);
	}

	/**
	 * Extract the metadata from the string and return the rest
	 *
	 * @param string $content
	 * @return string
	 */
	protected function convertToArray($content) {
		$result = array();
		$metaStart = strpos($content, $this->metaDivider);
		$metaEnd = strpos($content, $this->metaDivider, 1);

		// No meta data found
		if(!($metaStart === 0 && $metaEnd)) {
			return trim($content);
		}
		
		$metaContent = substr($content, $metaStart, $metaEnd+strlen($this->metaDivider));
		$lines = explode(PHP_EOL, $metaContent);
		
		foreach($lines as $line) {
			// The strpos of the divider between the property and the value
			// Using strpos instead of explode so that values can have : in them
			// as well
			$dividerPos = strpos($line, ':');
			if($dividerPos === false) {
				continue;
			}

			$property = trim(substr($line, 0, $dividerPos));
			$value = trim(substr($line, $dividerPos+1));

			// Remove " signs
			$value = str_replace('"', '', $value);

			// Looks like an array
			if(strstr($value, '[')) {
				$value = str_replace(array('[',']'), '', $value);
				$value = explode(',', $value);
				$value = array_map('trim', $value);
				$value = array_filter($value, 'strlen');
			}
			$result[$property] = $value;
			
		}
		$result['content'] = trim(str_replace($metaContent, '', $content));
		return $result;
	}

	/**
	 * Get the contents from the file in a lock safe way
	 *
	 * @param string $filename
	 * @param string $content
	 * @return boolean
	 */
	protected function filePutContents($filename, $content) {
		$fh = fopen($filename, 'w');
		flock($fh, LOCK_EX);
		fwrite($fh, $content, strlen($content));
		flock($fh, LOCK_UN);
		fclose($fh);
		return true;
	}
}