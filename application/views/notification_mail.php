<!DOCTYPE html>
<head>
<title>Approval Request</title>
</head>
<body style="font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
    <table style="width:700px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);">    
      <thead>
      <tr>   
        <td colspan="3" style="text-align:left;font-size:20px;font-weight:500;"><?php echo $title;?></td>
      </tr> 
      <tr>
        <td style="height:25px;"></td>
      </tr>
      <tr>   
        <td colspan="3" style="text-align:left;font-size:15px;"><?php echo $body;?></td>
      </tr> 
      <tr>
        <td style="height:25px;"></td>
      </tr>
      <tr>
        <td colspan="3" style="text-align:left;font-size:12px;">Client Details</td>
      </tr>
      <tr>
        <td colspan="3" style="text-align:left;font-size:15px;font-weight: bold;"><?php echo $client_name;?></td>
      </tr> 
      <tr>   
        <td colspan="3" style="text-align:left;font-size:10px;">Business Registration Number : <?php echo $business_registration_number;?></td>
      </tr> 
      <tr>   
        <td colspan="3" style="text-align:left;font-size:10px;">Address : <?php echo $client_address;?></td>
      </tr> 
      <tr>   
        <td colspan="3" style="text-align:left;font-size:10px;">Phone number : <?php echo $client_mobile_number;?></td>
      </tr> 
      <tr>   
        <td colspan="3" style="text-align:left;font-size:10px;">Email : <?php echo $client_email;?></td>
      </tr> 
      <tr>   
        <td><br></td>
      </tr> 
    </thead>
  </table>
</body>

</html>
