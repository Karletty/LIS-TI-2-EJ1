<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use App\Models\OfferState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
                  $offers = DB::table('offers as o')
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
                              's.offer_state_id',
                              'o.justification',
                              'o.deadline_date',
                              'o.available_qty',
                              'c.commission_percentage'
                        )
                        ->where('o.company_id', '=', $_SESSION['user']['company_id'])
                        ->orderBy('o.offer_id')
                        ->get();
            } else if (!isset($_SESSION['user']) || $_SESSION['user']['type_id'] != 1) {
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
                              's.offer_state_id',
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
            }
            if (!isset($_SESSION['user'])) {
                  $view = 'public';
            }
            if ($_SESSION['user']['type_id'] == 4) {
                  $view = 'admin';
            } else if ($_SESSION['user']['type_id'] == 3) {
                  $view = 'client';
            } else if ($_SESSION['user']['type_id'] == 2) {
                  $view = 'companyAdmin';
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
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 2) {
                  return view('Offers.create');
            }
            return view('Offers.index');
      }

      /**
       * Store a newly created resource in storage.
       */
      public function store(Request $request)
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 2) {
                  $validator = Validator::make($request->all(), [
                        'title' => 'required|max:100',
                        'limit_qty' => 'required|integer',
                        'offer_description' => 'required',
                        'start_date' => 'required|date',
                        'end_date' => 'required|date|after:start_date',
                        'original_price' => 'required|numeric',
                        'offer_price' => 'required|numeric',
                        'deadline_date' => 'required|date|before:end_date',
                        'available_qty' => 'required|integer',
                  ]);
                  $offer = Offer::create([
                        'title' => $request->input('title'),
                        'limit_qty' => $request->input('limit_qty'),
                        'offer_description' => $request->input('offer_description'),
                        'details' => $request->input('details'),
                        'start_date' => $request->input('start_date'),
                        'end_date' => $request->input('end_date'),
                        'original_price' => $request->input('original_price'),
                        'offer_state_id' => 1,
                        'offer_price' => $request->input('offer_price'),
                        'deadline_date' => $request->input('deadline_date'),
                        'available_qty' => $request->input('limit_qty'),
                        'company_id' => $_SESSION['user']['company_id']
                  ]);
            }
            return to_route('Offers.index');
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
            return to_route('Offers.index');
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit($offer)
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 4) {
                  $offerStates = OfferState::get();
                  $o = Offer::get()->where('offer_id', $offer)->first();
                  if ($o->offer_state_id == 1) {
                        return view('Offers.editState', ['user' => $_SESSION['user'], 'offer' => $o, 'offerStates' => $offerStates]);
                  }
            }
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 2) {
                  $o = Offer::get()->where('offer_id', $offer)->first();
                  if ($o->offer_state_id == 3) {
                        return view('Offers.edit', ['user' => $_SESSION['user'], 'offer' => $o]);
                  }
            }
            return to_route('Offers.index');
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, $offer)
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 4) {
                  $request->validate([
                        'offer_state' => ['required '],
                        'justification' => 'required_if:offer_state,3'
                  ]);

                  $o = Offer::get()->where('offer_id', $offer)->first();
                  if ($o->offer_state_id == 1) {
                        $o->justification = $request['justification'];
                        $o->offer_state_id = $request['offer_state'];
                        $o->save();
                  }
            }
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 2) {
                  $validator = Validator::make($request->all(), [
                        'title' => 'required|max:100',
                        'limit_qty' => 'required|integer',
                        'offer_description' => 'required',
                        'start_date' => 'required|date',
                        'end_date' => 'required|date|after:start_date',
                        'original_price' => 'required|numeric',
                        'offer_price' => 'required|numeric',
                        'deadline_date' => 'required|date|before:end_date',
                        'available_qty' => 'required|integer',
                  ]);
                  $offer = Offer::where('offer_id', $offer)->first();
                  $offer->title = $request->input('title');
                  $offer->offer_state_id = 1;
                  $offer->limit_qty = $request->input('limit_qty');
                  $offer->offer_description = $request->input('offer_description');
                  $offer->details = $request->input('details');
                  $offer->start_date = $request->input('start_date');
                  $offer->end_date = $request->input('end_date');
                  $offer->original_price = $request->input('original_price');
                  $offer->offer_price = $request->input('offer_price');
                  $offer->deadline_date = $request->input('deadline_date');
                  $offer->available_qty = $request->input('limit_qty');
                  $offer->save();
            }
            return to_route('Offers.index');
      }

      /**
       * Remove the specified resource from storage.
       */
      public function destroy(Offer $offer)
      {
            //
      }
}
