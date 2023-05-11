<?php

namespace App\Http\Controllers;

use App\Models\AdminCompany;
use App\Models\Category;
use App\Models\Company;
use App\Models\Coupon;
use App\Models\Employee;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            if ($_SESSION['user']['type_id'] == '4') {
                  $categories = Category::get();
                  return view('Categories.admin', ['user' => $_SESSION['user'], 'categories' => $categories]);
            }
      }

      /**
       * Show the form for creating a new resource.
       */
      public function create()
      {
            if ($_SESSION['user']['type_id'] == '4') {
                  return view('Categories.create', ['user' => $_SESSION['user']]);
            }
            //
      }

      /**
       * Store a newly created resource in storage.
       */
      public function store(Request $request)
      {
            $request->validate([
                  'category_name' => 'required'
            ]);
            $c = new Category();
            $c['category_name'] = $request['category_name'];
            $c->save();
            return to_route('Categories.index');
      }

      /**
       * Display the specified resource.
       */
      public function show(Category $category)
      {
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit($category)
      {
            if ($_SESSION['user']['type_id'] == '4') {
                  $c = Category::where('category_id', $category)->get()->first();
                  return view('Categories.edit', ['user' => $_SESSION['user'], 'category' => $c]);
            }
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, $category)
      {
            $request->validate([
                  'category_name' => 'required'
            ]);
            $c = Category::where('category_id', $category)->get()->first();
            $c['category_name'] = $request['category_name'];
            $c->save();
            return to_route('Categories.index');
      }

      /**
       * Remove the specified resource from storage.
       */
      public function destroy($category)
      {
            Category::where('category_id', $category)->delete();
            // return to_route('Categories.index');
      }
}
