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

namespace Novalnet\Providers;

use Plenty\Plugin\Templates\Twig;

use Novalnet\Helper\PaymentHelper;
use Plenty\Modules\Order\Models\Order;
use Plenty\Modules\Payment\Models\Payment;
use Plenty\Modules\Comment\Contracts\CommentRepositoryContract;
use Plenty\Modules\Payment\Contracts\PaymentRepositoryContract;
use \Plenty\Modules\Authorization\Services\AuthHelper;
use Plenty\Modules\Frontend\Session\Storage\Contracts\FrontendSessionStorageFactoryContract;
use Novalnet\Services\PaymentService;
use Novalnet\Services\TransactionService;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use Plenty\Modules\Plugin\DataBase\Contracts\Query;
use Novalnet\Models\TransactionLog;

/**
 * Class NovalnetOrderConfirmationDataProvider
 *
 * @package Novalnet\Providers
 */
class NovalnetOrderConfirmationDataProvider
{
    /**
     * Setup the Novalnet transaction comments for the requested order
     *
     * @param Twig $twig
     * @param PaymentRepositoryContract $paymentRepositoryContract
     * @param Arguments $arg
     * @return string
     */
    public function call(Twig $twig, PaymentRepositoryContract $paymentRepositoryContract, $arg)
    {
        $paymentHelper = pluginApp(PaymentHelper::class);
        $paymentService = pluginApp(PaymentService::class);
        $transactionLog  = pluginApp(TransactionService::class); 
        $sessionStorage = pluginApp(FrontendSessionStorageFactoryContract::class);
        $database = pluginApp(DataBase::class);
        $order = $arg[0];
        $barzhlentoken = '';
        $barzahlenurl = '';
        $payments = $paymentRepositoryContract->getPaymentsByOrderId($order['id']);
        if (!empty ($order['id'])) {
            foreach($payments as $payment)
            {
                $properties = $payment->properties;
                foreach($properties as $property)
                {
                if ($property->typeId == 21) 
                {
                $invoiceDetails = $property->value;
                }
                if ($property->typeId == 30)
                {
                $tid_status = $property->value;
                }
                if ($property->typeId == 22)
                {
                $cashpayment_comments = $property->value;
                }
                }
                if($paymentHelper->getPaymentKeyByMop($payment->mopId))
                {
                    if ($payment->method['paymentKey'] == 'NOVALNET_CASHPAYMENT')
                    {
                        $barzhlentoken = html_entity_decode((string)$sessionStorage->getPlugin()->getValue('novalnet_checkout_token'));
                        $barzahlenurl = html_entity_decode((string)$sessionStorage->getPlugin()->getValue('novalnet_checkout_url'));
                    }
                    $orderId = (int) $payment->order['orderId'];
                    $comment = '';
                    $db_details = $paymentService->getDatabaseValues($orderId);
                    
                    $comments = '';
                    $comments .= PHP_EOL . $paymentHelper->getTranslatedText('nn_tid') . $db_details['tid'];
                    if(!empty($db_details['test_mode'])) {
                        $comments .= PHP_EOL . $paymentHelper->getTranslatedText('test_order');
                    }
                    
                    // Display error message in the confirmation page
                    $statusMessage = $sessionStorage->getPlugin()->getValue('novalnet_status_message');
                    if (in_array($tid_status, [75, 85, 86, 90, 91, 98, 99, 100])) {
                        $sessionStorage->getPlugin()->setValue('novalnet_status_message', null);
                        $statusMessage = '';
                    }
                    
                    if(!empty($statusMessage)) {
                        $comments .= PHP_EOL . $statusMessage;
                    }
                    
                    $bank_details = array_merge($db_details, json_decode($invoiceDetails, true));
                    if(in_array($db_details['payment_id'], ['40','41'])) {
                        $comments .= PHP_EOL . $paymentHelper->getTranslatedText('guarantee_text');
                        if($tid_status == '75' && $db_details['payment_id'] == '41')
                        {
                            $comments .= PHP_EOL . $paymentHelper->getTranslatedText('gurantee_invoice_pending_payment_text');
                        }
                        if( $tid_status == '75' && $db_details['payment_id'] == '40')
                        {
                            $comments .= PHP_EOL . $paymentHelper->getTranslatedText('gurantee_sepa_pending_payment_text');
                        }
                    }
                    $get_transaction_details = $database->query(TransactionLog::class)->where('orderNo', '=', $orderId)->whereIn('paymentName', ['novalnet_invoice', 'novalnet_prepayment', 'novalnet_cashpayment'])->get();
                    $totalCallbackAmount = 0;
                    foreach ($get_transaction_details as $transaction_details) {
                       $totalCallbackAmount += $transaction_details->callbackAmount;
                    }
                    
                    if(in_array($tid_status, ['91', '100']) && ($db_details['payment_id'] == '27' && ($transaction_details->amount > $totalCallbackAmount) || $db_details['payment_id'] == '41') ) {
                        $bank_details['tid_status'] = $tid_status;
                        $comments .= PHP_EOL . $paymentService->getInvoicePrepaymentComments($bank_details);
                    }
                    if($db_details['payment_id'] == '59' && ($transaction_details->amount > $totalCallbackAmount) && $tid_status == '100') {
                        $comments .= $cashpayment_comments;
                    }
                }
            }
                    $comment .= (string) $comments;
                    $comment .= PHP_EOL;
        }   
        
                  $payment_type = (string)$paymentHelper->getPaymentKeyByMop($payment->mopId);
                  $comment = str_replace(PHP_EOL,'<br>',$comment);
                  
                  return $twig->render('Novalnet::NovalnetOrderHistory', ['comments' => html_entity_decode($comment),'barzahlentoken' => $barzhlentoken,'payment_type' => html_entity_decode($payment_type),'barzahlenurl' => $barzahlenurl]);
    }
}

    

