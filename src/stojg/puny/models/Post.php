<?php
namespace stojg\puny\models;

/**
 * Description of Post
 *
 * @author stig
 */
class Post {

	/**
	 *
	 * @var string
	 */
	protected $filename = '';

	/**
	 *
	 * @var string
	 */
	protected $metaDivider = "---";

	/**
	 *
	 * @var string
	 */
	protected $content;

	/**
	 *
	 * @var string
	 */
	protected $layout;

	/**
	 *
	 * @var string
	 */
	protected $title;

	/**
	 *
	 * @var boolean
	 */
	protected $comments;

	/**
	 *
	 * @var string
	 */
	protected $date;

	/**
	 *
	 * @var array
	 */
	protected $categories = array();

	/**
	 *
	 * @var boolean
	 */
	protected $loaded = false;

	/**
	 *
	 * @var string
	 */
	protected $cacheKey = '';

	/**
	 * @var string
	 */
	protected $raw = '';
	
	/**
	 *
	 * @param string $filepath
	 */
	public function __construct($filepath) {
		$this->filename = $filepath;
		$this->cacheKey = sha1_file($this->filename);
	}

	public function getCacheKey() {
		return $this->cacheKey;
	}

	/**
	 *
	 * @return string
	 */
	public function getRaw() {
		return $this->raw;
	}

	/**
	 *
	 * @return string
	 */
	public function toHTML() {
		$markdown = new \dflydev\markdown\MarkdownParser();
		return $markdown->transformMarkdown($this->getContent());
	}

	/**
	 *
	 * @return string
	 */
	public function getTitle() {
		$this->loadData();
		return $this->title;
	}

	/**
	 *
	 * @param string $format
	 * @return string
	 */
	public function getDate($format = 'Y-m-d H:i:s') {
		$this->loadData();
		return date($format, strtotime($this->date));
	}

	/**
	 *
	 * @return array
	 */
	public function getCategories() {
		$this->loadData();
		return $this->categories;
	}

	/**
	 *
	 * @return string
	 */
	public function getURL() {
		return str_replace('.md', '', basename($this->filename));
	}

	/**
	 * Get the raw contents
	 *
	 * @return string
	 */
	public function getContent() {
		$this->loadData();
		return $this->content;
	}

	/**
	 *
	 * @param string $content
	 */
	protected function loadData() {
		if($this->loaded) {
			return;
		}
		$content = $this->fileGetContents($this->filename);
		$this->raw = $content;
		$startMeta = strpos($content, $this->metaDivider);
		$endMeta = strpos($content, $this->metaDivider, 1);
		if($startMeta === 0 && $endMeta) {
			$metaData = substr($content, $startMeta, $endMeta+strlen($this->metaDivider));
			$this->setMetadata($metaData);
			$content = substr_replace($content, '', $startMeta, $endMeta+strlen($this->metaDivider));
		}
		
		$this->content = trim($content);
		$this->loaded = true;
	}


	/**
	 *
	 * @param string $string
	 */
	protected function setMetadata($string) {
		$lines = explode(PHP_EOL, $string);
		foreach($lines as $line) {
			$dividerPos = strpos($line, ':');
			if($dividerPos === false) {
				continue;
			}

			$property = trim(substr($line, 0, $dividerPos));
			$value = trim(substr($line, $dividerPos+1));

			if(!$property || !$value) {
				continue;
			}

			if(strpos($value, '"') === 0) {
				$value = str_replace('"', '',$value);
			}

			if(strstr($value, '[')) {
				$value = str_replace(array('[',']'), '', $value);
				$value = explode(',', $value);
			}

			$this->$property = $value;

			
		}
	}

	/**
	 *
	 * @param type $filename
	 * @return boolean
	 */
	protected function fileGetContents($filename) {
		if(!file_exists($filename)) {
			return false;
		}

		if(!is_readable($filename)) {
			return false;
		}

		$fh = fopen($filename, 'r');
		flock($fh, LOCK_SH);
		$content=fread ($fh, filesize($filename));
		flock($fh, LOCK_UN);
		fclose($fh);
		return trim($content);
	}
}