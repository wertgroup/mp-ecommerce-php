<?php
require_once dirname(__FILE__) . '/libraries/mercadopago/vendor/autoload.php';

MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398');

if(!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"]))
{
    http_response_code(200);
    return;
}




switch($_GET["topic"])
{
    case "payment":
        $payment = MercadoPago\Payment::find_by_id($_GET["id"]);
        $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);
        break;
    case "merchant_order":
        $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
        break;
}

$paid_amount = 0;
$operaciones = '';

foreach($merchant_order->payments as $payment)
{
    if($payment->status == 'approved')
    {
        $paid_amount += $payment->transaction_amount;
        $operaciones .= $payment->id . ',';
    }
}

$operaciones = substr($operaciones, 0, -1);


if($paid_amount > 0 && $paid_amount >= $merchant_order->total_amount)
{
    /*if(count($merchant_order->shipments)>0)
    {
        if($merchant_order->shipments[0]->status == "ready_to_ship")
        {
            //Totally paid. Print the label and release your item
            $estado = 'Aprobado';
        }
    }
    else
    {*/
        $estado = 'Aprobado';
    //}
}
else
{
    $estado = 'Pendiente';
}





// Guardo los datos del pago
$resultado  = print_r($merchant_order, true);
$fp         = fopen('resultado.txt', 'w');

fwrite($fp, $resultado);
fclose($fp);

echo '<pre>' . print_r($merchant_order, true) . '</pre>';
?>