<?php

set('id', 3);
set('title', 'Edit Rule');

echo html('rules/_form.html.php', null, array('rule' => $rule, 'method' => 'PUT', 'action' => url_for('rules', $rule->id)));

?>
