<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\InventoryOrder;
use App\Models\ShippingInfo;

class SslCommerzPaymentController extends Controller
{

    /* public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    } */

    public function index(Request $request)
    {
        
        $request->validate([
            "billing_phone" => 'required',
            "billing_address_1" => 'required',
            "billing_city" => 'required',
            "billing_postcode" => 'nullable',
            "billing_notes" => 'nullable',
        ]);

        UserInfo::updateOrCreate([
            'user_id' => auth()->user()->id,
        ], [
            'user_id' => auth()->user()->id,
            "phone" => $request->billing_phone,
            "address" => $request->billing_address_1,
            "city" => $request->billing_city,
            "zip" => $request->billing_postcode,
        ]);        
        
        /* cart information */
        $carts=Cart::where('user_id', auth()->user()->id)->get();
        $sub_total=0;
        foreach($carts as $cart){
            if($cart->cart_quantity > $cart->inventory->quantity){
                return back()->with('error','This number of Stock not available');
            }
            $price= (($cart->inventory->product->sale_price ?? $cart->inventory->product->price) + $cart->inventory->additional_price ?? 0) * $cart->cart_quantity;
            $sub_total+= $price;
        }
        if(Session::get('shipping_charge') && Session::get('coupon')['amount']){
            $grant_total=$sub_total + Session::get('shipping_charge')- Session::get('coupon')['amount'];
        }else{
            $grant_total= $carts->sum('sub_total')+ Session::get('shipping_charge');
        }
        

        $post_data = array();
        $post_data['total_amount'] = $grant_total;
        $post_data['currency'] = "USD";
        $post_data['tran_id'] = uniqid();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = auth()->user()->name;
        $post_data['cus_email'] = auth()->user()->email;
        $post_data['cus_add1'] = auth()->user()->user_info->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = auth()->user()->user_info->city;
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = auth()->user()->user_info->zip;
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = auth()->user()->user_info->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        /* order information */
        $insert_order=Order::create([
            'user_id'=>auth()->user()->id,
            'transaction_id'=> $post_data['tran_id'],
            'coupon_name'=> Session::get('coupon')['couponName'] ?? null,
            'coupon_amount'=> Session::get('coupon')['amount']??0,
            'shipping_charge'=> Session::get('shipping_charge'),
            'total' => $post_data['total_amount'],
            'order_note' => $request->billing_notes,
            'order_status' => 'Pending',
            'payment_status' => 'Unpaid',
        ]);
        if($insert_order){
            foreach($carts as $cart){
                InventoryOrder::create([
                    'order_id'=> $insert_order->id,
                    'inventory_id'=> $cart->inventory_id,
                    'order_quantity'=> $cart->cart_quantity,
                    'order_amount'=> ($cart->inventory->product->sale_price ?? $cart->inventory->product->price) + $cart->inventory->additional_price ?? 0,
                    'additional_amount'=> $cart->inventory->additional_price ?? null,
                ]);
            }
        }
        if($request->ship_to_different_address && $insert_order){
            $request->validate([
                "shipping_name"=>'required',
                "shipping_phone"=>'required',
                "shipping_address"=>'required',
                "shipping_address"=>'required',
                "shipping_city"=>'required',
                "shipping_postcode"=>'nullable',
                "order_comments"=>'nullable'
            ]);
            ShippingInfo::create([
                "user_id" => auth()->user()->id,
                "order_id"=>$insert_order->id,
                "name"=>$request->shipping_name,
                "phone"=>$request->shipping_phone,
                "address"=>$request->shipping_address,
                "city"=>$request->shipping_city,
                "zip"=>$request->shipping_postcode,
                "notes"=>$request->order_comments,
            ]);
        }


        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
        /* return back()->with('success', 'Insert Successful!'); */
    }



    public function success(Request $request)
    {
        echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();


        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {

                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                echo "<br >Transaction is successfully Completed";
            }
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

            echo "Transaction is successfully Completed";
        } else {

            echo "Invalid Transaction";
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn(Request $request)
    {

        if ($request->input('tran_id')) {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}