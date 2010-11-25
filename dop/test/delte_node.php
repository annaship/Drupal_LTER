<?php
$q = db_query("select type from pie_node where type != 'research_site' AND type != 'panel' AND type != 'page' AND type != 'biblio' AND type != 'story'  group by type;");
while ($nid = db_result($q)) {
 node_delete($nid);
}
?>
