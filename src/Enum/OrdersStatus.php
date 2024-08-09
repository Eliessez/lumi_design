<?php 

namespace App\Enum;

enum OrdersStatus: string
{
    case PENDING = 'en attente';
    case PAYMENT_PENDING = 'paiement en attente';
    case PAID = 'payé';
    case PROCESSING = 'en préparation';
    case SHIPPED = 'envoyé';
    case DELIVERED = 'livré';
    case CANCELLED  = 'annulé';
}