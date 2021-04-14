<?php

namespace App\Http\Controllers;

use App\Core\HelperFunction;
use App\Http\Requests\MagazinePostRequest;
use App\Http\Requests\MagazineUpdateRequest;
use App\Models\Magazine;
use App\Models\Transaction;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\ExpressCheckout;
use Storage;

class MagazineController extends Controller
{

    protected $provider;
    /**
     * constructor
     */
    public function __construct(){
        $this->provider = new ExpressCheckout();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $magazines = Magazine::where('is_active', true)->get();
        return view('magazines.index', compact('magazines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('magazines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MagazinePostRequest $request)
    {
        $cover_image_file = $request->file('cover_image');
        $pdf_file = $request->file('pdf_filename');

        $filename_cover_image = str_replace(" ", "", time() . $cover_image_file->getClientOriginalName());
        $filename_pdf = str_replace(" ", "", time() . $pdf_file->getClientOriginalName());
        $paid_filename_pdf = null;
        Storage::putFileAs(
            $filename_cover_image,
            $cover_image_file,
            $filename_cover_image
        );

        Storage::putFileAs(
            'pdf_files/' . $filename_pdf,
            $pdf_file,
            $filename_pdf
        );
        if($request->hasFile('paid_pdf_filename')){
            $paid_pdf_file = $request->file('paid_pdf_filename');
            $paid_filename_pdf = str_replace(" ", "", time() . $paid_pdf_file->getClientOriginalName());
            Storage::putFileAs(
                'paid_pdf_files/' . $paid_filename_pdf,
                $paid_pdf_file,
                $paid_filename_pdf
            );
        }

        $array = [
            'pdf_filename' => $filename_pdf,
            'cover_image' => $filename_cover_image,
            'paid_pdf_filename' => is_null($paid_filename_pdf) ? null : $paid_filename_pdf
        ];

        $validatedData = array_merge($request->validated(), $array);

        Magazine::create($validatedData);
        return redirect()->route('magazines.index')->withSuccess('Your magazine has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Magazine $magazine
     * @return \Illuminate\Http\Response
     */
    public function show(Magazine $magazine)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Magazine $magazine
     * @return \Illuminate\Http\Response
     */
    public function edit(Magazine $magazine)
    {
        return view('magazines.edit', compact('magazine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Magazine $magazine
     * @return \Illuminate\Http\Response
     */
    public function update(MagazineUpdateRequest $request, Magazine $magazine)
    {
        $cover_image_file = $request->file('cover_image');
        $pdf_file = $request->file('pdf_filename');

        $filename_cover_image = str_replace(" ", "", time() . $cover_image_file->getClientOriginalName());
        $filename_pdf = str_replace(" ", "", time() . $pdf_file->getClientOriginalName());
        $paid_filename_pdf = null;
        Storage::putFileAs(
            $filename_cover_image,
            $cover_image_file,
            $filename_cover_image
        );

        Storage::putFileAs(
            'pdf_files/' . $filename_pdf,
            $pdf_file,
            $filename_pdf
        );
        if($request->hasFile('paid_pdf_filename')){
            $paid_pdf_file = $request->file('paid_pdf_filename');
            $paid_filename_pdf = str_replace(" ", "", time() . $paid_pdf_file->getClientOriginalName());
            Storage::putFileAs(
                'paid_pdf_files/' . $paid_filename_pdf,
                $paid_pdf_file,
                $paid_filename_pdf
            );
        }

        $array = [
            'pdf_filename' => $filename_pdf,
            'cover_image' => $filename_cover_image,
            'paid_pdf_filename' => is_null($paid_filename_pdf) ? null : $paid_filename_pdf
        ];

        $validatedData = array_merge($request->validated(), $array);
        $magazine->update($validatedData);
        return redirect()->route('magazines.index')
            ->withSuccess('Magazine has successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Magazine $magazine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Magazine $magazine)
    {
        //
    }

    public function purchase(Request $request)
    {
        $magazine = Magazine::findOrFail($request->magazine_id);
        $magazine_price = $magazine->price;
        $class = FrontController::class;
        $check = new $class();

        abort_if(HelperFunction::is_purchased($magazine->id), 401);
        $stripe = Stripe::make(env('STRIPE_SECRET'));

        try {
            $charge = $stripe->charges()->create([
                'source' => $request->sourceId,
                'currency' => 'USD',
                'amount' => $magazine_price,
            ]);
            DB::beginTransaction();
            $transaction = Transaction::create([
                'user_id' => auth()->user()->id,
                'magazine_id' => $magazine->id,
                'stripe_charge_id' => $charge['id'],
                'stripe_object' => $charge['object'],
                'stripe_balance_transaction' => $charge['balance_transaction'],
                'stripe_billing_details' => $charge['billing_details'],
                'stripe_payment_details' => $charge['source'],
                'stripe_receipt_url' => json_encode($charge['receipt_url']),
                'user_email' => $charge['billing_details']['email'],
                'transaction_created_at' => $charge['created']
            ]);
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withError('Something went wrong', $e);
        }

        return redirect()->route('my-account.index')->withSuccess('You have successfully purchased new magazine, charge #' . $transaction->stripe_charge_id);
    }


    public function delete($id)
    {
        $magazine = Magazine::findOrFail($id);
        $magazine->delete();
        return redirect()->route('magazines.index')->withSuccess('Magazine has been deleted successfully.');
    }

    public function paymentPaypal(Request $request) {

        $magazine = Magazine::findOrFail($request->magazine_id);
        $magazine_price = $magazine->price;
        $data = [];
        $data['items'] = [
            [
                'name' => $magazine->title,
                'price' => $magazine_price,
                'desc' => 'Purchasing Nish Press magazine.',
                'qty' => 1
            ]
        ];

        $data['invoice_id'] = Transaction::count() + 1;
        $data['invoice_description'] = "Your order #{$data['invoice_id']} for {$magazine->title}";
        $data['return_url'] = route('paypal.success', ['magazine_id' => $magazine->id]);
        $data['cancel_url'] = route('paypal.cancel');
        $data['total'] = $magazine_price;

        $provider = $this->provider;
        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data, true);
        return redirect($response['paypal_link']);
    }
    public function paypalSuccess(Request $request) {
        $provider = $this->provider;
        $response = $provider->getExpressCheckoutDetails($request->token);
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

            $transaction = Transaction::create([
                'user_id' => auth()->user()->id,
                'magazine_id' => $request->magazine_id,
                'stripe_charge_id' => $response['TOKEN'],
                'stripe_object' => 'paypal',
                'stripe_balance_transaction' => 'paypal',
                'stripe_billing_details' => [
                    'EMAIL' => $response['EMAIL'],
                    'PAYERID' => $response['PAYERID'],
                    'FIRSTNAME' => $response['FIRSTNAME'],
                    'LASTNAME' => $response['LASTNAME'],
                    'COUNTRYCODE' => $response['COUNTRYCODE'],
                    'ACK' => $response['ACK'],
                    'CORRELATIONID' => $response['CORRELATIONID'],
                ],
                'stripe_payment_details' => [
                    'EMAIL' => $response['EMAIL'],
                    'PAYERID' => $response['PAYERID'],
                    'FIRSTNAME' => $response['FIRSTNAME'],
                    'LASTNAME' => $response['LASTNAME'],
                    'COUNTRYCODE' => $response['COUNTRYCODE'],
                    'ACK' => $response['ACK'],
                    'CORRELATIONID' => $response['CORRELATIONID'],
                ],
                'stripe_receipt_url' => "nish.press/paypal",
                'user_email' => $response['EMAIL'],
                'transaction_created_at' => $response['TIMESTAMP']
            ]);

            return redirect()->route('my-account.index')->withSuccess('You have successfully purchased new magazine, charge #' . $transaction->stripe_charge_id);

        }
        dd('Something is wrong.');
    }
    public function paypalCancel() {
        return "order cancel paypal";
    }
}
