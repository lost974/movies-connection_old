<?php

$message = $this->session->get('jgrowl');
$this->session->set('jgrowl', '');

if ($message):
?>

<script>

$.jGrowl("<?php echo $message; ?>", { sticky: true });

</script>

<?php endif; ?>