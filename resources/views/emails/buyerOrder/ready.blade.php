
{{-- This is the Buyer order ready email. I suggest using this as a template. Made by Nick --}}

<!-- TODO: add order # -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset=UTF-8" />
    <title>Your order is on its way - Order #{{ $buyer_order['id'] }}</title>
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
                                        <img src="http://puu.sh/jg7HJ/cbdfb5e1f5.png" alt="Stuvi" width="276" height="110" style="display: block; color: #ffffff" />
                                    </a>
                                </td> <!-- end header img -->
                            </tr>
                            <!-- row 2. content-->
                            <tr>
                                <!-- container for content -->
                                <td bgcolor="#F2F2F2" style="padding: 40px 30px 40px 30px;">
                                    <!-- content table -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <!-- content row 1 -->
                                        <tr>
                                            <!-- header/tag line.. -->
                                            <td style="color: #153643; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 30px;">
                                                <b>Order #{{ $buyer_order['id'] }} has been deployed.</b>
                                            </td>
                                        </tr>
                                        <!-- content row 2 -->
                                        <tr>
                                            <!-- main content -->
                                            <td style="padding: 20px 0 30px 0;">
                                                <!-- details -->
                                                <table border="0" cellpadding="0px" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td style="color: #F16521; font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 17px;" width="100%">
                                                            <!-- CONTENT HERE! -->
                                                            <p>Hey, {{$buyer_order['buyer']['first_name']}}</p>
                                                            <p>Your order is on the way! Click the button below for your order details.</p>
                                                            <br>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <!-- button -->
                                                            <tr>
                                                                <td>
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 10px 0px 0px 0px">
                                                                        <tr>

                                                                            <td align="center">
                                                                                <table border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <!-- TODO: Working link to order/buyer/< product # > -->
                                                                                        <td align="center" style="-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;" bgcolor="#e9703e">
                                                                                            <a href="" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; padding: 12px 18px; border: 1px solid #e9703e; display: inline-block;">
                                                                                                Order Details &rarr;</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>

                                                                        </tr>
                                                                    </table>
                                                            </tr>
                                                    <br>
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

