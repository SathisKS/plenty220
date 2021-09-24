<?php
/**
 * This module is used for real time processing of
 * Novalnet payment module of customers.
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
 
namespace Novalnet\Providers\DataProvider;

use Plenty\Plugin\Templates\Twig;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Plenty\Modules\Payment\Method\Models\PaymentMethod;

class NovalnetPaymentMethodReinitializePaymentScript
{
  public function call(Twig $twig):string
  {
    // Load the all Novalnet payment methods
    $paymentMethodRepository = pluginApp(PaymentMethodRepositoryContract::class);
    $paymentMethods          = $paymentMethodRepository->allForPlugin('plenty_novalnet');
    if(!is_null($paymentMethods))
    {
       $paymentMethodIds              = [];
        foreach ($paymentMethods as $paymentMethod) {
          if ($paymentMethod instanceof PaymentMethod) {
              $paymentMethodIds[] = $paymentMethod->id;
          }
        }
    }
    
    return $twig->render('Novalnet::NovalnetPaymentMethodReinitializePaymentScript', ['paymentMethodIds' => $paymentMethodIds]);
  }
}
