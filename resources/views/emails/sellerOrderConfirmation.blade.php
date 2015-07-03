
{{--{{ var_dump($seller_order) }}--}}

<!-- This is the html that will be sent out for seller order confirmation emails
   For more info visit: http://webdesign.tutsplus.com/series/mastering-html-email--webdesign-17696
     Please read up on that before beginning to edit/product any email pages...very important..
    See: BuyerOrderController.php
   Send an email with order/test -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset=UTF-8" />
    <!-- TODO: variable to order id # -->
    <title>Stuvi Seller Order Confirmation #{{$seller_order['id']}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


</head>


<body style="margin: 0; padding: 0;">
<!-- container table. Style things in here. not body -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style=" padding: 20px 0px 30px 0px;">
    <tr> <!-- top level row -->
        <td> <!-- top level data -->
            <!-- content table. 600px for best format -->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                <tr> <!-- row 1/1 for 600px table -->
                    <td> <!-- data 1/1 for only row of 600px table -->
                        <!-- third another table container -->
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                            <!-- row 1 header-->
                            <tr>
                                <!-- header image/logo -->
                                <td align="center" bgcolor="#241729" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Trebuchet MS, Helvetica, sans-serif;">
                                    <!--TODO: puush must be replaced with a real url once website is online -->
                                    <a href="{{url('/home')}}">
                                        <img src="http://puu.sh/iDvTG/18b055e116.png" alt="Stuvi" width="276" height="110" style="display: block; color: #ffffff" />
                                    </a>
                                </td> <!-- end header img -->
                            </tr>
                            <!-- row 2. content-->
                            <tr>
                                <!-- container for content -->
                                <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                    <!-- content table -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <!-- content row 1 -->
                                        <tr>
                                            <!-- header/tag line.. -->
                                            <td style="color: #153643; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 30px;">
                                                <b>Congratulations, your book sold!</b>
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
                                                        <td style="color: #F16521; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 17px;" width="100%">
                                                            {{$seller_order['seller']['first_name']}}, your book has sold! Please schedule a pick-up time that's right for you.
                                                            <br>
                                                            <br>
                                                            <hr style="border-bottom: .5px solid #737373;">
                                                        </td>
                                                    </tr>

                                                    <!-- details 1 row 2 row 2-->
                                                    <tr style="color: #000000; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 15px;">
                                                        <td width="100%">
                                                            Sale date: {{ $seller_order['created_at'] }}<br>
                                                            Order #{{$seller_order['id']}}
                                                        </td>
                                                    </tr>
                                                    <!-- schedule pick-up button -->
                                                    <tr>
                                                        <td>
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 10px 0px 0px 0px">
                                                                <tr>
                                                                    <td>
                                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td align="center" style="-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;" bgcolor="#e9703e">
                                                                                    <a href="{{ url('/order/seller/'.$seller_order['id']) }}" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; padding: 12px 18px; border: 1px solid #e9703e; display: inline-block;">Schedule Pick-up &rarr;</a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                    </tr>
                                                    <br>

                                                    <!-- ship and pay details. row 2 row 2-->
                                                   {{-- <tr>
                                                        <!-- ship and pay table -->
                                                        <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td valign="top" style="color: #000000; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 14px;" width="40%" align="left">
                                                                    <b style="color: #5b5b5b">Pick-up Address</b><br>
                                                                    <!-- TODO: pick up addr -->

                                                                </td>

                                                                <!-- spacing. row 2 column 2 -->
                                                                <td style="font-size: 0; line-height: 0;" width="10%">
                                                                    &nbsp;
                                                                </td>

                                                                <!-- payment details row 2 column 3-->
                                                                <td valign="top" style="color: #153643; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 14px;" width="40%" align="left">
                                                                    <b style="color: #737373;">Payment Method</b><br>

                                                                </td>
                                                            </tr>
                                                        </table> <!-- end ship and pay table -->
                                                    </tr> <!-- end shipping address and payment method -->--}}


                                                    <!-- items -->
                                                    <tr>
                                                        <td style="color: #153643; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 14px;" width="100%">
                                                            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
                                                                <tr><b style="color: #737373;">Details</b>
                                                                    <br><br>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" style="color: #000000;">
                                                                        <a href="{{ url('/order/seller/'.$seller_order['id']) }}">
                                                                            <img src="{{$seller_order['product']['book']['image_set']['small_image']}}" alt="sold book image">
                                                                        </a>
                                                                        <br>
                                                                    </td>
                                                                    <td valign="top" style="color: #153643; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 14px;">
                                                                        Title: <a href="{{ url('/order/seller/'.$seller_order['id']) }}">
                                                                            {{$seller_order['product']['book']['title']}}</a> <br>
                                                                        ISBN: {{$seller_order['product']['book']['isbn13']}} <br>
                                                                        Author(s):
                                                                        @foreach($seller_order['product']['book']['authors'] as $author)
                                                                            <span>{{ $author['full_name'] }}</span>
                                                                        @endforeach
                                                                        <br>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        <td>
                                                    </tr>

                                                </table>

                                            </td> <!-- end main content -->
                                        </tr>
                                    </table> <!--end content table -->
                                </td> <!-- end content container -->
                            </tr> <!-- end row 2 -->
                            <!-- row 3 footer -->
                            <tr>
                                <td bgcolor="#292C2F" style="padding: 30px 30px 30px 30px;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <!-- row 3 row 1 -->
                                        <tr>
                                            <!-- row 3 row 1 column 1 -->
                                            <td width="65%" style= "color: #ffffff; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 14px;" >
                                                &copy; Stuvi LLC., Boston 2015<br/>
                                                <!-- <a href="#" style="color: #ffffff;"><font color="#ffffff">Unsubscribe</font></a> to this newsletter instantly -->
                                            </td>
                                            <!-- row 3 row 1 column 2 -->
                                            <td align="right" width="35%">
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 12px; font-weight: bold;">
                                                            <a href="https://twitter.com/StuviBoston" style="color: #ffffff;">
                                                                <img src="http://puu.sh/iDIwb/6b9c1ad919.png" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                            </a>
                                                        </td>
                                                        <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                        <td style="font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 12px; font-weight: bold;">
                                                            <a href="https://www.facebook.com/StuviBoston" style="color: #ffffff;">
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
                        </table> <!-- end third table container -->
                    </td> <!-- end data 1/1 for only row of 600px table -->
                </tr> <!-- end top row of 600px table -->
            </table> <!-- end content 600px table (border) -->
        </td> <!-- end top level data -->
    </tr> <!-- end top level row -->
</table> <!-- end container table -->
</body>
</html>


