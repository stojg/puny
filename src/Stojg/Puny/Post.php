<?php
namespace Stojg\Puny;

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
	protected $metaDivider = "---\n";

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
	 * @param string $filepath
	 */
	public function __construct($filepath) {
		$this->filename = $filepath;
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
		if(!$this->loaded) {
			$this->setContent();
		}
		return $this->title;
	}

	/**
	 *
	 * @param string $format
	 * @return string
	 */
	public function getDate($format = 'Y-m-d H:i:s') {
		if(!$this->loaded) {
			$this->setContent();
		}
		return date($format, strtotime($this->date));
	}

	/**
	 *
	 * @return array
	 */
	public function getCategories() {
		if(!$this->loaded) {
			$this->setContent();
		}
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
		if(!$this->loaded) {
			$this->setContent();
		}
		return $this->content;
	}

	/**
	 *
	 * @param string $content
	 */
	protected function setContent() {
		$content = trim(file_get_contents($this->filename));
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
}