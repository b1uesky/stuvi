{{-- This is the html that will be sent out for order confirmation emails--}}
{{-- For more info visit: http://webdesign.tutsplus.com/series/mastering-html-email--webdesign-17696--}}

{{-- Send an email with order/test--}}

<!-- new redo -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset=UTF-8" />
        <title>Stuvi Order Confirmation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body style="margin: 0; padding: 0;">
        <!-- container table. Style things in here. not body -->
        <table border="1" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <table align="center" border="1" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                        <tr>
                            <td>
                                <table align="center" border="1" cellpadding="0" cellspacing="0" width="600">
                                    <!-- row 1 header-->
                                    <tr>
                                        <!-- header image/logo -->
                                        <td align="center" bgcolor="#241729" style="padding: 40px 0 30px 0;">
                                            <img src="http://puu.sh/iDvTG/18b055e116.png" alt="Stuvi Logo" width="552" height="221" style="display: block;" />
                                        </td>
                                    </tr>
                                    <!-- row 2 content-->
                                    <tr>
                                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                            <table border="1" cellpadding="0" cellspacing="0" width="100%">
                                                <!-- content row 1 -->
                                                <tr>
                                                    <!-- header/tag line.. -->
                                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 36px;">
                                                        <b>Your Stuvi Order Confirmation</b>
                                                    </td>
                                                </tr>
                                                <!-- content row 2 -->
                                                <tr>
                                                    <!-- main content -26
                                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat.
                                                    </td>
                                                </tr>
                                                <!-- content row 3 -->
                                                <tr>
                                                    <td>
                                                        <table border="1" cellpadding="0" cellspacing="0" width="100%">
                                                            <!-- content row 3 column 1 -->
                                                            <tr>
                                                                <td width="260" valign="top">
                                                                    <table border="1" cellpadding="0" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td>
                                                                                <img src="http://placehold.it/260x140" alt="" width="100%" height="140" style="display: block;" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat.
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <!-- content row 3 column 2 (spacing) -->
                                                                <td style="font-size: 0; line-height: 0;" width="20">
                                                                    &nbsp;
                                                                </td>
                                                                <!-- content row 3 column 3 -->
                                                                <td width="260" valign="top">
                                                                    <table border="1" cellpadding="0" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td>
                                                                                <img src="http://placehold.it/260x140" alt="" width="100%" height="140" style="display: block;" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat.
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
                                    <!-- row 3 footer -->
                                    <tr>
                                        <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                                            <table border="1" cellpadding="0" cellspacing="0" width="100%">
                                                <!-- row 3 row 1 -->
                                                <tr>
                                                    <!-- row 3 row 1 column 1 -->
                                                    <td width="75%" style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                                        &reg; Someone, somewhere 2013<br/>
                                                        Unsubscribe to this newsletter instantly
                                                    </td>
                                                    <!-- row 3 row 1 column 2 -->
                                                    <td align="right" width="25%">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td>
                                                                    <a href="http://www.twitter.com/">
                                                                        <img src="images/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                                    </a>
                                                                </td>
                                                                <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                                <td>
                                                                    <a href="http://www.twitter.com/">
                                                                        <img src="images/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
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


