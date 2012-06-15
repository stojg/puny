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
	protected $fileContents = '';
	
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
		return $this->fileContents;
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
	 * @param string $title
	 * @return \stojg\puny\models\Post
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
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
	 * @param string $date
	 * @return \stojg\puny\models\Post
	 */
	public function setDate($date) {
		$this->date = date('Y-m-d H:i', strtotime($date));
		return $this;
	}

	/**
	 *
	 * @param string $format
	 * @return string
	 */
	public function getDate($format = 'Y-m-d H:i') {
		$this->loadData();
		return date($format, strtotime($this->date));
	}

	/**
	 *
	 * @param string $categories - comma separated list
	 * @return \stojg\puny\models\Post
	 */
	public function setCategories($categories) {
		$this->categories = explode(',', $categories);
		return $this;
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
	 *
	 * @param string $content
	 * @return \stojg\puny\models\Post
	 */
	public function setContent($content) {
		$this->content = $content;
		return $this;
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
	 */
	public function save($directory) {
		$fileContent = "---".PHP_EOL;
		$fileContent.= 'layout: post'.PHP_EOL;
		$fileContent.= 'title: "'.$this->title.'"'.PHP_EOL;
		$fileContent.= 'date: '.$this->date.PHP_EOL;
		$fileContent.= 'comments: true'.PHP_EOL;
		$fileContent.= 'categories: ['.implode(',',$this->categories).']'.PHP_EOL;
		$fileContent.= '---'.PHP_EOL;
		$fileContent.= $this->content;
		
		$filename = date('Y-m-d', strtotime($this->date));
		$filename.= '-'.preg_replace('/[^A-Za-z0-9]/', '-', $this->title);
		$filename = $directory.DIRECTORY_SEPARATOR.strtolower($filename).'.md';

		$fh = fopen($filename, 'w');
		flock($fh, LOCK_EX);
		fwrite($fh, $fileContent, strlen($fileContent));
		flock($fh, LOCK_UN);
		fclose($fh);

		if($filename !== $this->filename) {
			unlink($this->filename);
			$this->filename = $filename;
		}
	}

	/**
	 *
	 */
	protected function loadData() {
		if($this->loaded) {
			return;
		}
		$fileContent = $this->fileGetContents($this->filename);
		$this->fileContents = $fileContent;
		$startMeta = strpos($fileContent, $this->metaDivider);
		$endMeta = strpos($fileContent, $this->metaDivider, 1);
		if($startMeta === 0 && $endMeta) {
			$metaData = substr($fileContent, $startMeta, $endMeta+strlen($this->metaDivider));
			$this->setMetadata($metaData);
			$fileContent = substr_replace($fileContent, '', $startMeta, $endMeta+strlen($this->metaDivider));
		}
		
		$this->content = trim($fileContent);
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