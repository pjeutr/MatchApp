<?php

set('id', 3);
set('title', 'New Rule');

echo html('rules/_form.html.php', null, array('rule' => $rule, 'method' => 'POST', 'action' => url_for('rules')));

?>
