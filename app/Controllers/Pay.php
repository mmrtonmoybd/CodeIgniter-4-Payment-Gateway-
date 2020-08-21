<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;
use App\Models\Payment;
class Pay extends Controller {
   protected $config;
   public function __construct() {
      helper(['form', 'url']);
      $this->config = config('Stripe');
   }
   public function index() {
      return view('payment', [
      'config' => $this->config
      ]); 
   }
   public function pay() {
      $rules = [
      'stripeToken' => 'required|string',
'amount' => 'required|numeric',
'firstName' => 'required|alpha|max_length[50]|alpha|string',
'lastName' => 'required|alpha|max_length[50]|alpha|string',
'shippingAddress1' => 'required|string',
'shippingCity' => 'required|string',
'shippingPhone' => 'required|numeric|max_length[15]',
'email' => 'required|valid_email'
      ];
      if ($this->validate($rules)) {
         $gateway = Omnipay::create('Stripe');
$gateway->setApiKey($this->config->secretKey);

   $token = $this->request->getPost('stripeToken');
   $amount = $this->request->getPost('amount');

   $card = [
   'firstName' => $this->request->getPost('firstName'),
   'lastName' => $this->request->getPost('lastName'),
   'shippingAddress1' => $this->request->getPost('address'),
   'shippingCity' => $this->request->getPost('city'),
   'shippingPhone' => $this->request->getPost('phone'),
   'email' => $this->request->getPost('email')
   ];

   $response = $gateway->purchase([
            'amount' => $amount,
            'currency' => $this->config->currency,
            'token' => $token,
            'card' => new CreditCard($card)
        ])->send();
   if ($response->isRedirect()) {
    // redirect to offsite payment gateway
    $response->redirect();
} elseif ($response->isSuccessful()) {
    // payment was successful: update database
   $arr = $response->getData();
   $model = new Payment();
   $data = [
   'amount' => $this->request->getPost('amount'),
'firstname' => $this->request->getPost('firstName'),
'lastname' => $this->request->getPost('lastName'),
'address' => $this->request->getPost('shippingAddress1'),
'city' => $this->request->getPost('shippingCity'),
'phone' => $this->request->getPost('shippingPhone'),
'email' => $this->request->getPost('email'),
'payment_id' => $arr['id']
   ];
   if ($model->save($data)) {
      return redirect()->to(route_to('pay'))->with("success", "Your payment is successful.");
   } else {
      return redirect()->back()->withInput()->with('errors', $model->errors());
   }
   
} else {
    // payment failed: display message to customer
    return redirect()->back()->withInput()->with('error', $response->getMessage());
}
      } else {
         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
      }
   }
}
?>