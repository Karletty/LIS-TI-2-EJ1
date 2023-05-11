<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use App\Models\OfferState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class OffersController extends Controller
{

      private function formatDate($dateString)
      {
            [$year, $month, $day] = explode('-', $dateString);
            return ($day . '-' . $month . '-' . $year);
      }
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            $categories = Category::get();

            if (isset($_SESSION) && isset($_SESSION['user']) && $_SESSION['user']['type_id'] == 2) {
                  DB::table('offers as o')
                        ->join('offer_states as s', 'o.offer_state_id', '=', 's.offer_state_id')
                        ->join('companies as c', 'o.company_id', '=', 'c.company_id')
                        ->select(
                              'o.offer_id',
                              'o.title',
                              'o.limit_qty',
                              'o.offer_description',
                              'o.details',
                              'o.start_date',
                              'o.end_date',
                              'o.original_price',
                              'o.offer_price',
                              'c.company_name',
                              's.offer_state_description',
                              'o.justification',
                              'o.deadline_date',
                              'o.available_qty',
                              'c.commission_percentage'
                        )
                        ->where('o.company_id', '=', $_SESSION['user']['company_id'])
                        ->orderBy('o.offer_id')
                        ->get();
                  $view = 'companyAdmin';
            }
            if (!isset($_SESSION['user'])) {
                  $view = 'public';
            }
            if (!isset($_SESSION['user']) || $_SESSION['user']['type_id'] != 1) {
                  $offers = DB::table('offers as o')
                        ->select(
                              'o.offer_id',
                              'o.title',
                              'o.limit_qty',
                              'o.offer_description',
                              'o.details',
                              'o.start_date',
                              'o.end_date',
                              'o.original_price',
                              'o.offer_price',
                              'co.company_name',
                              's.offer_state_description',
                              'o.justification',
                              'o.deadline_date',
                              'o.available_qty',
                              'ca.category_name',
                              'co.company_id',
                              'co.commission_percentage'
                        )
                        ->join('offer_states as s', 'o.offer_state_id', '=', 's.offer_state_id')
                        ->join('companies as co', 'o.company_id', '=', 'co.company_id')
                        ->join('categories as ca', 'co.category_id', '=', 'ca.category_id')
                        ->orderBy('o.offer_id')
                        ->get();
                  $view = 'admin';
            }
            if ($_SESSION['user']['type_id'] == 4) {
                  $view = 'admin';
            } else if ($_SESSION['user']['type_id'] == 3) {
                  $view = 'client';
            }

            $offers = json_decode(json_encode($offers), true);
            if (!isset($_SESSION['user']) || $_SESSION['user']['type_id'] == 3) {
                  $offers = array_filter($offers, function ($v, $k) {
                        return $v['available_qty'] > 0;
                  }, ARRAY_FILTER_USE_BOTH);

                  $offers = array_filter($offers, function ($v, $k) {
                        return $v['offer_state_description'] == 'Aprobada';
                  }, ARRAY_FILTER_USE_BOTH);

                  $offers = array_filter($offers, function ($v, $k) {
                        [$todayDay, $todayMonth, $todayYear] = explode('/', date('d/m/Y'));
                        [$day, $month, $year] = explode('-', $this->formatDate($v['deadline_date']));
                        return !($year < $todayYear || (($year == $todayYear) && ($month < $todayMonth)) || (($year == $todayYear) && ($month == $todayMonth) && ($day < $todayDay)));
                  }, ARRAY_FILTER_USE_BOTH);

                  if (isset($_SESSION['shoppingCart'])) {
                        $viewbag['shopping_cart'] = $_SESSION['shoppingCart'];
                  }
            }
            if (isset($_GET['filter'])) {
                  $filters = [];
                  if ($_GET['category'] != 'all') {
                        $offers = array_filter($offers, function ($v, $k) {
                              return $v['category_name'] == $_GET['category'];
                        }, ARRAY_FILTER_USE_BOTH);
                        $filters['category'] = $_GET['category'];
                  }
                  if (!empty($_GET['min-price']) && is_numeric($_GET['min-price'])) {
                        $offers = array_filter($offers, function ($v, $k) {
                              return $v['offer_price'] >= $_GET['min-price'];
                        }, ARRAY_FILTER_USE_BOTH);
                        $filters['min-price'] = $_GET['min-price'];
                  }
                  if (!empty($_GET['max-price']) && is_numeric($_GET['max-price'])) {
                        $offers = array_filter($offers, function ($v, $k) {
                              return $v['offer_price'] <= $_GET['max-price'];
                        }, ARRAY_FILTER_USE_BOTH);
                        $filters['max-price'] = $_GET['max-price'];
                  }
                  $viewbag['filters'] = $filters;
            }
            if (!isset($_SESSION['user']) || $_SESSION['user']['type_id'] != 1) {
                  $viewbag['user_name'] = $_SESSION['user']['user_names'];
                  $categories = $categories->toArray();
                  $viewbag['offers'] = $offers;
                  $viewbag['categories'] = $categories;
                  return view('Offers.' . $view, $viewbag);
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
      public function show($offer)
      {
            if (!isset($_SESSION['user']) || $_SESSION['user']['type_id'] != 4) {
                  $o = Offer::get()->where('offer_id', $offer)->first();
                  $viewbag['offer'] = $o;


                  if (isset($_SESSION['user'])) {
                        $viewbag['user_type'] = $_SESSION['user']['type_id'];
                        $viewbag['user_name'] = $_SESSION['user']['user_names'];

                        if ($_SESSION['user']['type_id'] == 3) {
                              $viewbag['template'] = 'layout.templateClient';
                        }
                  } else {
                        $viewbag['template'] = 'layout.templatePublic';
                  }

                  if (isset($_SESSION['shoppingCart'])) {
                        $viewbag['shopping_cart'] = $_SESSION['shoppingCart'];
                  }

                  return view('Offers.details', $viewbag);
            }
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit($offer)
      {
            if ($_SESSION['user']['type_id'] == 4) {
                  $offerStates = OfferState::get();
                  $o = Offer::get()->where('offer_id', $offer)->first();
                  return view('Offers.editState', ['user' => $_SESSION['user'], 'offer' => $o, 'offerStates' => $offerStates]);
            }
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, $offer)
      {
            if ($_SESSION['user']['type_id'] == 4) {
                  $request->validate([
                        'offer_state_id' => ['required']
                  ]);
                  $o = Offer::get()->where('offer_id', $offer)->first();

                  $o->justification = $request['justification'];
                  $o->offer_state_id = $request['offer_state_id'];
                  $o->save();

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
