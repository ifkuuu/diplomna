<?php


namespace Service\Mail;


use Data\Orders\Order;

interface MailServiceInterface
{
    public function sendOrderInfoEmail(Order $order);
}
