<?php
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 8/11/15
 * Time: 10:54 AM
 *
 * https://developer.paypal.com/webapps/developer/docs/api/
 */

namespace App\Helpers;

use Config;
use Anouar\Paypalpayment\Facades\PaypalPayment as Paypalpayment;

class Paypal extends Payment
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


    public function createPaymentByPaypal()
    {
        // ### Payer
        // A resource representing a Payer that funds a payment
        // For paypal account payments, set payment method
        // to 'paypal'.
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

        // ### Itemized information
        // (Optional) Lets you specify item wise
        // information
        $item1 = Paypalpayment::item();
        $item1->setName('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("123123")// Similar to `item_number` in Classic API
            ->setPrice(7.5);

        $item2 = Paypalpayment::item();
        $item2->setName('Granola bars')
            ->setCurrency('USD')
            ->setQuantity(5)
            ->setSku("321321")// Similar to `item_number` in Classic API
            ->setPrice(2);

        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item1, $item2));

        // ### Additional payment details
        // Use this optional field to set additional
        // payment information such as tax, shipping
        // charges etc.
        $details = Paypalpayment::details();
        $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal(17.50);

        // ### Amount
        // Lets you specify a payment amount.
        // You can also specify additional details
        // such as shipping, tax.
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
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
        $baseUrl = getBaseUrl();
        $redirectUrls = Paypalpayment::redirectUrls();
        $redirectUrls
            ->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
            ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent set to 'sale'
        $payment = Paypalpayment::payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
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