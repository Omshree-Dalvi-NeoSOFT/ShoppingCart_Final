
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
      <h3> Order Placed Today !</h3>
      <br>
      Following are the Order Details :
    </p>
   </div>
        
   <table class="table text-left" id="example1" style="text-align: left;">  
        <thead>
            <tr>
                <th scope="col">Order Specification</th>
                <th scope="col">Order Count</th>
            </tr>
        </thead> 
        <tbody>  
            <tr>
                <th>Total</th>
                <td>{{$dailyorders}}</td>
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