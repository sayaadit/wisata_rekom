<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paging 
{
	/*Default values*/
	private $total_pages = -1;//items
	private $limit = null;
	private $target = ""; 
	private $page = 1;
	private $adjacents = 2;
	private $showCounter = true;
	private $parameterName = "page";
	private $urlF = false;//urlFriendly

	/*****/
	private $calculate = false;
	private $lastpage = 0;	
	private $pagination;
	private $counter;
	
	function __construct() { }
	
	#Total items
	function items($value){$this->total_pages = (int) $value;}
	
	#how many items to show per page
	function limit($value){$this->limit = (int) $value;}
	
	#Page to sent the page value
	function target($value){$this->target = $value;}
	
	#Current page
	function currentPage($value){$this->page = (int) $value;}
	
	#How many adjacent pages should be shown on each side of the current page?
	function adjacents($value){$this->adjacents = (int) $value;}
	
	#show counter?
	function showCounter($value=""){$this->showCounter=($value===true)?true:false;}

	#to change the class name of the pagination div
	function parameterName($value=""){$this->parameterName=$value;}

	#to change urlFriendly
	function urlFriendly($value="%")
	{
		if(preg_match('/^ *$/',$value))
		{
			$this->urlF=false;
			return false;
		}
		$this->urlF=$value;
	}

	//function pagination(){}
	function show()
	{
		if(!$this->calculate)
			if($this->calculate() && $this->lastpage > 1)
				echo $this->html_show();
	}
	
	function getOutput()
	{
		if(!$this->calculate)
			if($this->calculate())
				return $this->html_show();
	}
	
	function get_pagenum_link($id)
	{
		if(strpos($this->target,'?')===false)
			if($this->urlF)
				return str_replace($this->urlF,$id,$this->target);
			else
				return "$this->target?$this->parameterName=$id";
		else
			return "$this->target&$this->parameterName=$id";
	}
	
	function calculate()
	{
		$this->pagination = "";
		$this->calculate == true;
		$error = false;
		if($this->urlF and $this->urlF != '%' and strpos($this->target,$this->urlF)===false)
		{
			echo "Anda tentukan wildcard untuk menggantikan, tetapi tidak ada dalam target<br />";
			$error = true;
		}
		elseif($this->urlF and $this->urlF == '%' and strpos($this->target,$this->urlF)===false)
		{
			echo "Anda perlu menentukan wildcard % pada target untuk mengganti nomor halaman<br />";
			$error = true;
		}

		if($this->total_pages < 0)
		{
			echo "It is necessary to specify the <strong>number of pages</strong> (\$class->items(1000))<br />";
			$error = true;
		}
		
		if($this->limit == null)
		{
			echo "It is necessary to specify the <strong>limit of items</strong> to show per page (\$class->limit(10))<br />";
			$error = true;
		}
		
		if($error) return false;
		
		/* Setup vars for query. */
		if($this->page) 
			$start = ($this->page - 1) * $this->limit;             //first item to display on this page
		else
			$start = 0;                                //if no page var is given, set start to 0
	
		/* Setup page vars for display. */
		$prev = $this->page - 1;                            //previous page is page - 1
		$next = $this->page + 1;                            //next page is page + 1
		$lastpage = ceil($this->total_pages/$this->limit);        //lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;                        //last page minus 1
		
		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$this->lastpage = $lastpage;
		
		if($lastpage > 1)
		{
			if($this->page)
			{
				//anterior button
				if($this->page > 1)
					$this->pagination .= $this->html_prev($prev);
				else
					$this->pagination .= $this->html_prev('');
			}
			
			//pages	
			if ($lastpage < 7 + ($this->adjacents * 2))
			{
				//not enough pages to bother breaking it up
				for ($counter = 1; $counter <= $lastpage; $counter++){
					if ($counter == $this->page)
						$this->pagination .= $this->html_current_page($counter);
					else
						$this->pagination .= $this->html_page($counter);
				}
			}
			elseif($lastpage > 5 + ($this->adjacents * 2))
			{
				//enough pages to hide some
				//close to beginning; only hide later pages
				if($this->page < 1 + ($this->adjacents * 2))
				{
					for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++)
					{
						if ($counter == $this->page)
							$this->pagination .= $this->html_current_page($counter);
						else
							$this->pagination .= $this->html_page($counter);
					}
					
					//$this->pagination .= "...";
					
					$this->pagination .= $this->html_page($lpm1);
					$this->pagination .= $this->html_page($lastpage);
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2))
				{
					$this->pagination .= $this->html_page(1);
					$this->pagination .= $this->html_page(2);
					
					//$this->pagination .= "...";
					
					for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++)
						if ($counter == $this->page)
								$this->pagination .= $this->html_current_page($counter);
							else
								$this->pagination .= $this->html_page($counter);
					//$this->pagination .= "...";
					$this->pagination .= $this->html_page($lpm1);
					$this->pagination .= $this->html_page($lastpage);
				}
				//close to end; only hide early pages
				else
				{
					$this->pagination .= $this->html_page(1);
					$this->pagination .= $this->html_page(2);
					
					//$this->pagination .= "...";
					
					for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++)
						if ($counter == $this->page)
							$this->pagination .= $this->html_current_page($counter);
						else
							$this->pagination .= $this->html_page($counter);
				}
			}
				
			if($this->page)
			{
				//siguiente button
				if ($this->page < $counter - 1)
					$this->pagination .= $this->html_next($next);
				else
					$this->pagination .= $this->html_next('');
							
			}
		}

		return true;
	}
	
	/* 
	 * HTML
	 * Costum HTML here; 
	 */
	function html_page($counter)
	{
		$html = '<a class="page" href="'.$this->get_pagenum_link($counter).'">'.$counter.'</a>';
		
		return $html;
	}
	
	function html_current_page($counter)
	{
		$html = '<a class="current">'.$counter.'</a>';
		
		return $html;
	}
	
	function html_next($counter)
	{
		$n = '<i class="td-icon-menu-right"></i>';
		
		if(!empty($counter))
			$html = '<a href="'.$this->get_pagenum_link($counter).'" class="first">'.$n.'</a>';
		else
			$html = '<a href="javascript:void(0)" class="first">'.$n.'</a>';
		
		return $html;
	}
	
	function html_prev($counter)
	{
		$p = '<i class="td-icon-menu-left"></i>';
		
		if(!empty($counter))
			$html = '<a href="'.$this->get_pagenum_link($counter).'" class="last">'.$p.'</a>';
		else
			$html = '<a href="javascript:void(0)" class="last">'.$p.'</a>';
		
		return $html;
	}
	
	function html_counter()
	{
		$html = '<span class="pages">page '.$this->page.' of '.$this->lastpage.'</span>';
		
		return $html;
	}
	
	function html_show()
	{
		if($this->showCounter)
			$this->counter = $this->html_counter();
		else
			$this->counter = '';
			
		$html = '<div class="page-nav td-pb-padding-side">'.$this->pagination.'<div class=clearfix></div></div>';
		
		return $html;
	}
}
?>