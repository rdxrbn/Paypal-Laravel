<?php
/**
 * Created by: Rooban Viveh
 * Email: followrdx@gmail.com
 * Date: 12/25/18
 */

namespace App\Paypal;


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class CreatePayment extends Paypal
{
    public function create() {
        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
            ->setCurrency('GBP')
            ->setQuantity(1)
            ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice(7.5);
        $item2 = new Item();
        $item2->setName('Granola bars')
            ->setCurrency('GBP')
            ->setQuantity(5)
            ->setSku("321321") // Similar to `item_number` in Classic API
            ->setPrice(2);

        $itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));

        $payment = $this->Payment($itemList);

        $payment->create($this->apiContext);

        //dd($payment->getApprovalLink());
        $payLink =$payment->getApprovalLink();

        return redirect($payLink);

    }

    /**
     * @return Payer
     */
    protected function Payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        return $payer;
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

    /**
     * @param $details
     * @return Amount
     */
    protected function Amount(): Amount
    {
        $amount = new Amount();
        $amount->setCurrency("GBP")
            ->setTotal(20)
            ->setDetails($this->Details());
        return $amount;
    }

    /**
     * @param $amount
     * @param $itemList
     * @return Transaction
     */
    protected function Transaction($itemList): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->Amount())
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
        return $transaction;
    }

    /**
     * @return RedirectUrls
     */
    protected function RedirectUrls(): RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(config('services.paypal.url.redirect'))
            ->setCancelUrl(config('services.paypal.url.cancelled'));
        return $redirectUrls;
    }

    /**
     * @param $payer
     * @param $redirectUrls
     * @param $transaction
     * @return Payment
     */
    protected function Payment($itemList): Payment
    {
        $payment = new Payment();
        $payment->setIntent("Sale")
            ->setPayer($this->Payer())
            ->setRedirectUrls($this->RedirectUrls())
            ->setTransactions(array($this->transaction($itemList)));
        return $payment;
    }
}
