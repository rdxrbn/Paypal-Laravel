<?php
/**
 * Created by: Rooban Viveh
 * Email: followrdx@gmail.com
 * Date: 12/25/18
 */
namespace App\Http\Controllers;

use App\Paypal\CreatePayment;
use App\Paypal\ProcessPayment;

class PaymentController extends Controller
{

    public function create(){
        $payment = new CreatePayment();
        $paymentCreate =$payment->create();
        return $paymentCreate;

    }

    public function process() {
        $process = new ProcessPayment();
        $paymentProcess = $process->process();
        $response = json_decode($paymentProcess, true);

        $paymentData = [
            'paypalId' => $response['id'],
            'paymentStatus' => $response['state'],
            'cart' => $response['cart'],
            'payerEmail' => $response['payer']['payer_info']['email'],
            'payerName' => $response['payer']['payer_info']['first_name'].' '.$response['payer']['payer_info']['last_name'],
            'payerPostcode' => $response['payer']['payer_info']['shipping_address']['postal_code'],
            'payerStatus' => $response['payer']['status'],
            'amount' => $response['transactions'][0]['amount']['total'],
            'currency' => $response['transactions'][0]['amount']['currency'],
            'invoiceNo' => $response['transactions'][0]['invoice_number'],
            'created_at' => $response['create_time'],
            'paypal_transaction_fee' => $response['transactions'][0]['related_resources'][0]['sale']['transaction_fee']['value'],
            'paymentId' => $response['transactions'][0]['related_resources'][0]['sale']['id'],
            'paymentMode' => $response['transactions'][0]['related_resources'][0]['sale']['payment_mode'],
            'saleStatus' => $response['transactions'][0]['related_resources'][0]['sale']['state'],
            'payment_description' => $response['transactions'][0]['description'],
        ];

       return $paymentData;
        //return view('response',compact('response'));
    }
}
