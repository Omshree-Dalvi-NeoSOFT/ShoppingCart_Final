
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body class="container">
   <div class="container">
   <h3> Order Mail</h3>
    <p>
    The great thing about the Internet isn't that you can reconnect with old friends or stay up to date with developing world events or send pictures of newborns immediately around the world. It is simply that you can log on to Shoppingcart.com from anywhere and order fresh underwear immediately after seeing your life flash before your eyes.
    </p>
    <p>
      <h3> {{$fname}}, Thank You !!</h3>
      <br>
      Following are the Order Details :
    </p>
   </div>
        
   <table class="table text-left" id="example1" style="text-align: left;">  
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Order Specification</th>
                <th scope="col">Order Details</th>
            </tr>
        </thead> 
        <tbody>  
            <tr>
                <th>1</th>
                <th>Customer Name</th>
                <td>{{$fname}} {{$lname}}</td>
            </tr> 
            <tr>
                <th>2</th>
                <th>Customer Email</th>
                <td>{{$email}}</td>
            </tr> 
            <tr>
                <th>3</th>
                <th>Customer Address</th>
                <td>{{$address1}}</td>
            </tr> 
            <tr>
                <th>4</th>
                <th>Customer Zip Code</th>
                <th>{{$zip}}</th>
            </tr>
            <tr>
                <th>5</th>
                <th>Customer Phone</th>
                <td>{{$phone}}</td>
            </tr>
            <tr>
                <th>6</th>
                <th>Order Total</th>
                <td class="text text-danger">$ {{$grandtotal}}</td>
            </tr>
            <tr>
                <th>7</th>
                <th>Billing Amount (* including coupons)</th>
                <td class="text text-success">$ {{$finalTotal}}</td>
            </tr>
            <tr>
                <th>8</th>
                <th>Order Status</th>
                <td class="text text-success">Pending</td>
            </tr>
        </tbody>                
    </table>

    <div class="container">
  <p>
    <h2>Thanks & Regards,</h2><br>
    <h5>Shopping Cart Team.</h5>
  </p>
</div>

</body>
</html>