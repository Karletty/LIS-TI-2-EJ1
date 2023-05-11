<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\OfferState;
use Illuminate\Http\Request;

class OffersController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            if ($_SESSION['user']['type_id'] == '2') {
                  $companyId = $_SESSION['user']['company_id'];
                  $offers = Offer::with('Company', 'OfferState')->get()->where('company_id', $companyId);
                  return view('Offers.companyAdmin', ['user' => $_SESSION['user'], 'offers' => $offers]);
            } else if ($_SESSION['user']['type_id'] == '4') {
                  $offers = Offer::with('Company', 'offer_state')->get();
                  return view('Offers.admin', ['user' => $_SESSION['user'], 'offers' => $offers]);
            }
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
      public function show(Offer $offer)
      {
            //
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit($offer)
      {
            if ($_SESSION['user']['type_id'] == '4') {
                  $offerStates = OfferState::get();
                  $o = Offer::with('Company', 'offer_state')->where('offer_id', $offer)->first();
                  return view('Offers.editState', ['user' => $_SESSION['user'], 'offer' => $o, 'offerStates' => $offerStates]);
            }
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, Offer $offer)
      {
            $request->validate([
                  'offer_state_id' => ['required']
            ]);
            if ($request['offer_state_id']) {
                  return to_route('Offers.justificate');
            }

            $offer->offer_state_id = $request['offer_state_id'];
            $resp = $offer->save();

            if ($resp) {
                  return to_route('Offers.index');
            }
      }

      /**
       * Remove the specified resource from storage.
       */
      public function destroy(Offer $offer)
      {
            //
      }
}
