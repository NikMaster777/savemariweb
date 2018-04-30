<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class paginate {
    
	//Declare
	public $buttons;
	public $totalRows;
	public $totalPages;
	public $SQLStatement;
	public $currentPage;
	public $recordsLimit;
	
	//Setup Default Vars
	public function __construct($SQL, $override_pages='') {
				
		//Setup Vars
		$this->totalRows = db::nRows($SQL);
		if($override_pages != '') { $this->recordsLimit = $override_pages; } else { $this->recordsLimit = lib::getSetting('General_RecordsLimit'); }
		$this->totalPages = ceil($this->totalRows/$this->recordsLimit);
		$this->SQLStatement = $SQL;
		
		//Current Page
		if(lib::get('pages') && is_numeric(lib::get('pages')) && lib::get('pages') > 0) {
			if(lib::get('pages') > $this->totalPages) {
				$this->currentPage = $this->totalPages;	
			} else {
				$this->currentPage = lib::get('pages');	
			}
		} else {
			$this->currentPage = 1;	
		}
	}
	
	//Return SQL
	public function returnSQL() {
		$this->SQLStatement = $this->SQLStatement.' LIMIT '.ceil(($this->currentPage - 1) * $this->recordsLimit).', '.$this->recordsLimit;
		return $this->SQLStatement;
	}
		
	//Return Results Count
	public function returnCount() {
		return $this->totalRows;	
	}
	
	//Render Pages
	public function renderPages() {
		
		//Do we have enough pages.
		if($this->totalPages > 1) {
		
			//Button
			$this->buttons = '';
			
			$this->buttons .= '<ul class="pagination">';
			
			//Previous Button
			if($this->currentPage > 1 && $this->totalPages > 1) {
				$this->buttons .= '<li><a href="'.preg_replace('/\&pages\=[0-9]+/','', $_SERVER['REQUEST_URI']).'&pages='.($this->currentPage-1).'"><<</a></li>';
			}
			
			//First Page		
			if($this->currentPage > 5) {
				$this->buttons .= '<li><a href="'.preg_replace('/\&pages\=[0-9]+/','', $_SERVER['REQUEST_URI']).'&pages=1">1</a></li>';
				$this->buttons .= '<li><a href="#">...</a></li>';	
			}
			
			//Left Buttons
			if($this->currentPage > 1) {
				for($i=$this->currentPage-3;$i<$this->currentPage;$i++) {
					if($i>0) {
						$this->buttons .= '<li><a href="'.preg_replace('/\&pages\=[0-9]+/','', $_SERVER['REQUEST_URI']).'&pages='.($i).'">'.$i.'</a></li>';
					}
				}
			}
					
			//Current Page
			$this->buttons .= '<li class="active"><a href="#">'.$this->currentPage.'</a></li>';	
			
			//Right Buttons
			if($this->totalPages > 1) {
				for($i=$this->currentPage;$i<$this->currentPage+3;$i++) {
					if($i <= $this->totalPages && $i != $this->currentPage) {
						$this->buttons .= '<li><a href="'.preg_replace('/\&pages\=[0-9]+/','', $_SERVER['REQUEST_URI']).'&pages='.($i).'">'.$i.'</a></li>';
					}
				}
			}
			
			//Last Page		
			if($this->totalPages > 5) {
				$this->buttons .= '<li><a href="#">...</a></li>';
				$this->buttons .= '<li><a href="'.preg_replace('/\&pages\=[0-9]+/','', $_SERVER['REQUEST_URI']).'&pages='.$this->totalPages.'">'.$this->totalPages.'</a></li>';	
			}
			
			//Next Button
			if($this->currentPage < $this->totalPages && $this->totalPages > 1) {
				$this->buttons .= '<li><a href="'.preg_replace('/\&pages\=[0-9]+/','', $_SERVER['REQUEST_URI']).'&pages='.($this->currentPage+1).'">>></a></li>';
			}
			
			$this->buttons .= '</ul>';
						
			//Return Buttons
			return $this->buttons;
			
		}
		
	}	
	
}