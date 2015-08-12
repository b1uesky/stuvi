<?php
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 8/10/15
 * Time: 5:33 PM
 */

use Illuminate\Support\Facades\Config;

class PaypalTest extends TestCase
{

    public function testCredentials()
    {
        $flatConfig = array_dot(Config::get('paypal_payment')); // Flatten the array with dots

        $apiContext = Paypalpayment::ApiContext(
            Config::get('paypal_payment.Account.ClientId'),
            Config::get('paypal_payment.Account.ClientSecret')
        );

        $apiContext->setConfig($flatConfig);
    }

    public function testCreatePaymentByPalpal()
    {
        $flatConfig = array_dot(Config::get('paypal_payment')); // Flatten the array with dots

        $apiContext = Paypalpayment::ApiContext(
            Config::get('paypal_payment.Account.ClientId'),
            Config::get('paypal_payment.Account.ClientSecret')
        );

        $apiContext->setConfig($flatConfig);

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
        $baseUrl = \Illuminate\Support\Facades\URL::to('/');
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

        return $payment;
    }

    public function testSinglePayout()
    {
        $flatConfig = array_dot(Config::get('paypal_payment')); // Flatten the array with dots

        $apiContext = Paypalpayment::ApiContext(
            Config::get('paypal_payment.Account.ClientId'),
            Config::get('paypal_payment.Account.ClientSecret')
        );

        $apiContext->setConfig($flatConfig);

        // Create a new instance of Payout object
        $payouts = new \PayPal\Api\Payout();

        // This is how our body should look like:
        /*
         * {
                    "sender_batch_header":{
                        "sender_batch_id":"2014021801",
                        "email_subject":"You have a Payout!"
                    },
                    "items":[
                        {
                            "recipient_type":"EMAIL",
                            "amount":{
                                "value":"1.0",
                                "currency":"USD"
                            },
                            "note":"Thanks for your patronage!",
                            "sender_item_id":"2014031400023",
                            "receiver":"shirt-supplier-one@mail.com"
                        }
                    ]
                }
         */
        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

        // ### NOTE:
        // You can prevent duplicate batches from being processed. If you specify a `sender_batch_id` that was used in the last 30 days, the batch will not be processed. For items, you can specify a `sender_item_id`. If the value for the `sender_item_id` is a duplicate of a payout item that was processed in the last 30 days, the item will not be processed.
        // #### Batch Header Instance
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");

        // #### Sender Item
        // Please note that if you are using single payout with sync mode, you can only pass one Item in the request
        $senderItem = new \PayPal\Api\PayoutItem();
        $senderItem->setRecipientType('Email')
            ->setNote('Thanks for your patronage!')
            ->setReceiver('seller@stuvi.com')
            ->setSenderItemId("2014031400023")
            ->setAmount(new \PayPal\Api\Currency('{
                        "value":"1.0",
                        "currency":"USD"
                    }'));
        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem);

        // For Sample Purposes Only.
        $request = clone $payouts;

        // ### Create Payout
        try {
            $output = $payouts->createSynchronous($apiContext);
        } catch (Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
//            ResultPrinter::printError("Created Single Synchronous Payout", "Payout", null, $request, $ex);
            exit(1);
        }
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
//        ResultPrinter::printResult("Created Single Synchronous Payout", "Payout", $output->getBatchHeader()->getPayoutBatchId(), $request, $output);
        return $output;
    }

}