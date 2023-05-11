<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;


class CouponsController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            //
      }

      /**
       * Show the form for creating a new resource.
       */
      public function create()
      {
            //
      }

      public function createCoupons()
      {
            if (isset($_SESSION['shoppingCart']) && isset($_SESSION['user']) && $_SESSION['user']['type_id'] == 3) {
                  $shoppingCart = [];
                  foreach ($_SESSION['shoppingCart'] as $offerId => $cant) {
                        $offer = json_decode(json_encode(DB::table('offers')
                              ->select('offers.*', 'companies.company_name')
                              ->where('offer_id', $offerId)
                              ->join('companies', 'offers.company_id', '=', 'companies.company_id')
                              ->first()), true);
                        $offer['quantity'] = $cant;
                        var_dump($offer);
                        array_push($shoppingCart, $offer);
                  }
                  foreach ($shoppingCart as $offer) {
                        for ($i = 0; $i < $offer['quantity']; $i++) {
                              $coupon = [
                                    'coupon_id' => $offer['company_id'] . '-' . substr(str_repeat(0, 7) . rand(0, 9999999), -7),
                                    'client_dui' => $_SESSION['user']['dui'],
                                    'offer_id' => $offer['offer_id'],
                                    'coupon_state_id' => 1
                              ];
                              $clientName = $_SESSION['user']['user_names'];
                              Coupon::insert($coupon);

                              $dompdf = new Dompdf();
                              ob_start();
                              require public_path('mail/couponTemplate.php');
                              $html = ob_get_clean();
                              $dompdf->loadHtml($html);
                              $basePath = public_path("./pdfs/");
                              $fileName =  $coupon['coupon_id'] . '.pdf';
                              $filePath = $basePath . $fileName;

                              $dompdf->render();
                              $outPut = $dompdf->output();

                              file_put_contents($filePath, $outPut);
                              unset($_SESSION['shoppingCart']);
                              $_SESSION['success_message'] = "El pago se ha realizado con éxito";
                        }
                        DB::update('UPDATE offers SET available_qty = :available_qty WHERE offer_id=:offer_id', ['available_qty' => $offer['available_qty'] - $offer['quantity'], 'offer_id' => $offer['offer_id']]);;
                  }
                  return to_route('Offers.index');
            }
            else {
                  return redirect()->back();
            }
      }

      /**
       * Store a newly created resource in storage.
       */
      public function store(Request $request)
      {
            //
      }

      /**
       * Display the specified resource.
       */
      public function show(Coupon $coupon)
      {
            //
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit(Coupon $coupon)
      {
            //
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, Coupon $coupon)
      {
            //
      }

      /**
       * Remove the specified resource from storage.
       */
      public function destroy(Coupon $coupon)
      {
            //
      }
}
