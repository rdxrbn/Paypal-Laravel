<?php
/**
 * Created by: Rooban Viveh
 * Email: followrdx@gmail.com
 * Date: 12/25/18
 */

namespace App\Paypal;


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class ProcessPayment extends Paypal
{
    public function process(){

        $payment = $this->RequestPayment();
        $execution = $this->Execution();
        $transaction = new Transaction();
        $amount = $this->Amount($this->Details());

        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);

        $result = $payment->execute($execution, $this->apiContext);

        return $result;
    }

    /**
     * @return mixed
     */
    protected function RequestPayment()
    {
        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        return $payment;
    }

    /**
     * @return PaymentExecution
     */
    protected function Execution(): PaymentExecution
    {
        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));
        return $execution;
    }

    /**
     * @param $details
     * @return Amount
     */
    protected function Amount($details): Amount
    {
        $amount = new Amount();
        $amount->setCurrency('GBP');
        $amount->setTotal(20);
        $amount->setDetails($details);
        return $amount;
    }

    /**
     * @return Details
     */
    protected function Details(): Details
    {
        $details = new Details();
        $details->setShipping(1.2)
                ->setTax(1.3)
                ->setSubtotal(17.50);
        return $details;
    }
}
