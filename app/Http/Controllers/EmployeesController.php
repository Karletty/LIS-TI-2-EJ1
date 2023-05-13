<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmployeesController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 2) {
                  $employees = json_decode(json_encode(
                        DB::table('users')
                              ->join('employees', 'users.id', '=', 'employees.user_id')
                              ->select('users.*', 'employees.*')
                              ->where('employees.company_id', $_SESSION['user']['company_id'])
                              ->get()
                  ));
                  return view('Employees.index', ['employees' => $employees]);
            }
            return to_route('Offers.index');
      }

      /**
       * Show the form for creating a new resource.
       */
      public function create()
      {
            return view('Employees.create');
      }

      /**
       * Store a newly created resource in storage.
       */
      public function store(Request $request)
      {
            $validator = Validator::make($request->all(), [
                  'name' => 'required|string|max:255',
                  'email' => 'required|string|email|max:255|unique:users',
                  'password' => 'required|string|min:8',
                  'company_id' => 'required|string|min:6|max:6',
                  'first_name' => 'required|string|max:255',
                  'last_name' => 'required|string|max:255',
            ]);
            $pass = Str::random(8);
            $user = User::create([
                  'name' => $request->first_name . ' ' . $request->last_name,
                  'email' => $request->email,
                  'password' => hash('SHA256', $request->pass),
            ]);

            $employee = Employee::create([
                  'user_id' => $user->id,
                  'company_id' => $_SESSION['user']['company_id'],
                  'first_name' => $request->first_name,
                  'last_name' => $request->last_name
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
                  $mail->AddAddress($user->email, 'Someone Else');
                  $mail->Subject = 'Registro de empleado';
                  $mail->AddEmbeddedImage(public_path('img/banner.png'), 'imagen');
                  $mail->Body = '<img src="cid:imagen" height="auto" width="800px"><br><br><h3>Su administrador lo ha registrado como un empleado<br> La contraseña de su usuario es: ' . $pass . '</h3><br><h3>Asegurese de cambiar su contraseña</h3>';
                  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                  $mail->send();

                  $_SESSION['success_message'] = 'Se ha creado el usuario';

                  return to_route('Employees.index');
            } catch (Exception $e) {
                  var_dump($e);
            }

            return to_route('Offers.index');
      }

      /**
       * Display the specified resource.
       */
      public function show(Employee $employee)
      {
            //
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit(Employee $employee)
      {
            //
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, $employee)
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 2) {
                  $user = User::where('id', $employee)->first();
                  $pass = Str::random(8);
                  $user['password'] = hash('SHA256', $pass);
                  $user->save();
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
                        $mail->AddAddress($user->email, 'Someone Else');
                        $mail->Subject = 'Cambio de contraseña';
                        $mail->AddEmbeddedImage(public_path('img/banner.png'), 'imagen');
                        $mail->Body = '<img src="cid:imagen" height="auto" width="800px"><br><br><h3>Su contraseña ha sido reestablecida por su administrador, su nueva contraseña de es: ' . $pass . '</h3><br><h3>Asegurese de cambiar su contraseña</h3>';
                        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                        $mail->send();

                        $_SESSION['success_message'] = 'La nueva contraseña ha sido enviada al correo del empleado';
                  } catch (Exception $e) {
                        var_dump($e);
                  }
                  return to_route('Employees.index');
            }
            return to_route('Offers.index');
      }

      /**
       * Remove the specified resource from storage.
       */
      public function destroy($employee)
      {
            if (isset($_SESSION['user']['type_id']) && $_SESSION['user']['type_id'] == 2) {
                  $emp = Employee::where('user_id', $employee)->delete();
                  $user = User::where('id', $employee)->delete();

                  $_SESSION['success_message'] = 'Se ha eliminado el empleado';
                   
                  return to_route('Employees.index');
            }
            return to_route('Offers.index');
      }
}
