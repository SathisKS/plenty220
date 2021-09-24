<?php
/**
 * This file is used for creating Novalnet payment mehtods
 * This free contribution made by request.
 * 
 * If you have found this script useful a small
 * recommendation as well as a comment on merchant form
 * would be greatly appreciated.
 *
 * @author       Novalnet AG
 * @copyright(C) Novalnet
 * All rights reserved. https://www.novalnet.de/payment-plugins/kostenlos/lizenz
 */
 
namespace Novalnet\Migrations;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Novalnet\Helper\PaymentHelper;

/**
 * Migration to create payment mehtods
 *
 * Class UpdatePaymentMethods
 *
 * @package Novalnet\Migrations
 */
class UpdatePaymentMethods
{
    /**
     * @var PaymentMethodRepositoryContract
     */
    private $paymentMethodRepository;

    /**
     * @var PaymentHelper
     */
    private $paymentHelper;

    /**
     * CreatePaymentMethod constructor.
     *
     * @param PaymentMethodRepositoryContract $paymentMethodRepository
     * @param PaymentHelper $paymentHelper
     */
    public function __construct(PaymentMethodRepositoryContract $paymentMethodRepository,
                                PaymentHelper $paymentHelper)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->paymentHelper = $paymentHelper;
    }

    /**
     * Run on plugin build
     *
     * Create Method of Payment ID for Novalnet payment if they don't exist
     */
    public function run()
    {
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_CC', 'Novalnet Credit/Debit Cards');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_SEPA', 'Novalnet Direct Debit SEPA');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_INVOICE', 'Novalnet Invoice');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_PREPAYMENT', 'Novalnet Prepayment');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_CASHPAYMENT', 'Novalnet Barzahlen/viacash');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_SOFORT', 'Novalnet Sofort');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_PAYPAL', 'Novalnet PayPal');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_IDEAL', 'Novalnet iDEAL');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_EPS', 'Novalnet eps');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_GIROPAY', 'Novalnet giropay');
        $this->createNovalnetPaymentMethodByPaymentKey('NOVALNET_PRZELEWY', 'Novalnet Przelewy24');
    }


    /**
     * Create payment method with given parameters if it doesn't exist
     *
     * @param string $paymentKey
     * @param string $name
     */
    private function createNovalnetPaymentMethodByPaymentKey($paymentKey, $name)
    {
        $payment_data = $this->paymentHelper->getPaymentMethodByKey($paymentKey);
        if ($payment_data == 'no_paymentmethod_found')
        {
          $paymentMethodData = ['pluginKey'  => 'plenty_novalnet',
                                'paymentKey' => $paymentKey,
                                'name'       => $name
                               ];
            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        } elseif ($payment_data[1] == $paymentKey && !in_array ($payment_data[2], ['Novalnet Invoice', 'Novalnet Prepayment', 'Novalnet Credit/Debit Cards', 'Novalnet Direct Debit SEPA', 'Novalnet Sofort', 'Novalnet PayPal', 'Novalnet iDEAL', 'Novalnet eps', 'Novalnet giropay', 'Novalnet Przelewy24', 'Novalnet Barzahlen/viacash' ]) ) {
          $paymentMethodData = ['pluginKey'  => 'plenty_novalnet',
                                'paymentKey' => $paymentKey,
                                'name'       => $name,
                                'id'         => $payment_data[0]
                               ];
            $this->paymentMethodRepository->updateName($paymentMethodData);
        }
    }
}
