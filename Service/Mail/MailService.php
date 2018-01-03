<?php


namespace Service\Mail;


use Data\Orders\Order;

class MailService implements MailServiceInterface
{

    const EMAIL_TEMPLATES_FOLDER = "frontend/email_templates/";

    public function sendOrderInfoEmail(Order $order)
    {
        // $message = file_get_contents(__DIR__ . '/../../' . self::EMAIL_TEMPLATES_FOLDER . 'order_email_template.php');
        // TODO: Implement a template functionality instead of using the HTML here.

        $products = $order->getProducts();
        $user = $order->getUser();
        $city = $order->getCity();
        $date = new \DateTime($order->getCreatedOn());

        $headers = "Content-type: text/html; charset=UTF-8" ;
        $receiver = $user->getEmail();
        $subject = "Регистрирана поръчка № {$order->getId()}";


        // Съжалявам за това изчадие, надявам се в бъдеще да го направя с темплейт!
        $message = '<table style="border-collapse:collapse;max-width:700px;min-width:320px;" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
    <tr>
        <td style="width:100.0%;">
            <table class="" style="max-width:700px;min-width:320px;border-collapse:collapse;margin:0 auto;background:#ffffff;" align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr>
                    <td style="padding:15px;border:#dbdbdb solid 1px;border-top:none;background:#ffffff;border-collapse:collapse;">
                        <table style="border-collapse:collapse;" width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                            <tr>
                                <td align="center">
                                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td style="color:#f7f7f7;background-color: #1abc9c;padding:20px 2.0% 10px 2.0%;border-bottom:2px solid #dbdbdb;line-height:150.0%;font-size:15px;font-weight:bold;font-family:sans-serif, Helvetica, Arial;" align="center"> Детайли на поръчка номер #' . $order->getId() . '<br> <span style="color:#f8f8f8;font-size:13px;"> регистрирана на ' . $date->format('d.m.Y') . ' </span> </td>
                                        </tr>
                                        </tbody>
                                    </table> </td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <table style="border-collapse:collapse;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td style="border-top:1px solid #ffffff;font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;" align="left" width="30%" valign="top"> Доставка: </td>
                                            <td style="border-top:1px solid #ffffff;font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;" align="left" width="70%" valign="top"> ' . $order->getAddress() . ', гр. ' . $city->getName() . ', п.к. ' . $city->getPostCode() .' </td>
                                        </tr>
                                        <tr>
                                            <td style="border-top:1px solid #dbdbdb;font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;" align="left" width="30%" valign="top"> Начин на плащане: </td>
                                            <td style="border-top:1px solid #dbdbdb;font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;" align="left" width="70%" valign="top">' . $order->getPaymentMethod() . '</td>
                                        </tr>
                                        <tr>
                                            <td style="border-top:1px solid #dbdbdb;font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;" align="left" width="30%" valign="top"> За: </td>
                                            <td style="border-top:1px solid #dbdbdb;font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;" align="left" width="70%" valign="top">' . $user->getFirstName() . ' ' . $user->getLastName() . '<br>' . $user->getPhone() . '</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table style="border-collapse:collapse;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td style="border-bottom:2px solid #1abc9c;font-weight:bold;font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;text-align:left;" align="left" width="60%" valign="top"> Поръчани продукти</td>
                                            <td width="20%">&nbsp;</td>
                                            <td width="20%">&nbsp;</td>
                                        </tr>';
                                        foreach ($products as $product) {
                                            $message .= "<tr>
                                            <td colspan=\"3\" style=\"font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;\" align=\"left\" valign=\"middle\">
                                                <div style=\"min-width:300px;max-width:396px;display:inline-block;vertical-align:top;\" class=\"\">
                                                    <table style=\"border-collapse:collapse;border-spacing:0;margin-top:0px;\" align=\"center\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                        <tbody>
                                                        <tr>
                                                            <td width=\"4%\">&nbsp;</td>
                                                            <td style=\"font-family:sans-serif, Helvetica, Arial;font-size:14px;padding:0.5em 0;\" align=\"left\" width=\"75%\" valign=\"middle\">{$product->getName()}, {$product->getColourInfo()->getColour()}, {$product->getSizeInfo()->getSize()}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style=\"min-width:268px;display:inline-block;vertical-align:top;text-align:center;\" class=\"\">
                                                    <table style=\"border-collapse:collapse;border-spacing:0;\" align=\"center\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                                        <tbody>
                                                        <tr>
                                                            <td style=\"font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;\" class=\"\" align=\"right\" width=\"50%\" valign=\"middle\"></td>
                                                            <td style=\"font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;\" class=\"\" align=\"right\" width=\"50%\" valign=\"middle\"> {$product->getPrice()} лв </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                             </td>
                                        </tr>";
                                        }
$message .= '<tr>
                                            <td colspan="3" style="font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;" align="right" valign="middle">
                                                <div style="min-width:268px;max-width:320px;display:inline-block;vertical-align:middle;text-align:right;" class="">
                                                    <table style="border-collapse:collapse;border-spacing:0;" align="right" width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;border-top:1px dotted #dbdbdb;" align="right" width="50%" valign="middle"> Доставка: </td>
                                                            <td style="font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;border-top:1px dotted #dbdbdb;" align="right" width="50%" valign="middle"> <strong>БЕЗПЛАТНА</strong> </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>  </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;" align="right" valign="middle">
                                                <div style="min-width:268px;max-width:320px;display:inline-block;vertical-align:middle;text-align:right;" class="">
                                                    <table style="border-collapse:collapse;border-spacing:0;" align="right" width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;border-top:1px dotted #dbdbdb;" align="right" width="50%" valign="middle"> Общо продукти: </td>
                                                            <td style="font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;border-top:1px dotted #dbdbdb;" align="right" width="50%" valign="middle"> <strong>'. $order->getOrderCost() .' лв </strong> </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>  </td>
                                        </tr>
                                        </tbody>
                                    </table> </td>
                            </tr>
                            <tr>
                                <td style="border-top:2px solid #1abc9c;font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;" align="right" valign="middle">
                                    <div style="min-width:268px;max-width:320px;display:inline-block;vertical-align:middle;text-align:right;" class="">
                                        <table style="border-collapse:collapse;border-spacing:0;" align="right" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td style="font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;" align="right" width="50%" valign="middle"> Общо: </td>
                                                <td style="font-family:sans-serif, Helvetica, Arial;font-size:14px;line-height:18px;padding:0.5em 0;" align="right" width="50%" valign="middle"> <strong>'. $order->getOrderCost() .' лв </strong> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>  </td>
                            </tr>
                            </tbody>
                        </table> </td>
                </tr>
                </tbody>
            </table> </td>
    </tr>
    </tbody>
</table>';

        return mail($receiver, $subject, $message, $headers);
    }
}
