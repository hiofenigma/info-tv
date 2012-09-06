<?php
	header('Content-type: text/html; charset=utf-8');

	$page = __FILE__;
	include("lib/log.php");
	include("lib/mysql.php");
	mysql_select_db("vbulletin");

	if(!is_numeric($_GET['aid'])){
		
		if(is_numeric($_GET['c'])){

			$q = "
			SELECT pagetext, cms_nodeinfo.associatedthreadid, creationdate, title
			FROM cms_nodeinfo 
			LEFT JOIN (cms_node, cms_article) 
			ON (cms_node.nodeid = cms_nodeinfo.nodeid 
				AND cms_nodeinfo.associatedthreadid = cms_article.threadid)
			WHERE setpublish = 1 
			ORDER BY creationdate DESC LIMIT 5";
		}
		else die("error#1");
		
	}
	else{
		$aid = $_GET['aid'];
		$q = "SELECT pagetext FROM cms_article WHERE contentid=".$aid." LIMIT 1;";
	}
	$mq = mysql_query($q,$sql);
	//$dager = array("Mandag","Tirsdag","Onsdag","Torsdag","Fredag",&oslash;rdag","S&oslash;ndag");

	echo "<table class='news'><tr><th>Artikkel(". ($_GET['c']%5).")</th></tr>";
	while($x = mysql_fetch_array($mq, MYSQL_ASSOC)){
		//$txt = $parser->parse($x['pagetext']);
		
		echo "<tr><td>".$x['title']." - ". date("d.m.Y H:i",$x['creationdate'])."</td></tr>";
		echo "<tr class='".($i++ %2?"odd":"even")."'><td>".$txt."</td></tr>";
//		"<span class='last_headline'>". utf8_encode($x['title'])."</span><br />".
//		"<span class='det'>".date("d.m.Y H:i",$x['creationdate'])."</span></td></tr>";
	}
	echo "</table>";

//	echo "<table class='news'><tr><th>Den store bildetr&aring;den v2.0 @ Enigma-forumet</th></tr><tr class='even'><td><center>";
//	showImgThread();
//	echo "</center></td></tr></table>";

//CRM: customer relation management
//SCM: Supply chain management
//ERP: Enterprise resource planning (SAP)
//MES: Manufacturing execution system

function showImgThread(){
	global $sql;

	mysql_select_db("vbulletin");
	$lim = 1;
	$q = "SELECT pagetext FROM post WHERE threadid = 51 AND ".
		"(LOWER(pagetext) REGEXP '\\\[attach' OR LOWER(pagetext) REGEXP '\\\[img') ORDER BY dateline DESC LIMIT {$lim};";
	$mq = mysql_query($q,$sql);

	while(list($text) = mysql_fetch_array($mq)){
		echo fixBBCode($text);
	}

}

function fixBBCode($str){

	$ptrn = "/img|attach\=config\]([^\[\]]*)\[\/(img|attach)/i";
	preg_match($ptrn, $str, $out, PREG_OFFSET_CAPTURE);
	if(preg_match("/ATTACH/i", $out[2][0])){
		return "<img src='http://enigma.hiof.no/attachment.php?attachmentid=". $out[1][0]. "' />";
	}
	else return "<img src='". $out[1][0]. "' />";
}

?>
