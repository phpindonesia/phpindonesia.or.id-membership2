<?php
if ($alert = $this->flashMessages()):
    $type = key($alert);
    $message = array_shift($alert[$type]);
?>

<div class="alert alert-<?php echo $type; ?>">
    <?php echo is_array($message) ? '<p>'.implode('</p><p>', $message).'</p>' : $message ?>
</div>

<?php endif; ?>
