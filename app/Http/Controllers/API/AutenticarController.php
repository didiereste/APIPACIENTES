<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistroRequest;
use App\Http\Requests\AccesoRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;

class AutenticarController extends Controller
{
    public function registro(RegistroRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //asignamos los roles
        if ($user->id) {
            // Asignar roles solo si el usuario se ha guardado correctamente
            $user->roles()->attach($request->roles);
        
            return response()->json([
                'res' => true,
                'msm' => 'Usuario registrado correctamente'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'msm' => 'Error al registrar el usuario'
            ], 500);
        }
    }

    public function acceso(AccesoRequest $request)
    {
        //crear api token para que el usuario pueda hacer uso de las rutas de la API



        $user = User::with('roles')->where('email', $request->email)->first();//Almacena en una variable el usuario que tiene como email el que se pone en el request
 

        //si el usuario no existe o si la password es incorrecta respecto a la que pongo en el request con la que tengo en la base de datos me sale 'Las credenciales son incorrectas'
                if (! $user || ! Hash::check($request->password, $user->password)) {
                    throw ValidationException::withMessages([
                        'msg' => ['Las credenciales son incorrectas'],
                    ]);
                }
            
                //creamos un token con createToken y se lo vamos a asignar al usuario que se logueo en el momento y le decimos que lo queremos en texto plano con plainTextToken
                $token=  $user->createToken($request->email)->plainTextToken;

                return response()->json([
                    'res'=> true,
                    'token'=>$token,
                    'datos'=>$user
                ],200);
    }

    public function cerrarSesion(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'res'=> true,
            'msg'=>'Token eliminado correctamente'
        ],200);
    }


}
