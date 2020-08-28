<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function pruebas(Request $request)
    {
        return "Acción de pruebas de UserController";
    }

    public function register(Request $request)
    {

        // Recoger los datos del usuario por post
        $json = $request->input('json', null);
        $params = json_decode($json); //Objeto
        $params_array = json_decode($json, true); //array

        /*  var_dump($params->name);
    var_dump($params_array);
    die(); */


        if (!empty($params && $params_array)) {

            // Limpiar datos
            $params_array = array_map('trim', $params_array);

            // Validar datos
            $validate = \Validator::make($params_array, [
                'name'      => 'required|alpha',
                'surname'   => 'required|alpha',
                'email'     => 'required|email|unique:users',
                'password'  => 'required'
            ]);

            if ($validate->fails()) {
                // La validación ha fallado
                $data = array(
                    'status' => 'error',
                    'code'   => 404,
                    'message' => 'El usuario no se ha creado',
                    'errors' => $validate->errors()
                );
            } else {
                // Validación pasada correctamente

                // Cifrar la contraseña
                $options = ['cost' => 4];
                $pwd = password_hash($params->password, PASSWORD_BCRYPT, $options);

                // Comprobar si el usuario ya existe (duplicado) regla unique de laravel

                // Crear el usuario
                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->email = $params_array['email'];
                $user->password = $pwd;
                $user->role = 'ROLE_USER';
                /*  var_dump($user);
                die();*/

                //Guardar el usuario
                $user->save();

                $data = array(
                    'status' => 'success',
                    'code'   => 200,
                    'message' => 'El usuario se ha creado correctamente',
                    'user'  => $user
                );
            }
        } else {
            $data = array(
                'status' => 'error',
                'code'   => 404,
                'message' => 'Los datos enviados no son correctos'
            );
        }

        return response()->json($data, $data['code']);
    }

    public function login(Request $request)
    {
        return "Acción de login de usuarios";
    }
}
