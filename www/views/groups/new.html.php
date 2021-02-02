<?php

echo html('groups/_form.html.php', null, array('group' => $group, 'method' => 'POST', 'action' => url_for('groups')));

?>
