<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 4) {
                  $clients = DB::table('clients as c')
                        ->join('users_data as u', 'c.user_id', '=', 'u.user_id')
                        ->join('user_types as t', 'u.type_id', '=', 't.type_id')
                        ->select('c.dui', 'c.phone', 'c.address', 'c.token', 'c.verified', 'u.first_name', 'u.last_name', 'u.email', 't.type_name')
                        ->get();
                  $coupons = DB::table('coupons as c')
                        ->select('c.coupon_id', 'c.client_dui', 'c.offer_id', 's.state_name', 'o.title', 'o.deadline_date')
                        ->join('coupon_states as s', 'c.coupon_state_id', '=', 's.coupon_state_id')
                        ->join('offers as o', 'o.offer_id', '=', 'c.offer_id')
                        ->orderBy('c.coupon_id')
                        ->get();
                  foreach ($coupons as $coupon) {
                        [$year, $month, $day] = explode('-', $coupon->deadline_date);
                        $today = Carbon::now();
                        if ($coupon->state_name == 'No Canjeado') {
                              if (intval($year) < intval($today->year)) {
                                    $coupon->state_name = 'Vencido';
                              }
                              if (intval($year) == intval($today->year) && intval($month) < intval($today->month)) {
                                    $coupon->state_name = 'Vencido';
                              }
                              if (intval($year) == intval($today->year) && intval($month) == intval($today->month) && intval($day) < intval($today->day)) {
                                    $coupon->state_name = 'Vencido';
                              }
                        }
                  }
                  return view('Clients.admin', ['clients' => $clients, 'coupons' => $coupons]);
            }
            return to_route('Offers.index');
      }

      public function signup()
      {
      }

      /**
       * Show the form for creating a new resource.
       */
      public function create()
      {
            //
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
      public function show(Client $client)
      {
            //
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit(Client $client)
      {
            //
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, Client $client)
      {
            //
      }

      /**
       * Remove the specified resource from storage.
       */
      public function destroy(Client $client)
      {
            //
      }
}
