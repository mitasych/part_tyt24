<?php

class AK_Common_Paging
{
    private $_db;

    /**
     * page length
     * @var integer
     */
    public $postPerPage;

    /**
     * all data length
     * @var integer
     */
    public $totPosts;

    /**
     * count of pages
     * @var integer
     */
    public $totPages;

    /**
     * Uri without paging params.
     * @var string
     */
    public $link;

    /**
     * page length
     * @var integer
     */
    public $pageLength;

    public function __construct($totPosts, $postPerPage, $link)
    {
        $_db = Zend_Registry :: get("DB");

        $this->totPosts    = $totPosts;
		$postPerPage = 20;
        $this->postPerPage = $postPerPage;
        $this->totPages    = ceil($this->totPosts/$this->postPerPage);
        $this->pageLength  = 5;
        $this->link        = $link;
    }

    public function makePaging($currPage)
    {
    	$i=0;

		if ( $this->pageLength > $this->totPages ) {
		    $this->pageLength = $this->totPages;
		}

        $str = '';
        $indent = intval($this->pageLength/2);
        $indent_r = $this->pageLength - $indent;

    	if ($currPage + $indent_r >= $this->totPages) {
    	    $start = $currPage - ($this->pageLength - ($this->totPages - $currPage) + 1);
	 	} else {
	 	    $start = $currPage - $indent;
	 	}

		if ($start <= 1 ) {
		    $start=2;
		}

		if ($start > 2) {
		    $str.= " <a href='".$this->link."/page/1/' onClick='ajax_paging(1); return false;'>1</a> .. ";
		}else {
    		if ($currPage==1) {
    		 $str.="1 ";
    		} else {
    		 $str.= " <a href='".$this->link."/page/1/' onClick='ajax_paging(1); return false;'>1</a> ";
    		}
		}
		if ($this->totPages > 2) {
            if ($currPage-$indent > 0) {
            	$finish = $start+$this->pageLength;
            	if ($finish >= $this->totPages) {
            	    $finish=$this->totPages-1;
            	}
            	for ($i=$start; $i<= $finish; $i++) {
                    if ($currPage == $i) {
                        $str .= "" . $i . " ";
                    }else {
                        $str .= "<a href='" . $this->link . "/page/" . $i . "/' onClick='ajax_paging(".$i."); return false;'>" . $i . "</a> ";
                    }
                }
            }else {

            	$finish = $start+$this->pageLength;
            	if ($finish >= $this->totPages) {
            	    $finish=$this->totPages-1;
            	}
            	for ($i=2; $i<=$finish; $i++) {
                    if ($currPage == $i) {
                        $str .= "" . $i . " ";
                    } else {
                        $str .= "<a href='" . $this->link . "/page/" . $i ."/' onClick='ajax_paging(".$i."); return false;'>" . $i . "</a> ";
                    }
                }
            }
		}

		if ($i < $this->totPages  && $i>0) {
		    $str.= " .. <a href='".$this->link."/page/".$this->totPages."/' onClick='ajax_paging(".$this->totPages."); return false;'>".$this->totPages."</a>";
		}else {
    		if ($currPage==$this->totPages) {
    		    $str.="".$this->totPages."";
    		}else {
    		    $str.= " <a href='".$this->link."/page/".$this->totPages."/' onClick='ajax_paging(".$this->totPages.");return false;'>".$this->totPages."</a>";
    		}
		}
       // $str .= "<span class='cc s10'>&nbsp;&nbsp;&nbsp;всего страниц : ".$this->totPages."</span>";
        if ($this->totPages<2) {
            return false;
        } else {
            return $str;
        }
    }

    public function makePagingAJAX($currPage,$function,$form)
    {
    	$i=0;

		if ( $this->pageLength > $this->totPages ) {
		    $this->pageLength = $this->totPages;
		}

        $str = '';
        $indent = intval($this->pageLength/2);
        $indent_r = $this->pageLength - $indent;

    	if ($currPage + $indent_r >= $this->totPages) {
    	    $start = $currPage - ($this->pageLength - ($this->totPages - $currPage) + 1);
	 	} else {
	 	    $start = $currPage - $indent;
	 	}

		if ($start <= 1 ) {
		    $start=2;
		}

		if ($start > 2) {
		    $str.= " <a onClick = '" .$function. "(\"" . $form . "\",1);' href='#'>1</a> .. ";
		}else {
    		if ($currPage==1) {
    		 $str.="1 ";
    		} else {
    		 $str.= " <a onClick = '" .$function. "(\"" . $form . "\",1);' href='#'>1</a> ";
    		}
		}
		if ($this->totPages > 2) {
            if ($currPage-$indent > 0) {
            	$finish = $start+$this->pageLength;
            	if ($finish >= $this->totPages) {
            	    $finish=$this->totPages-1;
            	}
            	for ($i=$start; $i<= $finish; $i++) {
                    if ($currPage == $i) {
                        $str .= "" . $i . " ";
                    }else {
                        $str .= "<a onClick = '" .$function. "(\"" . $form . "\"," . $i . ");' href='#'>" . $i . "</a> ";
                    }
                }
            }else {

            	$finish = $start+$this->pageLength;
            	if ($finish >= $this->totPages) {
            	    $finish=$this->totPages-1;
            	}
            	for ($i=2; $i<=$finish; $i++) {
                    if ($currPage == $i) {
                        $str .= "" . $i . " ";
                    } else {
                        $str .= "<a onClick = '" .$function. "(\"" . $form . "\"," . $i .");' href='#'>" . $i . "</a> ";
                    }
                }
            }
		}

		if ($i < $this->totPages  && $i>0) {
		    $str.= " .. <a onClick = '" .$function. "(\"" . $form . "\",".$this->totPages.");' href='#'>".$this->totPages."</a>";
		}else {
    		if ($currPage==$this->totPages) {
    		    $str.="".$this->totPages."";
    		}else {
    		    $str.= " <a onClick = '" .$function. "(\"" . $form . "\",".$this->totPages.");' href='#'>".$this->totPages."</a>";
    		}
		}
        //$str .= "<span class='cc s10'>&nbsp;&nbsp;&nbsp;�����: ".$this->totPages."</span>";
        if ($this->totPages<2) {
            return false;
        } else {
            return $str;
        }
    }

}
