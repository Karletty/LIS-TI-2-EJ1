<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponControllerAPI extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            return Coupon::get();
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
      public function show(string $couponId)
      {
            return Coupon::find($couponId);
      }

      public function redeemCoupon(string $couponId)
      {
            $coupon = Coupon::find($couponId);
            if ($coupon->coupon_state_id != 2) {
                  $coupon->coupon_state_id = 2;
            }
            return $coupon->save();
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, Coupon $coupon)
      {
      }

      /**
       * Remove the specified resource from storage.
       */
      public function destroy(Coupon $coupon)
      {
            //
      }
}
