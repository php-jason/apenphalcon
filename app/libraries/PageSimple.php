<?php 
class PageSimple {
    
 function getPaginationString($page = 1, $totalitems, $limit = 15, $targetpage = "/", $pagestring = "/")
 {
    //defaults
    if(!$limit) $limit = 15;
    if(!$page) $page = 1;
    if(!$targetpage) $targetpage = "/";
  
    //other vars
    $lastpage = ceil($totalitems / $limit);       //lastpage is = total items / items per page, rounded up.


    $prev = $page > 1 ? $page - 1 : 0;                  //previous page is page - 1
    $next = $page < $lastpage ? $page +1 : 0;                  //next page is page + 1
     
    $pagination = "<div class=\"page\" >"; 
    $pagination .= "<ul>"; 
    $pagination .= "<li class=\"pageLeft\"><a href=\"".$pagestring."1\">";
    $pagination .= "<span class=\"back\"></span>回首頁</a></li>"; 
    $pagination .= "<li><a href=\"".$pagestring.$prev."\"  class=\"left\"></a>";
    $pagination .= $page."/".$lastpage;
    $pagination .= "<a href=\"".$pagestring.$next."\" class=\"right\"></a></li>";
    $pagination .= "<li class=\"pageRight\"><a href=\"".$pagestring.$lastpage."\">";
    $pagination .= "去末頁<span class=\"next\"></span></a></li>"; 
    $pagination .= "</ul>"; 
    $pagination .= "</div>"; 
    return $pagination;
  }
}
