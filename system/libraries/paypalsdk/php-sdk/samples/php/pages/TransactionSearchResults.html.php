<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <title>PayPal PHP SDK: Transaction Search Results</title>
    <link href="pages/sdk.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <span id=apiheader>Transaction Search Results</span>

   <?php
$ptsr = $response->getPaymentTransactions();
if (!is_array($ptsr)) {
    $ptsr = array($ptsr);
}
$nrecs = sizeof($ptsr);
?>
    
    <p>
    Results 1 - <?php echo $nrecs ?>
    </p>
    <table width=700>
        <tr>
            <th>
            </th>
            <th>
            ID</th>
            <th>
            Time</th>
            <th>
            Status</th>
            <th>
            Payer Name</th>
            <th>
            Gross Amount</th>
        </tr>
        
        <!-- Sample data
        <tr>
            <td>
                1
            </td>
            <td>
                <a id="TransactionDetailsLinkExample" href="TransactionDetails.html">9HP400517M684113S </a>
            </td>
            <td>
                12/7/2005 9:57:58 AM</td>
            <td>
                Completed</td>
            <td>
            </td>
            <td>
                USD 0.01
            </td>
        </tr>
        -->
        
        <?php
        for ($n = 0; $n < $nrecs; $n++) {
           $tran_id = $ptsr[$n]->getTransactionID();
           $tran_ts = $ptsr[$n]->getTimestamp();
           $tran_status = $ptsr[$n]->getStatus();
           $tran_payer_name = $ptsr[$n]->getPayerDisplayName();
           $gross_amt_obj = $ptsr[$n]->getGrossAmount();
           $tran_amount = $gross_amt_obj->_value;
           
        ?>
        <tr>
            <td>&nbsp;</td> 
            <td>
            <a id="TransactionDetailsLink<?php echo $n ?>" href="TransactionDetails.php?transactionID=<?php echo$tran_id?>"><?php echo$tran_id?></a>
            </td>
            <td><?php echo $tran_ts ?></td>
            <td><?php echo $tran_status ?></td>
            <td><?php echo $tran_payer_name ?></td>
            <td><?php echo $tran_amount ?></td>
        </tr>
        
        <?php } ?>
 
    </table>
    <br><br>
    <a id="CallsLink" href="Calls.html">Home</a>
</body>
</html>
