<?php 

namespace App\MyClass;


class Pagination
{
	private int $limitPerPage = 10;
	private int $amountOfItems = 0;
	private int $activePage = 1;
	private int $limitNumberButtonShowed = 3;
	private $link = 'javascript:void(0);';

	private $openTag = null;
	private $closeTag = null;
	private $openTagOnActive = null;
	
	private $prevButtonText = "&laquo;";
	private $nextButtonText = "&raquo;";

	private bool $isUsingFirstLastButton = false;
	private $firstButtonText = 'First';
	private $lastButtonText = 'Last';

	private bool $isUsingDots = false;


	public function __construct(array $config = [])
	{
		if(array_key_exists('limit_per_page', $config)) $this->limitPerPage = $config['limit_per_page'];
		if(array_key_exists('amount_of_items', $config)) $this->amountOfItems = $config['amount_of_items'];
		if(array_key_exists('active_page', $config)) $this->activePage = $config['active_page'];
		if(array_key_exists('link', $config)) $this->link = $config['link'];

		if(array_key_exists('open_tag', $config)) $this->openTag = $config['open_tag'];
		if(array_key_exists('close_tag', $config)) $this->closeTag = $config['close_tag'];
		if(array_key_exists('open_tag_on_active', $config)) $this->openTagOnActive = $config['open_tag_on_active'];

		if(array_key_exists('prev_button_text', $config)) $this->prevButtonText = $config['prev_button_text'];
		if(array_key_exists('next_button_text', $config)) $this->nextButtonText = $config['next_button_text'];

		if(array_key_exists('is_using_first_last_button', $config)) $this->isUsingFirstLastButton = $config['is_using_first_last_button'];
		if(array_key_exists('first_button_text', $config)) $this->firstButtonText = $config['first_button_text'];
		if(array_key_exists('last_button_text', $config)) $this->lastButtonText = $config['last_button_text'];

		$this->setEmptyProperty();
	}


	public static function make($config)
	{
		return new self($config);
	}


	public static function makeAndGenerate($config)
	{
		$pagination = self::make($config);
		return $pagination->generate();
	}


	private function setEmptyProperty()
	{
		if(empty($this->openTag)) $this->openTag = "<div>";
		if(empty($this->closeTag)) $this->closeTag = "</div>";
		if(empty($this->openTagOnActive)) $this->openTagOnActive = $this->openTag;
		if(empty($this->openTagOnHover)) $this->openTagOnHover = $this->openTag;
	}


	public function amountOfPages() : int
	{
		return ceil($this->amountOfItems / $this->limitPerPage);
	}


	public function generatePrevButton()
	{
		$result = $this->openTag . $this->prevButtonText . $this->closeTag;
		
		if($this->activePage <= 1) {
			return str_replace('{link}', 'javascript:void(0);', $result);
		} else {
			$link = str_replace('{number}', $this->activePage - 1, $this->link);
			return str_replace('{link}', $link, $result);
		}
	}


	public function generateNextButton()
	{
		$result = $this->openTag . $this->nextButtonText . $this->closeTag;
		
		if($this->activePage == $this->amountOfPages()) {
			return str_replace('{link}', 'javascript:void(0);', $result);
		} else {
			$link = str_replace('{number}', $this->activePage + 1, $this->link);
			return str_replace('{link}', $link, $result);
		}
	}


	public function generateFirstButton()
	{
		if($this->isUsingFirstLastButton) {
			$result = $this->openTag . $this->firstButtonText . $this->closeTag;
			
			if($this->activePage > 1) {
				$link = str_replace('{number}', 1, $this->link);
				return str_replace('{link}', $link, $result);
			}
		}

		return '';
	}


	public function generateLastButton()
	{
		if($this->isUsingFirstLastButton) {
			$result = $this->openTag . $this->lastButtonText . $this->closeTag;
			
			if($this->activePage < $this->amountOfPages()) {
				$link = str_replace('{number}', $this->amountOfPages(), $this->link);
				return str_replace('{link}', $link, $result);
			}
		}

		return '';
	}


	public function generateDotsButton()
	{
		$link = 'javascript:void(0);';
		return str_replace('{link}', 'javascript:void(0);', $this->openTag) . '..' . $this->closeTag;
	}


	public function generatePageNumberButton()
	{
		$result = '';

		if($this->amountOfPages() > 0)
		{
			$numberAvailable = $this->limitNumberButtonShowed - 1;
			$longOfStart = ceil($numberAvailable / 2);
			$longOfEnd = $numberAvailable - $longOfStart;

			$numberStart = $this->activePage - $longOfStart; 
			$numberEnd = $this->activePage + $longOfEnd; 

			if($numberStart <= 0) 
			{
				$diff = 1 - $numberStart;
				$numberStart = 1;
				$numberEnd += $diff;
			}

			if($numberEnd > $this->amountOfPages()) 
			{
				$diff = $numberEnd - $this->amountOfPages();
				$numberEnd = $this->amountOfPages();
				if($numberStart != 1)
				{
					if(($numberStart - $diff) >= 1) {
						$numberStart -= $diff;
					}
				}
			}

			$number = $numberStart;

			if($this->isUsingDots && $number > 1) {
				$result .= $this->generateDotsButton();
			}

			for($number = $number; $number <= $numberEnd; $number++)
			{
				if($number == $this->activePage) {
					$html = $this->openTagOnActive . $number . $this->closeTag;
					$link = 'javascript:void(0);';
				} else {
					$html = $this->openTag . $number . $this->closeTag;
					$link = str_replace('{number}', $number, $this->link);
				}
				
				$html = str_replace('{link}', $link, $html);
				$result .= $html;
			}

			if($this->isUsingDots && $numberEnd < $this->amountOfPages()) {
				$result .= $this->generateDotsButton();
			}
		}

		return $result;
	}


	public function generate()
	{
		$result = $this->generatePrevButton();
		$result .= $this->generateFirstButton();
		$result .= $this->generatePageNumberButton();
		$result .= $this->generateLastButton();
		$result .= $this->generateNextButton();

		return $result;
	}
}