<?php

include("lib/mysql.php");
mysql_select_db("vbulletin");

$q = "SELECT title,creationdate 
			FROM cms_nodeinfo 
			LEFT JOIN (cms_node, cms_article) 
			ON (cms_node.nodeid = cms_nodeinfo.nodeid 
				AND cms_nodeinfo.associatedthreadid = cms_article.threadid)
			WHERE setpublish = 1 
			ORDER BY creationdate DESC LIMIT 15";
			
$q = "SELECT * 
		FROM cms_nodeinfo 
		LEFT JOIN cms_node ON cms_node.nodeid = cms_nodeinfo.nodeid 
		WHERE setpublish = 1 
		ORDER BY creationdate DESC LIMIT 15;";
			
$mq = mysql_query($q,$sql);

echo "<table border='1'>";

while($x = mysql_fetch_array($mq,MYSQL_ASSOC)){
	if($i++<1)echo "<tr><th>".implode("</th><th>",array_keys($x))."</th></tr>";
	echo "<tr><td>".implode("</td><td>",$x)."</td></tr>";
	
}

echo "</table>";


?>