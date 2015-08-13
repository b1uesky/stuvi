<?php
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 8/11/15
 * Time: 10:54 AM
 *
 * https://developer.paypal.com/webapps/developer/docs/api/
 * https://github.com/paypal/PayPal-PHP-SDK
 */

namespace App\Helpers;

use Config;
use Anouar\Paypalpayment\Facades\PaypalPayment as Paypalpayment;
use PayPal\Api\Payment;
use PayPal\Api\Payout;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\PayoutItem;
use PayPal\Api\Currency;

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
        $this->api_context = Paypalpayment::ApiContext($this->client_id, $this->client_secret);

        $flatConfig = array_dot(Config::get('paypal_payment')); // Flatten the array with dots
        $this->api_context->setConfig($flatConfig);
    }

    /**
     * Create Paypal payment by credit card.
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
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr = Paypalpayment::address();
        $addr->setLine1($address['address_line1']);
        $addr->setLine2($address['address_line2']);
        $addr->setCity($address['city']);
        $addr->setState($address['state_a2']);
        $addr->setPostalCode($address['zip']);
        $addr->setCountryCode($address['country_a2']);
        $addr->setPhone($address['phone_number']);

        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType($credit_card['type'])
            ->setNumber($credit_card['number'])
            ->setExpireMonth($credit_card['expire_month'])
            ->setExpireYear($credit_card['expire_year'])
            ->setCvv2($credit_card['cvv'])
            ->setFirstName($credit_card['first_name'])
            ->setLastName($credit_card['last_name']);

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::fundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        $items_paypal = array();

        foreach ($items as $item)
        {
            $item_paypal = Paypalpayment::item();
            $item_paypal->setName($item['name'])
                ->setDescription($item['description'])
                ->setCurrency($item['currency'])
                ->setQuantity($item['quantity'])
                ->setPrice($item['price']);

            array_push($items_paypal, $item_paypal);
        }

        $itemList = Paypalpayment::itemList();
        $itemList->setItems($items_paypal);

        $details = Paypalpayment::details();
        $details->setShipping($shipping)
            ->setTax($tax)
            ->setSubtotal($subtotal);

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
            ->setTotal($total)
            ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types
        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'
        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->api_context);
        } catch (\PPConnectionException $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        return $payment;
    }


    /**
     * Create Paypal payment by Paypal account.
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
        // ### Payer
        // A resource representing a Payer that funds a payment
        // For paypal account payments, set payment method
        // to 'paypal'.
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

        $items_paypal = array();

        foreach ($items as $item)
        {
            $item_paypal = Paypalpayment::item();
            $item_paypal->setName($item['name'])
                ->setDescription($item['description'])
                ->setCurrency($item['currency'])
                ->setQuantity($item['quantity'])
                ->setPrice($item['price']);

            array_push($items_paypal, $item_paypal);
        }

        $itemList = Paypalpayment::itemList();
        $itemList->setItems($items_paypal);

        // ### Additional payment details
        // Use this optional field to set additional
        // payment information such as tax, shipping
        // charges etc.
        $details = Paypalpayment::details();
        $details->setShipping($shipping)
            ->setTax($tax)
            ->setSubtotal($subtotal);

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
            ->setTotal($total)
            ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it.
        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Redirect urls
        // Set the urls that the buyer must be redirected to after
        // payment approval/ cancellation.
        $redirectUrls = Paypalpayment::redirectUrls();
        $redirectUrls
            ->setReturnUrl(url('order/executePayment?shipping_address_id=' . $shipping_address_id))
            ->setCancelUrl(url('order/create'));

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent set to 'sale'
        $payment = Paypalpayment::payment();
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
        // ### Get redirect url
        // The API response provides the url that you must redirect
        // the buyer to. Retrieve the url from the $payment->getApprovalLink()
        // method

        return $payment;
    }

    /**
     * Execute payment.
     *
     * @param $payment_id
     * @param $payer_id
     * @return Payment|string
     */
    public function executePayment($payment_id, $payer_id)
    {
        // Get the payment Object by passing paymentId
        // payment id was previously stored in session in
        // CreatePaymentUsingPayPal.php
        $payment =  Payment::get($payment_id, $this->api_context);

        // ### Payment Execute
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = Paypalpayment::paymentExecution();
        $execution->setPayerId($payer_id);

        try {
            // Execute the payment
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
        // Create a new instance of Payout object
        $payouts = new Payout();

        $senderBatchHeader = new PayoutSenderBatchHeader();

        // ### NOTE:
        // You can prevent duplicate batches from being processed. If you specify a `sender_batch_id` that was used in the last 30 days, the batch will not be processed. For items, you can specify a `sender_item_id`. If the value for the `sender_item_id` is a duplicate of a payout item that was processed in the last 30 days, the item will not be processed.
        // #### Batch Header Instance
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");

        $amount = new Currency();
        $amount->setCurrency($item['currency'])
            ->setValue($item['value']);

        // #### Sender Item
        // Please note that if you are using single payout with sync mode, you can only pass one Item in the request
        $senderItem = new PayoutItem();
        $senderItem->setRecipientType($item['recipient_type'])
            ->setNote($item['note'])
            ->setReceiver($item['receiver'])
            ->setSenderItemId($item['item_id'])
            ->setAmount($amount);
//        $senderItem->setRecipientType('Email')
//            ->setNote('Thanks for your patronage!')
//            ->setReceiver('seller@stuvi.com')
//            ->setSenderItemId("2014031400023")
//            ->setAmount(new Currency('{
//                        "value":"1.0",
//                        "currency":"USD"
//                    }'));

        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem);

        // ### Create Payout
        try {
            $output = $payouts->createSynchronous($this->api_context);
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