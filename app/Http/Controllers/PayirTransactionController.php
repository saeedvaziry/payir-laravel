<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class PayirTransactionController extends Controller
{
  public function showForm()
  {
    return view('payir-form');
  }

  public function submitForm(Request $request)
  {
    $rules = [
      'amount' => 'required|numeric'
    ];
    $this->validate($request, $rules);

    if($request->amount >= 1000) {
      $response = $this->getToken($request->amount);
      if(isset($response->status) && $response->status == '1') {
        $transaction = Transaction::create([
          'amount' => $request->amount,
          'token'  => $response->token
        ]);

        return redirect('https://pay.ir/pg/' . $response->token);
      }

      return redirect()->back()
        ->with('alert', 'danger')
        ->with('message', $response->errorMessage);
    }

    return redirect()->back()
      ->with('alert', 'danger')
      ->with('message', 'Amount must bigger than 1000 IRR');
  }

  public function callback(Request $request)
  {
    if($request->status && $request->status == '1' && $request->token) {
      $transaction = Transaction::where('token', '=', $request->token)
        ->where('status', '!=', 1)
        ->where('verify_status', '!=', 1)
        ->first();

      if($transaction) {
        $response = $this->verify($transaction->token);
        if(isset($response->status) && $response->status == '1') {
          $transaction->update([
            'transaction_id' => $response->transId,
            'card_number'    => $response->cardNumber,
            'status'         => 1,
            'verify_status'  => 1
          ]);

          // serve your service to customer
          
          return view('payir-receipt')
            ->with('message', 'Transaction Success')
            ->with('transaction', $transaction);
        }
      }
    }

    return view('payir-receipt')
      ->with('message', 'Transaction Failed');
  }

  private function getToken($amount, $mobile = null, $factorNumber = null, $description = null) {
    $response = $this->curlPost('https://pay.ir/pg/send', [
      'api'          => env('PAYIR_API_KEY', 'YOUR-API-KEY'),
      'amount'       => $amount,
      'redirect'     => url('/payir/callback'),
      'mobile'       => $mobile,
      'factorNumber' => $factorNumber,
      'description'  => $description,
    ]);

    return json_decode($response);
  }
  
  private function verify($token) {
    $response = $this->curlPost('https://pay.ir/pg/verify', [
      'api' 	=> env('PAYIR_API_KEY', 'YOUR-API-KEY'),
      'token' => $token,
    ]);

    return json_decode($response);
  }
  
  private function curlPost($url, $params)
  {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
      ]);
      $res = curl_exec($ch);
      curl_close($ch);
  
      return $res;
  }
}
