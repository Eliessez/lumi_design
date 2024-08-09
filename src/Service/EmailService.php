<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Orders;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendOrderConfirmationEmail(Orders $order)
    {
        $email = (new TemplatedEmail())
            ->from('lumiDesign@support.com')
            ->to(new Address($order->getCustomer()->getEmail()))
            ->subject('Votre Commande: ' . $order->getOrdersNumber())
            ->htmlTemplate('front/emails/order_confirmation.html.twig')
            ->locale('fr')
            ->context([
                'order' => $order,
                'username' => 'foo',
            ]);

        $this->mailer->send($email);
    }
}