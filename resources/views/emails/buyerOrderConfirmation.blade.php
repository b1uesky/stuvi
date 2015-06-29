<!-- This is the html that will be sent out for order confirmation emails
   For more info visit: http://webdesign.tutsplus.com/series/mastering-html-email--webdesign-17696
     Please read up on that before beginning to edit/product any email pages...very important..

   Send an email with order/test -->

<!-- new redo -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset=UTF-8" />
        <title>Stuvi Order Confirmation #{{ $buyer_order['id'] }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body style="margin: 0; padding: 0;">
        <!-- container table. Style things in here. not body -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style=" padding: 20px 0px 30px 0px;">
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                        <tr>
                            <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                    <!-- row 1 header-->
                                    <tr>
                                        <!-- header image/logo -->
                                        <td align="center" bgcolor="#241729" style="padding: 40px 0 30px 0;">
                                            <!-- must be replaced with a real url once website is online -->
                                            <img src="http://puu.sh/iDvTG/18b055e116.png" alt="Stuvi Logo" width="276" height="110" style="display: block;" />
                                        </td>
                                    </tr>
                                    <!-- row 2 content-->
                                    <tr>
                                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <!-- content row 1 -->
                                                <tr>
                                                    <!-- header/tag line.. -->
                                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 36px;">
                                                        <b>Your Stuvi Order Confirmation</b>
                                                    </td>
                                                </tr>
                                                <!-- content row 2 -->
                                                <tr>
                                                    <!-- main content -->
                                                    <td style="padding: 20px 0 30px 0;">
                                                        <!-- details -->
                                                        <table border="0" cellpadding="0px" cellspacing="0" width="100%">

                                                            <!-- thank you. Row 2 row 1 -->
                                                            <tr>
                                                                <td style="color: #F16521; font-family: Arial, sans-serif; font-size: 17px;" width="100%">
                                                                    Thank you, {{$buyer_order['buyer']['first_name']}} for your order. We will send you a confirmation
                                                                    when your order is on its way!</span><br><br>
                                                                    <hr style="border-bottom: 1px solid rgba(0, 0, 0, 0.30);">
                                                                </td>
                                                            </tr>

                                                            <!-- details 1 row 2 row 2-->
                                                            <tr style="color: #153643; font-family: Arial, sans-serif; font-size: 17px;">
                                                                <td width="100%">
                                                                    Ordered on {{ $buyer_order['created_at'] }}<br>
                                                                    Order #{{ $buyer_order['id'] }} <br>
                                                                </td>
                                                            </tr>

                                                            <!-- shipping/address details. row 2 row 2-->
                                                            <tr>
                                                                <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
                                                                    <tr>
                                                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px;" width="40%" align="left">
                                                                            <?php $shipping_address = $buyer_order['shipping_address'] ?>
                                                                            <b>Shipping Address</b><br>
                                                                            {{ $shipping_address['addressee']}}<br>
                                                                            {{ $shipping_address['address_line1']}}&nbsp;{{ $shipping_address['address_line2']}}<br>
                                                                            {{ $shipping_address['city'] }}, {{ $shipping_address['state_a2'] }}&nbsp;{{ $shipping_address['zip'] }}<br>

                                                                        </td>

                                                                        <!-- spacing. row 2 column 2 -->
                                                                        <td style="font-size: 0; line-height: 0;" width="10%">
                                                                            &nbsp;
                                                                        </td>

                                                                        <!-- payment details row 2 column 3-->
                                                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px;" width="40%" align="left">
                                                                            <b>Payment Method</b><br>
                                                                            {{ $buyer_order['buyer_payment']['card_brand'] }}&nbsp;**** {{ $buyer_order['buyer_payment']['card_last4'] }}<br>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </tr>
                                                            <hr style="border-bottom: 1px solid rgba(0, 0, 0, 0.30);">

                                                            <!-- items -->
                                                            <tr>
                                                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px;" width="100%">
                                                                <b>Items</b><br>
                                                                @foreach ($buyer_order['products'] as $product)
                                                                    Title: {{ $product['book']['title'] }}<br>
                                                                    ISBN: {{ $product['book']['isbn13'] }}<br>
                                                                    Author(s):
                                                                    @foreach($product['book']['authors'] as $author)
                                                                        <span>{{ $author['full_name'] }}</span>
                                                                    @endforeach
                                                                    <br>
                                                                    <b>${{ $product['price'] }}</b><br>
                                                                    <hr style="border-bottom: 1px solid rgba(0, 0, 0, 0.30);">
                                                                @endforeach
                                                                <td>
                                                            </tr>

                                                        </table>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- row 3 footer -->
                                    <tr>
                                        <td bgcolor="#292C2F" style="padding: 30px 30px 30px 30px;">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <!-- row 3 row 1 -->
                                                <tr>
                                                    <!-- row 3 row 1 column 1 -->
                                                    <td width="75%" style= "color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" >
                                                        &copy; Stuvi LLC., Boston 2015<br/>
                                                        <!-- <a href="#" style="color: #ffffff;"><font color="#ffffff">Unsubscribe</font></a> to this newsletter instantly -->
                                                    </td>
                                                    <!-- row 3 row 1 column 2 -->
                                                    <td align="right" width="25%">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td>
                                                                    <a href="https://twitter.com/StuviBoston">
                                                                        <img src="http://puu.sh/iDIwb/6b9c1ad919.png" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                                    </a>
                                                                </td>
                                                                <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                                <td>
                                                                    <a href="https://www.facebook.com/StuviBoston">
                                                                        <img src="http://puu.sh/iDIsb/d334eb38f2.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>


