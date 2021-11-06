<?php

namespace App\Http\Controllers\Auth;

use App\Empresa;
use App\Http\Controllers\Controller;
use App\NivelPrimario;
use App\PermisosNPrimario;
use App\Profile;
use App\Roles;
use App\Sede;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('configure');
    }

    public function index()
    {
        $lstRoles = Roles::where('estado', 'A')->get();
        $lstEntidades = Empresa::where('estado', 'A')->get();
        $lstNivelPri = NivelPrimario::where('estado', 'A')->get();
        $lstSede = Session::get('lstSede');
        return view('auth.register', compact('lstRoles', 'lstEntidades', 'lstNivelPri', 'lstSede'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'name.required' => 'Ingrese Nombre',
            'email.required' => 'Ingrese correo',
            'password.required' => 'Ingrese Clave',
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);
        if ($validator->fails()) {
            $mensaje = '';
            foreach ($validator->errors()->all() as $error) {
                $mensaje .= '<li>' . $error . '</li>';
            }
            return response()->json(['msg' => 'error', 'data' => $mensaje]);
        } else {

            return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente el usuario ']);
        }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol_id' => $data['idrol']
            //'entidad_id' => $data['idservicio'],
        ]);
    }

    public function register(Request $request)
    {
        try {
            if (!empty($request->hide_id)) {
                $messages = [
                    'name.required' => 'Ingrese Nombre',
                    'email.required' => 'Ingrese Email',
                    'idrol.required' => 'Ingrese Rol',
                    'idempresa.required' => 'Ingrese Empresa',
                    'extencion.required' => 'Ingrese Extención',
                    'llamada.required' => 'Ingrese Llamada',
                    'nivel_p.required' => 'Ingrese ' . session('nivel1'),
                    'telefono.required' => 'Ingrese Teléfono',
                    'celular.required' => 'Ingrese Celular',
                ];
                $validator = Validator::make($request->all(), [
                    'name' => ['string', 'max:255'],
                    'email' => 'required|max:255|string|unique:users,email,' . $request->hide_id . ',id',
                    'idrol' => ['required'],
                    'idempresa' => 'required',
                    'extencion' => 'required',
                    'llamada' => 'required',
                    'nivel_p' => 'required',
                    'telefono' => 'required',
                    'celular' => 'required'
                ], $messages);

                $mensaje = '';
                if ($request->password != $request->password_confirmed) {
                    $mensaje = 'Los password no coinciden.';
                }

                if (!empty($mensaje)) {
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                }

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {

                    $user = User::find($request->hide_id);
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->rol_id = $request->idrol;
                    $user->status = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $user->save();

                    $profile = Profile::where('user_id', $user->id)->first();
                    $profile->user_id = $user->id;
                    $profile->telefono = $request->telefono;
                    $profile->celular = $request->celular;
                    $profile->extension = $request->extencion;
                    $profile->numero_llamada = $request->llamada;
                    $profile->sede_id = $request->idsede;
                    $profile->empresa_id = $request->idempresa;
                    $profile->save();

                    $array = explode(",", $request->nivel_p);
                    $array2 = explode(",", $request->nivel_v);

                    PermisosNPrimario::where('user_id', $user->id)->delete();

                    for ($i = 0; $i < count($array); $i++) {

                        $bodytag = str_replace('"', '', $array[$i]);
                        $bodytag1 = str_replace('[', '', $bodytag);
                        $bodytag2 = str_replace('"', '', $bodytag1);
                        $bodytag3 = str_replace(']', '', $bodytag2);

                        $bodytagv = str_replace('"', '', $array2[$i]);
                        $bodytag1v = str_replace('[', '', $bodytagv);
                        $bodytag2v = str_replace('"', '', $bodytag1v);
                        $bodytag3v = str_replace(']', '', $bodytag2v);

                        $per_user = PermisosNPrimario::where('user_id', $user->id)->where('nprimario_id', $bodytag3)->first();
                        if (!empty($per_user)) {
                            $per_user->nprimario_id = $bodytag3;
                            $per_user->asesor_nprimario = ($bodytag3v != 0 ? 'SI' : 'NO');
                            $per_user->save();
                        } else {
                            $per_user = new PermisosNPrimario();
                            $per_user->user_id = $user->id;
                            $per_user->nprimario_id = $bodytag3;
                            $per_user->asesor_nprimario = ($bodytag3v != 0 ? 'SI' : 'NO');
                            $per_user->save();
                        }

                    }


                    return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente el usuario ' . $request->name]);
                }
            } else {

                $messages = [
                    'name.required' => 'Ingrese Nombre',
                    'email.required' => 'Ingrese Email',
                    'idrol.required' => 'Ingrese Rol',
                    'idempresa.required' => 'Ingrese Empresa',
                    'password.required' => 'Ingrese Password',
                    'password_confirmed.required' => 'Ingrese Confirmación Password',
                    'extencion.required' => 'Ingrese Extención',
                    'llamada.required' => 'Ingrese Lllamada',
                    'nivel_p.required' => 'Ingrese ' . session('nivel1'),
                    'telefono.required' => 'Ingrese Teléfono',
                    'celular.required' => 'Ingrese Celular',
                    'chk_estado.required' => 'Ingrese Estado',
                ];

                $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => 'required|max:255|string|unique:users,email,' . $request->id,
                    'password' => ['required', 'string', 'min:8'],
                    'idrol' => ['required'],
                    'idempresa' => 'required',
                    'password_confirmed' => 'required',
                    'extencion' => 'required',
                    'llamada' => 'required',
                    'nivel_p' => 'required',
                    'chk_estado' => 'required',
                    'telefono' => 'required',
                    'celular' => 'required'
                ], $messages);


                $mensaje = '';
                if ($request->password != $request->password_confirmed) {
                    $mensaje = 'Los password no coinciden.';
                }

                if (!empty($mensaje)) {
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                }

                if ($validator->fails()) {

                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $user = new User();
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->rol_id = $request->idrol;
                    $user->status = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $user->password = Hash::make($request->password);
                    $user->save();

                    $profile = new Profile();
                    $profile->user_id = $user->id;
                    $profile->telefono = $request->telefono;
                    $profile->celular = $request->celular;
                    $profile->extension = $request->extencion;
                    $profile->numero_llamada = $request->llamada;
                    $profile->sede_id = $request->idsede;
                    $profile->empresa_id = $request->idempresa;
                    $profile->save();

                    $array = explode(",", $request->nivel_p);
                    $array2 = explode(",", $request->nivel_v);

                    for ($i = 0; $i < count($array); $i++) {

                        $bodytag = str_replace('"', '', $array[$i]);
                        $bodytag1 = str_replace('[', '', $bodytag);
                        $bodytag2 = str_replace('"', '', $bodytag1);
                        $bodytag3 = str_replace(']', '', $bodytag2);

                        $bodytagv = str_replace('"', '', $array2[$i]);
                        $bodytag1v = str_replace('[', '', $bodytagv);
                        $bodytag2v = str_replace('"', '', $bodytag1v);
                        $bodytag3v = str_replace(']', '', $bodytag2v);

                        $per_user = new PermisosNPrimario();
                        $per_user->user_id = $user->id;
                        $per_user->nprimario_id = $bodytag3;
                        $per_user->asesor_nprimario = ($bodytag3v != 0 ? 'SI' : 'NO');
                        $per_user->save();
                    }


                    return response()->json(['msg' => 'success', 'data' => 'Se ha creado correctamente el usuario ' . $request->name]);
                }
            }
        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
    }

    public function viewData()
    {
        try {
            $objinfoUser = Session::get('infoUser');

            $sql = "SELECT users.*, roles.nombre as rol, sede.nombre as sede  FROM users
                        JOIN roles ON users.rol_id =roles.id
                        JOIN profiles ON users.id =profiles.user_id
                        LEFT JOIN sede ON profiles.sede_id = sede.id
                     WHERE profiles.empresa_id = " . $objinfoUser->empresa_id;

            if (!empty($objinfoUser->sede_id)) {
                $sql .= " AND  profiles.sede_id = '" . $objinfoUser->sede_id . "' ";
            }

            $lstUser = DB::select($sql);

            return view('auth.tabla', compact('lstUser', $lstUser));
        } catch (Exception $e) {
            return "Ha ocurrido un problema al obtener la información " . $e->getMessage();
        }
    }

    public function edit(Request $request)
    {
        try {
            $data = User::with('profile')->with('permiso_np')->find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargada la información', 'data' => $data];
        } catch (Exception $e) {
            return "Ha ocurrido un problema al obtener la información " . $e->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->status = 'I';
            $user->save();
            return ['msg' => 'success', 'info' => 'Se ha eliminado correctamente la información: ' . $user->name];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

}
