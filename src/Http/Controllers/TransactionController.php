<?php
namespace Bryceandy\Laravel_Pesapal\Http\Controllers;

use Bryceandy\Laravel_Pesapal\Facades\Pesapal;
use Bryceandy\Laravel_Pesapal\Pesapal\CheckStatus;
use Bryceandy\Laravel_Pesapal\Models\Transaction;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\View\View;

class TransactionController
{
    protected ValidationFactory $validation;

    /**
     * TransactionController constructor.
     *
     * @param ValidationFactory $validation
     */
    public function __construct(ValidationFactory $validation)
    {
        $this->validation = $validation;
    }

    /**
     * Stores a new transaction, post it to pesapal and
     * displays the iframe where payment options are
     *
     * @param Request $request
     * @return Factory|View
     */
    public function store(Request $request)
    {
        $this->validation->make($request->all(), [
            'amount' => '',
            'currency' => '',
            'description' => '',
            'type' => '',
            'reference' => '',
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'phone_number' => '',
        ])->validate();

        Transaction::record($request);

        $iframe_src = Pesapal::getIframeSource($request);

        return view ('laravel_pesapal::iframe', compact('iframe_src'));
    }

    public function callback()
    {
        $checkStatus = new CheckStatus();

        $pesapalMerchantReference = isset($_GET['pesapal_merchant_reference']) ?
            $_GET['pesapal_merchant_reference'] : null;

        $pesapalTrackingId = isset($_GET['pesapal_transaction_tracking_id']) ?
            $_GET['pesapal_transaction_tracking_id'] : null;

        //obtaining the payment status after a payment
        $status = $checkStatus->byTrackingIdAndMerchantRef($pesapalMerchantReference, $pesapalTrackingId);

        //display the reference and payment status on the callback page
        return view ('laravel_pesapal::callback_example', compact('pesapalMerchantReference', 'status'));
    }
}
