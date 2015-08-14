<?php namespace App\Helpers;
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 8/11/15
 * Time: 10:54 AM
 *
 * DOCS: https://developer.paypal.com/webapps/developer/docs/api/
 * API: https://github.com/paypal/PayPal-PHP-SDK/tree/master/lib/PayPal/Api
 */

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Currency;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payout;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\PayoutItem;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use Config;

class Paypal extends \App\Helpers\Payment
{
    /**
     * object to authenticate the call.
     * @param object $api_context
     */
    private $api_context;

    /**
     * Set the ClientId and the ClientSecret.
     * @param
     *string $client_id
     *string $client_secret
     */
    private $client_id;
    private $client_secret;

    public function __construct()
    {
        $this->client_id = Config::get('paypal_payment.Account.ClientId');
        $this->client_secret = Config::get('paypal_payment.Account.ClientSecret');
        $this->api_context = new ApiContext(
            new OAuthTokenCredential($this->client_id, $this->client_secret)
        );

        $flatConfig = array_dot(Config::get('paypal_payment')); // Flatten the array with dots
        $this->api_context->setConfig($flatConfig);
    }

    /**
     * Create Paypal payment by credit card.
     * https://github.com/paypal/PayPal-PHP-SDK/blob/master/sample/payments/CreatePayment.php
     *
     * @param array $address
     * @param array $credit_card
     * @param array $items
     * @param decimal subtotal
     * @param decimal $shipping
     * @param decimal $tax
     * @param decimal $total
     * @return string
     */
    public function createPaymentByCreditCard($address, $credit_card, $items, $subtotal, $shipping, $tax, $total)
    {
        $addr = new Address();
        $addr->setLine1($address['address_line1']);
        $addr->setLine2($address['address_line2']);
        $addr->setCity($address['city']);
        $addr->setState($address['state_a2']);
        $addr->setPostalCode($address['zip']);
        $addr->setCountryCode($address['country_a2']);
        $addr->setPhone($address['phone_number']);

        $cc = new CreditCard();
        $cc->setType($credit_card['type'])
            ->setNumber($credit_card['number'])
            ->setExpireMonth($credit_card['expire_month'])
            ->setExpireYear($credit_card['expire_year'])
            ->setCvv2($credit_card['cvv'])
            ->setFirstName($credit_card['first_name'])
            ->setLastName($credit_card['last_name']);

        $fi = new FundingInstrument();
        $fi->setCreditCard($cc);

        $payer = new Payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        $items_paypal = array();

        foreach ($items as $item)
        {
            $item_paypal = new Item();
            $item_paypal->setName($item['name'])
                ->setDescription($item['description'])
                ->setCurrency($item['currency'])
                ->setQuantity($item['quantity'])
                ->setPrice($item['price']);

            array_push($items_paypal, $item_paypal);
        }

        $itemList = new ItemList();
        $itemList->setItems($items_paypal);

        $details = new Details();
        $details->setShipping($shipping)
            ->setTax($tax)
            ->setSubtotal($subtotal);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->api_context);
        } catch (\PPConnectionException $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        return $payment;
    }

    /**
     * Create Paypal payment by Paypal account.
     * https://github.com/paypal/PayPal-PHP-SDK/blob/master/sample/payments/CreatePaymentUsingPayPal.php
     *
     * @param array $items
     * @param decimal $subtotal
     * @param decimal $shipping
     * @param decimal $tax
     * @param decimal $total
     * @param $shipping_address_id
     * @return string
     */
    public function createPaymentByPaypal($items, $subtotal, $shipping, $tax, $total, $shipping_address_id)
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $items_paypal = array();

        foreach ($items as $item)
        {
            $item_paypal = new Item();
            $item_paypal->setName($item['name'])
                ->setDescription($item['description'])
                ->setCurrency($item['currency'])
                ->setQuantity($item['quantity'])
                ->setPrice($item['price']);

            array_push($items_paypal, $item_paypal);
        }

        $itemList = new ItemList();
        $itemList->setItems($items_paypal);

        $details = new Details();
        $details->setShipping($shipping)
            ->setTax($tax)
            ->setSubtotal($subtotal);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Redirect urls
        // Set the urls that the buyer must be redirected to after
        // payment approval/cancellation.
        $redirectUrls = new RedirectUrls();
        $redirectUrls
            ->setReturnUrl(url('order/executePayment?shipping_address_id=' . $shipping_address_id))
            ->setCancelUrl(url('order/create'));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->api_context);
        } catch (Exception $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        return $payment;
    }

    /**
     * Execute payment.
     * https://github.com/paypal/PayPal-PHP-SDK/blob/master/sample/payments/ExecutePayment.php
     *
     * @param $payment_id
     * @param $payer_id
     * @return Payment|string
     */
    public function executePayment($payment_id, $payer_id)
    {
        // Get the payment Object by passing paymentId
        $payment =  Payment::get($payment_id, $this->api_context);

        // ### Payment Execute
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($payer_id);

        try {
            $result = $payment->execute($execution, $this->api_context);

            try {
                $payment = Payment::get($payment_id, $this->api_context);
            } catch (Exception $ex) {
                return "Exception: " . $ex->getMessage() . PHP_EOL;
                exit(1);
            }
        } catch (Exception $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        return $payment;
    }

    /**
     * Create a single payout.
     * https://github.com/paypal/PayPal-PHP-SDK/blob/master/sample/payouts/CreateSinglePayout.php
     *
     * @param array $item
     * @return \PayPal\Api\PayoutBatch
     */
    public function createSinglePayout($item)
    {
        $payouts = new Payout();

        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");

        $amount = new Currency();
        $amount->setCurrency($item['currency'])
            ->setValue($item['value']);

        $senderItem = new PayoutItem();
        $senderItem->setRecipientType($item['recipient_type'])
            ->setNote($item['note'])
            ->setReceiver($item['receiver'])
            ->setSenderItemId($item['item_id'])
            ->setAmount($amount);

        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem);

        try {
            $output = $payouts->createSynchronous($this->api_context);
        } catch (Exception $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        return $output;
    }

    /**
     * Create batch payout.
     * https://github.com/paypal/PayPal-PHP-SDK/blob/master/sample/payouts/CreateBatchPayout.php
     *
     * @param $items
     * @return \PayPal\Api\PayoutBatch|string
     */
    public function createBatchPayout($items)
    {
        $payouts = new Payout();

        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");

        $payouts->setSenderBatchHeader($senderBatchHeader);

        foreach ($items as $item)
        {
            $amount = new Currency();
            $amount->setCurrency($item['currency'])
                ->setValue($item['value']);

            $senderItem = new PayoutItem();
            $senderItem->setRecipientType($item['recipient_type'])
                ->setNote($item['note'])
                ->setReceiver($item['receiver'])
                ->setSenderItemId($item['item_id'])
                ->setAmount($amount);

            $payouts->addItem($senderItem);
        }

        try {
            $output = $payouts->create($this->api_context);
        } catch (Exception $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        return $output;
    }

    /**
     * Validation rules.
     *
     * @return array
     */
    public static function rules()
    {
        $max_year = date('Y') + 20;

        return array(
            'address_id'            => 'required|integer|exists:addresses,id',
            'number'                => 'required|string',
            'type'                  => 'required|string|in:amex,discover,mastercard,visa',
            'expire_month'          => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
            'expire_year'           => 'required|digits:4|max:' . $max_year,
            'cvv'                   => 'required|digits_between:3,4',
            'first_name'            => 'required|string',
            'last_name'             => 'required|string'
        );
    }
}