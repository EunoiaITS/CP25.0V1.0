<HTML>
<BODY>
<?php
$data = unserialize($_GET['data']);
//echo"<pre>";print_r($data);die;
//
$hash_string = "qRY1L1Kjf6M16029".$data->trans_id.($data->package*100)."MYR";
$hash =  hash('sha256', $hash_string);
//print_r($hash_string);echo"<br>";
//print_r($hash);die;

$response = Request::$BASE_PATH . "index.php/ipayRes?url=";
//print_r($response);die;

?>

<FORM method="post" name="ePayment" action="https://payment.ipay88.com.my/ePayment/entry.asp" >
    <INPUT type="hidden" name="MerchantCode" value="M16029">
    <INPUT type="hidden" name="MerchantKey" value="qRY1L1Kjf6">
    <INPUT type="hidden" name="PaymentId" value="14">
    <INPUT type="hidden" name="RefNo" value="<?php echo $data->trans_id; ?>">
    <INPUT type="hidden" name="Amount" value="<?php echo number_format($data->package,2); ?>">
    <INPUT type="hidden" name="Currency" value="MYR">
    <INPUT type="hidden" name="ProdDesc" value="Signup Package">
    <INPUT type="hidden" name="UserName" value="<?php echo $data->username; ?>">
    <INPUT type="hidden" name="UserEmail" value="<?php echo $data->email; ?>">
    <INPUT type="hidden" name="UserContact" value="<?php echo $data->phone_no; ?>">
    <INPUT type="hidden" name="SignatureType" value="SHA256">
    <INPUT type="hidden" name="Signature" value="<?php echo $hash; ?>">
    <INPUT type="hidden" name="ResponseURL" value="<?php echo $response."1" ?>" >
    <INPUT type="hidden" name="BackendURL" value="<?php echo $response."2" ?>">
    <INPUT type="submit" value="Proceed with Payment" name="Submit"> </FORM>

<script type="text/javascript">
window.onload = function(){
document.forms['ePayment'].submit();
}
</script>
</BODY>
</HTML>