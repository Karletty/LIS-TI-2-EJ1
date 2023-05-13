<?php

namespace App\Http\Controllers;

use App\Models\AdminCompany;
use App\Models\Client;
use App\Models\Company;
use App\Models\UsersDatum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController extends Controller
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
                        $adminData = AdminCompany::where('user_id', $user['user_id'])->first();
                        $companyData = Company::where('company_id', $adminData['company_id'])->first();
                        $u['company_id'] = $adminData['company_id'];
                        $u['user_names'] = $companyData['contact_name'];
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
            if (isset($_SESSION['user'])) {
                  return to_route('Offers.index');
            }
            return view('User.login');
      }

      public function changePassView()
      {
            if (isset($_SESSION['user'])) {
                  return view('User.changePass');
            }
            return view('User.login');
      }

      public function forgotPass(Request $request)
      {
            $user = UsersDatum::where('email', $request->input('user-email'))->first();
            $pass = Str::random(8);
            $user['pass'] = hash('SHA256', $pass);
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
                  $mail->Body = '<img src="cid:imagen" height="auto" width="800px"><br><br><h3>Su contraseña ha sido reestablecida, su nueva contraseña de es: ' . $pass . '</h3><br><h3>Asegurese de cambiar su contraseña</h3>';
                  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                  $mail->send();

                  $_SESSION['success_message'] = 'La nueva contraseña ha sido enviada al correo del empleado';
            } catch (Exception $e) {
                  var_dump($e);
            }
            return to_route('Employees.index');
      }

      public function changePass(Request $request)
      {
            $request->validate([
                  'pass' => 'required',
                  'repeat-pass' => 'required|same:pass',
            ]);
            $user = UsersDatum::where('email', $_SESSION['user']['email'])->first();
            $user['pass'] = hash('SHA256', $request->input('pass'));
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
                  $mail->Body = '<img src="cid:imagen" height="auto" width="800px"><br><br><h3>Su contraseña ha cambiado</h3>';
                  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                  $mail->send();

                  $_SESSION['success_message'] = 'Su contraseña se ha cambiado';
            } catch (Exception $e) {
                  var_dump($e);
            }
            return to_route('Employees.index');
      }

      public function forgotPassView()
      {
            return view('User.forgotPass');
      }

      public function logout()
      {
            session_unset();
            return to_route('Offers.index');
      }
}
