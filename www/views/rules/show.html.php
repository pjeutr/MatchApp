<div>

  <p>ID: <?php echo $rule->id ?></p>

  <p>Rule Title: <?php echo h($rule->title) ?></p>

  <p>Publication Year: <?php echo h($rule->year) ?></p>

</div>

<hr/>
<?php echo link_to('Back to rules', 'rules') ?>
