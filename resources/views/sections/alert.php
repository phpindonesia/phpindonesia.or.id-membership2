<?php
if ($alert = $this->flashMessages()):
    $type = key($alert);
    $message = $alert[$type];
?>

<div class="alert alert-<?php echo str_replace('form.alert.', '', $type) ?>">
    <p><?php echo is_array($message) ? implode('</p><p>', $message) : $message ?></p>
</div>

<?php endif; ?>
