<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            if (isset($_SESSION['shoppingCart'])) {
                  $viewbag = [
                        'user_type' => $_SESSION['user']['type_id'],
                        'user_name' => $_SESSION['user']['user_names']
                  ];
                  $shoppingCart = [];

                  foreach ($_SESSION['shoppingCart'] as $offerId => $cant) {
                        $offer = Offer::get()->where('offer_id', $offerId)->first();
                        $offer['quantity'] = $cant;
                        array_push($shoppingCart, $offer);
                  }

                  $viewbag['shopping_cart'] = $shoppingCart;

                  return view('ShoppingCart.index', $viewbag);
            } else {
                  $_SESSION['error_message'] = 'No hay productos en el carrito';

                  return to_route('Offers.index');
            }
      }
      public function add(Request $request, $id)
      {
            if (isset($request['add'])) {
                  $_SESSION['shoppingCart'][$id] = $request['quantity'];
            }
            return redirect()->back();
      }

      public function remove($id)
      {
            if (isset($_SESSION['shoppingCart'][$id])) {
                  unset($_SESSION['shoppingCart'][$id]);
            }
            return redirect()->back();
      }
      public function validatePay(Request $request)
      {
            if ($request->has('pay')) {
                  $errors = [];
                  $creditCard = [
                        'name' => $request->input('cc-name'),
                        'cardNumber' => $request->input('cc-number'),
                        'expMonth' => $request->input('cc-exp-month'),
                        'expYear' => $request->input('cc-exp-year'),
                        'cvv' => $request->input('cc-cvv')
                  ];

                  if (empty($creditCard['name'])) {
                        $errors['name'] = 'Debe ingresar un nombre';
                  }

                  if ($this->validateCreditCard($creditCard['cardNumber']) != '') {
                        $errors['cardNumber'] = $this->validateCreditCard($creditCard['cardNumber']);
                  }

                  if ($this->validateCVV($creditCard['cvv']) != '') {
                        $errors['cvv'] = $this->validateCVV($creditCard['cvv']);
                  }

                  if ($this->validateDate('20' . $creditCard['expYear'] . '-' . $creditCard['expMonth']) != '') {
                        $errors['date'] = $this->validateDate('20' . $creditCard['expYear'] . '-' . $creditCard['expMonth']);
                  }

                  if (empty($errors)) {
                        return to_route('Coupons.createCoupons');
                  } else {
                        $shoppingCart = [];

                        foreach ($_SESSION['shoppingCart'] as $offerId => $cant) {
                              $offer = Offer::get()->where('offer_id', $offerId);
                              $offer['quantity'] = $cant;
                              array_push($shoppingCart, $offer);
                        }

                        $viewbag = [
                              'creditCard' => $creditCard,
                              'errors' => $errors,
                              'user_type' => $_SESSION['user']['type_id'],
                              'user_name' => $_SESSION['user']['user_names'],
                              'shopping_cart' => $shoppingCart
                        ];

                        return to_route('ShoppingCart.index');
                  }
            } else {
                  return redirect()->back();
            }
      }
      private

      function validateCreditCard($cardNumber)
      {
            $cardNumber = str_replace(' ', '', $cardNumber);
            $cardNumber = str_replace('-', '', $cardNumber);

            if (strlen($cardNumber) != 16) {
                  return 'La tarjeta debe tener 16 dígitos';
            }
            if (!is_numeric($cardNumber)) {
                  return 'Solo puede ingresar números';
            }

            $sum = 0;
            $array = str_split($cardNumber);

            for ($i = 0; $i < 16; $i++) {
                  if ($i % 2) {
                        $sum += $array[$i];
                  } else {
                        $val = $array[$i] * 2;
                        $sum += $val < 9 ? $val : str_split($val)[0] + str_split($val)[1];
                  }
            }

            if ($sum % 10 || $sum == 0) {
                  return 'El número de tarjeta no es válido';
            }

            return '';
      }
      private function validateCVV($cvv)
      {
            if (strlen($cvv) != 3 && strlen($cvv) != 4) {
                  return 'Este campo debe tener 3 o 4 dígitos';
            }
            if (preg_match_all('/[0-9]/', $cvv) != strlen($cvv)) {
                  return 'Este campo solo puede tener números';
            }

            return '';
      }
      private function validateDate($date)
      {
            if ($date) {
                  $today = getdate();
                  $expDate = explode('-', $date);
                  $year = $expDate[0];
                  $month = $expDate[1];
                  if ($today['year'] > $year || ($today['mon'] >= $month && $today['year'] == $year)) {
                        return  'La fecha no es válida';
                  }
            }
            return '';
      }
}
