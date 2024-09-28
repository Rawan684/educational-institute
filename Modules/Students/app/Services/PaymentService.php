<?php

namespace Modules\Students\Services;

use AuthorizeNet\AuthorizeNet;
use AuthorizeNet\Transaction;
use Modules\Students\Models\Enrollment;

class PaymentService
{


    public function processPayment(Enrollment $enrollment)
    {
        //     $authorizeNet = new AuthorizeNet(
        //         'YOUR_AUTHORIZE_NET_API_LOGIN_ID',
        //         'YOUR_AUTHORIZE_NET_TRANSACTION_KEY'
        //     );

        //     $transaction = new Transaction();
        //     $transaction->setAmount($enrollment->amount)
        //         ->setDescription('Enrollment payment')
        //         ->setInvoiceNumber(uniqid());

        //     $response = $authorizeNet->chargeCard($transaction);

        //     if ($response->getResponseCode() === '1') {
        //         // Payment successful, update enrollment status
        //         $enrollment->update(['payment_status' => 'paid']);
        //     } else {
        //         // Payment failed, update enrollment status
        //         $enrollment->update(['payment_status' => 'failed']);
        //     }
    }
}
