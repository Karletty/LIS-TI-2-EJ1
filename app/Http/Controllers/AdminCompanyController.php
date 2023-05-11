<?php

namespace App\Http\Controllers;

use App\Models\AdminCompany;
use App\Models\Client;
use App\Models\UsersDatum;
use Illuminate\Http\Request;

class AdminCompanyController extends Controller
{

      public function authenticate(Request $request)
      {
            $request->validate([
                  'user-email' => ['required', 'email:rfc,dns'],
                  'user-pass' => ['required']
            ]);
            $user = UsersDatum::get()->where('email', $request['user-email'])->first();

            if ($user['pass'] == hash('SHA256', $request['user-pass'])) {
                  $u = [
                        'user_id' => $user['user_id'],
                        'user_names' => $user['first_name'] . ' ' . $user['last_name'],
                        'email' => $user['email'],
                        'type_id' => $user['type_id']
                  ];

                  if ($user['type_id'] == 4) {
                        $_SESSION['user'] = $u;
                        return to_route('Offers.index');
                  }

                  if ($user['type_id'] == 2) {
                        $companyData = AdminCompany::get()->where('user_id', $user['user_id'])->first();
                        $u['company_id'] = $companyData['company_id'];
                        $_SESSION['user'] = $u;
                        return to_route('Offers.index');
                  }
                  if ($user['type_id'] == 3) {
                        $clientData = Client::get()->where('user_id', $user['user_id'])->first();
                        $u['dui'] = $clientData['dui'];
                        $_SESSION['user'] = $u;
                        return to_route('Offers.index');
                  }
            }
      }

      public function login()
      {
            return view('Admin.login');
      }

      public function changePassView()
      {
            return view('Admin.changePassword');
      }

      public function logout()
      {
            session_unset();
            return to_route('Offers.index');
      }
}
