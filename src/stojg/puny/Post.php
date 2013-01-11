<?php
namespace stojg\puny;

/**
 * Represents a single post
 *
 */
class Post {

	/**
	 *
	 * @var string
	 */
	protected $content = '';

	/**
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 *
	 * @var string
	 */
	protected $date = '';

	/**
	 *
	 * @var array
	 */
	protected $categories = array();

	/**
	 * Have we loaded the post from the filesystem
	 *
	 * @var boolean
	 */
	private $loaded = false;

	/**
	 * The raw content for the file
	 *
	 * @var string
	 */
	private $rawContent = '';

	/**
	 * The extension use for the file
	 *
	 * @var string
	 */
	private static $file_extension ='.md';

	/**
	 *
	 * @var string
	 */
	private $filename = '';

	/**
	 * If this is true, to post is a draft
	 * @var bool
	 */
	private $draft = false;

	/**
	 * This marks the content within two of these signs on a single line as meta
	 * data
	 *
	 * @var string
	 */
	private $metaDivider = "---";

	public static function extension() {
		return self::$file_extension;
	}

	/**
	 * savePost saves / creates a post
	 *
	 * @param Slim_Http_Request $request
	 * @param \stojg\puny\Post $post
	 */
	public static function save_post(\Slim_Http_Request $request, Post $post) {
		$post->setContent($request->post('content'))
			->setTitle($request->post('title'))
			->setDate($request->post('date'))
			->setCategories($request->post('categories'))
			->setDraft($request->post('draft'))
			->save('posts');
	}
	
	/**
	 *
	 * @param string $filename - the filepath without extension
	 */
	public function __construct($filename = null) {
		// new post
		if(!$filename) {
			return;
		}
		$this->filename = $filename;
	}

	/**
	 * Get this posts unique identifier (sha1)
	 *
	 * @return string
	 */
	public function getID() {
		return sha1_file($this->filename);
	}

	/**
	 * Get this posts content as html transformed through markdown
	 *
	 * @return string
	 */
	public function getContentHTML() {
		$markdown = new \dflydev\markdown\MarkdownParser();
		return $markdown->transformMarkdown($this->getContent());
	}

	/**
	 * Set the post title
	 *
	 * @param string $title
	 * @return \stojg\puny\models\Post
	 */
	public function setTitle($title) {
		$this->title = $title;
		$this->updateRawContent();
		return $this;
	}

	/**
	 * Get the post title
	 *
	 * @return string
	 */
	public function getTitle() {
		$this->load();
		return $this->title;
	}

	/**
	 * Set the date to anything that strtotime() can handle.
	 *
	 * @param string $date
	 * @return \stojg\puny\models\Post
	 */
	public function setDate($date) {
		$this->date = date('Y-m-d H:i', strtotime($date));
		$this->updateRawContent();
		return $this;
	}

	/**
	 * Get the date
	 *
	 * @param string $format
	 * @return string
	 */
	public function getDate($format = 'Y-m-d H:i') {
		$this->load();
		if(!$this->date) {
			$this->date = 'now';
		}
		return date($format, strtotime($this->date));
	}

	/**
	 *
	 * @param string $categories - comma separated list
	 * @return \stojg\puny\models\Post
	 */
	public function setCategories($categories) {
		$this->categories = explode(',', $categories);
		$this->updateRawContent();
		return $this;
	}

	/**
	 * Get the categories
	 *
	 * @return array
	 */
	public function getCategories() {
		$this->load();
		return $this->categories;
	}

	/**
	 * Get the base filename without the file extension and directory for usage
	 * in URL
	 *
	 * @return string
	 */
	public function basename() {
		return str_replace(Post::extension(), '', basename($this->filename));
	}

	/**
	 * Set the content data
	 *
	 * @param string $content
	 * @return \stojg\puny\models\Post
	 */
	public function setContent($content) {
		$this->content = $content;
		$this->updateRawContent();
		return $this;
	}

	/**
	 * Get the content without meta data
	 *
	 * @return string
	 */
	public function getContent() {
		$this->load();
		return $this->content;
	}

	/**
	 * Returns true if this page exists
	 * @return [type] [description]
	 */
	public function exists() {
		return $this->load();
	}

	/**
	 * Get a summary / description good for meta description field
	 */
	public function getDescription($maxWords=30) {

		$text=strip_tags($this->getContentHTML());
		$text = trim(preg_replace("/\s+/"," ",$text));

		$word_array = explode(" ", $text);

		if(count($word_array) <= $maxWords) {
			return implode(" ",$word_array);
		} else {
			$text='';
		}

		foreach ($word_array as $length=>$word) {
    		$text.=$word ;
    		if($length==$maxWords) {
    			break;
    		} else {
    			$text.=" ";
    		}
		}
		return $text;
	}

	/**
	 * Returns true if this post is a draft 
	 * 
	 * @return bool 
	 */
	public function getDraft() {
		$this->load();
		// It's so weird that it actually works
		// (bool)"true" === true
		return (bool)$this->draft;
	}

	/**
	 * 
	 * @param bool $draft
	 * @return Post
	 */
	public function setDraft($draft) {
		$this->draft = $draft;
		$this->updateRawContent();
		return $this;
	}

	/**
	 * Load data for this post from disk
	 *
	 */
	protected function load() {
		if($this->loaded) {
			return true;
		}

		$fileContent = $this->fileGetContents($this->filename);

		// File is empty or doesn't exists
		if(!$fileContent) {
			$this->loaded = true;
			return false;
		}

		$this->rawContent = $fileContent;
		$this->content = $this->setMetadata($this->rawContent);
		$this->loaded = true;
		return true;
	}

	/**
	 * Save this post on disk
	 */
	public function save($directory) {
		$filename = $directory . DIRECTORY_SEPARATOR . $this->getFilename();
		$this->filePutContents($filename, $this->rawContent);
		
		// If the filename has changed, remove the old file if exists
		if($filename !== $this->filename && is_file($this->filename)) {
			unlink($this->filename);
		}
		$this->filename = $filename;
	}

	/**
	 * Update the raw content to match new data. This method should be called
	 * everytime a data changes
	 * 
	 */
	protected function updateRawContent() {
		
		$this->rawContent = "---".PHP_EOL;
		$this->rawContent.= 'title: "'.$this->title.'"'.PHP_EOL;
		$this->rawContent.= 'date: '.$this->date.PHP_EOL;
		$this->rawContent.= 'categories: ['.implode(',',$this->categories).']'.PHP_EOL;
		if($this->draft) {
			$this->rawContent.='draft: true';
		}

		$this->rawContent.= '---'.PHP_EOL;

		$this->rawContent.= $this->content;
	}

	/**
	 * By using the date and title get a filename for this post
	 *
	 * @return string
	 */
	protected function getFilename() {
		$newFilename = date('Y-m-d', strtotime($this->date));
		$title = str_replace(array("'"), '', $this->title);
		$newFilename.= '-'.preg_replace('/[^A-Za-z0-9]/', '-', $title);
		$newFilename = preg_replace('/--+/', '-', $newFilename);
		$newFilename = trim($newFilename, '-');
		return  strtolower($newFilename).Post::extension();
	}

	/**
	 * Extract the metadata from the string and return the rest
	 *
	 * @param string $content
	 * @return string
	 */
	protected function setMetadata($content) {
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

			if(!property_exists($this, $property) || !$value) {
				continue;
			}

			// Remove " signs
			$value = str_replace('"', '', $value);

			// Looks like an array
			if(strstr($value, '[')) {
				$value = str_replace(array('[',']'), '', $value);
				$value = explode(',', $value);
				$value = array_map('trim', $value);
				$value = array_filter($value, 'strlen');
			}
			$this->$property = $value;
		}
		
		return trim(str_replace($metaContent, '', $content));
	}

	/**
	 * Get the contents from the file in a lock safe way
	 *
	 * @param string $filename
	 * @return stroing|boolean
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