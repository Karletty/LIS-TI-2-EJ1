<?php

namespace App\Http\Controllers;

use App\Models\AdminCompany;
use App\Models\Category;
use App\Models\Company;
use App\Models\UsersDatum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CompaniesController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 4) {
                  $companies = DB::table('companies')
                        ->select('companies.*', 'categories.category_name')
                        ->join('categories', 'companies.category_id', '=', 'categories.category_id')->orderBy('companies.company_id', 'asc')
                        ->get();
                  foreach ($companies as $company) {
                        $user = DB::table('admin_companies')
                              ->select('users_data.*', 'admin_companies.*')
                              ->join('users_data', 'users_data.user_id', '=', 'admin_companies.user_id')
                              ->where('admin_companies.company_id', $company->company_id)
                              ->first();
                        $company->email = $user->email;
                  }
                  return view('Companies.index', ['companies' => $companies]);
            }
            return to_route('Offers.index');
      }

      /**
       * Show the form for creating a new resource.
       */
      public function create()
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 4) {
                  $categories = Category::get();
                  return view('Companies.create', ['categories' => $categories]);
            }
            return to_route('Offers.index');
      }

      /**
       * Store a newly created resource in storage.
       */
      public function store(Request $request)
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 4) {
                  $rules = [
                        'company_id' => 'required|regex:/^EMP\d{3}$/',
                        'company_name' => 'required',
                        'address' => 'required',
                        'phone' => 'required',
                        'email' => 'required|email',
                        'contact_name' => 'required',
                        'commission_percentage' => 'required|numeric',
                        'category' => 'required',
                  ];

                  $messages = [
                        'company_id.required' => 'El código de empresa es obligatorio',
                        'company_id.regex' => 'El código de empresa debe tener el formato EMP###',
                        'company_name.required' => 'El nombre de la empresa es obligatorio',
                        'address.required' => 'La dirección es obligatoria',
                        'phone.required' => 'El teléfono de contacto es obligatorio',
                        'email.required' => 'El correo electrónico es obligatorio',
                        'email.email' => 'El correo electrónico debe ser válido',
                        'contact_name.required' => 'El nombre del contacto es requerido',
                        'commission_percentage.required' => 'El porcentaje de comisión es obligatorio',
                        'commission_percentage.numeric' => 'El porcentaje de comisión debe ser numérico',
                        'category.required' => 'La categoría es obligatoria',
                  ];

                  $validator = Validator::make($request->all(), $rules, $messages);
                  if (!$validator->fails()) {
                        $pass = Str::random(8);
                        $company = Company::create([
                              'company_id' => $request->input('company_id'),
                              'company_name' => $request->input('company_name'),
                              'address' => $request->input('address'),
                              'contact_name' => $request->input('contact_name'),
                              'phone' => $request->input('phone'),
                              'commission_percentage' => $request->input('commission_percentage'),
                              'category_id' => $request->input('category')
                        ]);
                        $user = UsersDatum::create([
                              'first_name' => 'Administrador de',
                              'last_name' => $company->company_name,
                              'pass' => hash('SHA256', $pass),
                              'email' => $request['email'],
                              'type_id' => 2
                        ]);
                        $admin = AdminCompany::create([
                              'company_id' => $request['company_id'],
                              'user_id' => $user['user_id']
                        ]);

                        try {
                              $mail = new PHPMailer(true);
                              $mail->IsSMTP();
                              $mail->CharSet = 'utf-8';
                              $mail->SMTPDebug = 0;
                              $mail->SMTPSecure = 'tls';
                              $mail->SMTPAuth = 'true';
                              $mail->Host = "smtp.gmail.com";
                              $mail->Port = 587;
                              $mail->Username = 'lacuponerakarle@gmail.com';
                              $mail->Password = 'hbvykdlvrhcbgmqg';
                              $mail->SetFrom('lacuponerakarle@gmail.com', 'La Cuponera');
                              $mail->AddAddress($request['email'], 'Someone Else');
                              $mail->Subject = '¡Bienvenid@ a la cuponera!';
                              $mail->AddEmbeddedImage(public_path('img/banner.png'), 'imagen');
                              $mail->Body = '<img src="cid:imagen" height="auto" width="800px"><br><br><h3>Su contraseña temporal es: ' . $pass . '</h3><br><h3>Asegurese de cambiar su contraseña</h3>';
                              $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                              $mail->send();

                              $_SESSION['success_message'] = 'Su nueva contraseña ha sido enviada al correo';
                        } catch (Exception $e) {
                              var_dump($e);
                        }

                        return to_route('Companies.index');
                  }
            }
            return to_route('Offers.index');
      }

      /**
       * Display the specified resource.
       */
      public function show(Company $company)
      {
            //
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit($company)
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 2) {
                  $c = Company::where('company_id', $company)->first();
            } else {
                  return to_route('Offers.index');
            }
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, Company $company)
      {
            //
      }

      /**
       * Remove the specified resource from storage.
       */
      public function destroy(Company $company)
      {
            //
      }
}
