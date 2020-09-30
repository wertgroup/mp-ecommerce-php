<?php
echo '<h1>Pago aprobado</h1>';
echo 'payment_method_id: ' . $_GET['payment_type'] . '<br>';
echo 'external_reference: ' . $_GET['external_reference'] . '<br>';
echo 'payment_id o collection_id: ' . $_GET['collection_id'] . '<br>';
?>