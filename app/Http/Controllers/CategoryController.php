<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Category;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('api.auth', ['except'=> ['index','show']]);
    }

   /*  public function pruebas(Request $request)
    {
        return "Acción de pruebas de CategoryController";
    }
 */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'categories' => $categories
        ]);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (is_object($category)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'category' => $category
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'category' => 'La categoría no existe'
            ];
        }

        return response()->json($data, $data['code']);
    }


    public function store(Request $request){
        // Recoger los datos por POST
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if(!empty($params_array)){


        // Validar los datos
        $validate = \Validator::make($params_array,[
            'name' => 'required'
        ]);

        // Validar la categoría
        if($validate->fails()){
            $data = [
                'code' => 400,
                'status' => 'error',
                'category' => 'No se ha guardado la categoría'
            ];
        }else{
            $category = new Category();
            $category->name = $params_array['name'];
            $category->save();

            $data = [
                'code' => 200,
                'status' => 'success',
                'category' => $category
            ];
        }
    }else{
        $data = [
            'code' => 400,
            'status' => 'error',
            'category' => 'No se ha enviado ninguna categoría'
        ];
    }
        // Devolver resultado
        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request){
        // Recoger los datos por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if(!empty($params_array)){
        // Validar los datos
        $validate = \Validator::make($params_array,[
            'name' => 'required'
        ]);

        // Quitar lo que no quiero actualizar
        unset($params_array[ 'id']);
        unset($params_array[ 'created_at']);
        // Actualizar el registro(categoría)
        $category = Category::where('id',$id)->update($params_array);

        $data = [
            'code' => 200,
            'status' => 'success',
            'category' => $params_array
        ];

        }else{
            $data = [
                'code' => 400,
                'status' => 'error',
                'category' => 'No se ha enviado ninguna categoría'
            ];
        }
        // Devolver los datos
        return response()->json($data, $data['code']);
    }



}
