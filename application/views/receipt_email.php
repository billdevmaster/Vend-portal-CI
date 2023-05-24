<!DOCTYPE html>
<head>
<title>Invoice</title>
</head>
<body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
    <table style="max-width:700px;margin:auto;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);">     
     <thead>
      <tr>
       <!-- <th style="text-align:left;"><?php echo $client_name;?></th>-->
        <td colspan="3" style="text-align:center;font-size:15px;font-weight: bold;"><?php echo $client_name;?></td>
      </tr> 
      <tr>   
        <td colspan="3" style="text-align:center;font-size:12px;font-weight:550;"><?php echo $business_registration_number;?></td>
      </tr> 
      <tr>   
        <td colspan="3" style="text-align:center;font-size:10px;"><?php echo $client_address;?></td>
      </tr> 
      <tr>   
        <td colspan="3" style="text-align:center;font-size:10px;">Phone number <?php echo $client_mobile_number;?> | Email <?php echo $client_email;?></td>
      </tr> 
      <tr>   
        <td><br></td>
      </tr> 
      <tr>   
        <td colspan="3" style="text-align:center;font-size:25px;font-weight:900;">eRECEIPT</td>
      </tr> 
      <tr>   
        <td colspan="3" style="text-align:center;font-size:14px;font-weight:550;"><?php echo $transaction_id;?></td>
   
      </tr> 
       <tr>   
         <td colspan="3" style="text-align:center;"><?php echo $date_time;?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height:15px;"></td>
      </tr>
  
      <tr>
        <td style="height:15px;"></td>
      </tr>
     <!-- <tr>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Name</span>  <?php echo $name;?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Email</span> <?php echo $email;?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone</span> <?php echo $mobile_number;?></p>
        </td>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Machine Name</span> <?php echo $machine_name;?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Machine Location</span> <?php echo $machine_address;?></p>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Items</td>
      </tr> -->
      <tr>
        <td style="font-size:14px;padding:30px 15px 0 15px;">Qty</td>
        <td style="font-size:14px;padding:30px 15px 0 15px;">Item</td>
        <td style="font-size:14px;padding:30px 15px 0 15px;">Price</td>
      </tr>
      <tr>
       <td style="margin:0 0 0 0;padding:0 0 0 0;"> <hr> </td>
       <td style="margin:0 0 0 0;padding:0 0 0 0;"> <hr> </td>
       <td style="margin:0 0 0 0;padding:0 0 0 0;"> <hr> </td>
      </tr>
      <tr>
        <td style="font-size:14px;padding:5px 5px 5px 15px;">1</td>
        <td style="font-size:14px;padding:10px 5px 0 5px;"><?php echo $product;?></td>
        <td style="font-size:14px;padding:10px 5px 0 5px;">$<?php echo $price;?></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:right;font-size:14px;padding:30px 15px 0 15px;">GST included</td>
        <td style="font-size:14px;padding:30px 5px 0 5px;"><?php echo number_format((float)$price/11, 2, '.', '');?></td>
      </tr>
      <tr>
       <td style="margin:0 0 0 0;padding:0 0 0 0;"> <hr> </td>
       <td style="margin:0 0 0 0;padding:0 0 0 0;"> <hr> </td>
       <td style="margin:0 0 0 0;padding:0 0 0 0;"> <hr> </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:right;font-size:14px;padding:10px 15px 0 5px;">Total</td>
        <td style="font-size:14px;padding:10px 5px 0 5px;">$<?php echo $price;?>*</td>
      </tr>
      <tr>
        <td style="height:35px;"></td>
      </tr>
       <tr>  
        <td colspan="3" style="text-align:center;font-size:12px;">* Please Note a 25 cents Card Fee applies to all Card Reader Payments</td>
      </tr>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td style="height:35px;"></td>
      </tr> 
      <tr>  
        <td colspan="3" style="text-align:center;font-size:15px; font-weight:550;">Thank you for using our VisualVend Enabled TCN Machine</td>
      </tr>
 <!--      <tr>
        <td style="height:10px;"></td>
      </tr> -->
         <tr>
        <td colspan="3" style="text-align:center;font-size:12px;">VisualVend Powered by Enabled2GO Technologies & TCN Australia</td>
      </tr>
      
  
      <tr>
        <td style="height:25px;"></td>
      </tr>

      <tr>
        <td colspan="3" style="text-align:center;font-size:12px;">eReceipts Powered by VisualVend</td>
      </tr>
      <tr>
        <td colspan="3" style="text-align:center;font-size:12px;">Brought to you by Enabled2GO Technologies & TCN Australia</td>
      </tr>
         <tr>   
        <td colspan="3" style="text-align:center;font-size:14px;">Machine ID :  <?php echo $machine_name;?></td>
    </tbody>

   <!-- <tfoot>
      <tr>
        <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
          <strong style="display:block;margin:0 0 10px 0;">Regards</strong> <?php echo $client_name;?><br /><br />
          <b>Phone:</b> <?php echo $client_mobile_number;?><br>
          <b>Email:</b> <?php echo $client_email;?>
        </td>
      </tr>
    </tfoot> -->
  </table>
</body>

</html>
