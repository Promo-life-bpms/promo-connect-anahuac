<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Models\Catalogo\Product;
use App\Models\PunchoutSession;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class APIController extends Controller
{
    public function loginCustomer(Request $request)
    {
        // Validar los valores con validate y retornar un json en caso de error
        $validation =  Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'lastName' => 'required|string',
                'email' => 'required|email',
                'token' => 'required|string',
            ]
        );
        if ($validation->fails()) {
            return response()->json([
                "msg" => 'Error en la validación de los datos',
                'data' => $validation->getMessageBag()
            ], Response::HTTP_BAD_REQUEST);
        }

        // Obtener el nombre, apellido, correo y token del usuario del request
        $name = $request->name;
        $lastName = $request->lastName;
        $email = $request->email;
        $token = $request->token;
        $user = User::firstOrCreate(['email' => $email], [
            'name' => $name,
            //'lastName' => $lastName,
            'password' => Hash::make($name . $lastName . $email),
        ]);
        if (!$user->hasRole(['buyer', 'buyers-manager'])) {
            $buyer = Role::where('name', 'buyer')->first();
            $user->attachRole($buyer);
        }

        if ($user) {
            // Crear una nueva instancia de PunchoutSession
            $session = PunchoutSession::firstOrCreate([
                'user_id' => $user->id
            ], [
                'token' =>  $token,
                'access_token' => Str::random(30),
            ]);
            $session->access_token = Str::random(30);
            $session->save();

            return response()->json([
                "msg" => 'Usuario creado o actualizado correctamente',
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'link_access' => url("") . '/loginPunchOut?access_token=' . $session->access_token . '&data=' . $user->email
            ], Response::HTTP_OK);
            // Redireccionar al usuario a la página de inicio
            return redirect()->action([LoginController::class, 'loginWithLink'], ['session' => $session->token]);
        }
        return response()->json([
            "msg" => 'Error al crear el usuario',
            'data' => $request->all()
        ], Response::HTTP_BAD_REQUEST);
    }

    public function loginPunchOut(Request $req)
    {
        $validation =  Validator::make(
            $req->all(),
            [
                'access_token' => 'required|string',
                'data' => 'required|string',
            ]
        );
        if ($validation->fails()) {
            return response()->json([
                "msg" => 'Error en la validación de los datos',
                'data' => $validation->getMessageBag()
            ], Response::HTTP_BAD_REQUEST);
        }
        $user = User::where('email', $req->data)->first();
        if ($user) {
            if ($user->punchoutSession->access_token == $req->access_token) {
                // $user->punchoutSession->access_token = "";
                // $user->punchoutSession->save();
                if (Auth::login($user)) {
                    return  redirect('/home');
                }
            }
        }
        return  redirect('/login');
    }
    // Validar el carrito de compras
    public function validateCart(Request $request)
    {
        $validation =  Validator::make($request->all(), [
            'cart' => 'required|array',
            'cart.*.supplier_part_id' => 'required',
            'cart.*.unit_cost' => 'required',
            'cart.*.quantity' => 'required',
            'cart.*.print_customization_id' => 'required',
            'token' => 'required|string',
            'email' => 'required|email',
            'total_cost' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json([
                "msg" => 'Error en la validación de los datos',
                'data' => $validation->getMessageBag()
            ], Response::HTTP_BAD_REQUEST);
        }

        // Validar el token y el email
        $token = $request->token;
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                "msg" => 'El usuario con correo ' . $email . ' no existe'
            ], Response::HTTP_BAD_REQUEST);
        }
        $session = PunchoutSession::where('user_id', $user->id)->first();
        if (!$session) {
            return response()->json([
                "msg" => 'El usuario con correo ' . $email . ' no tiene una sesión activa'
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($session->token != $token) {
            return response()->json([
                "msg" => 'El token no coincide con el usuario'
            ], Response::HTTP_BAD_REQUEST);
        }

        $cart = $request->cart;
        $products = [];
        foreach ($cart as $item) {

            $product = Product::where('internal_sku', $item['supplier_part_id'])->first();
            if (!$product) {
                return response()->json([
                    "msg" => 'Error en la validación de los datos',
                    'data' => 'El producto con id ' . $item['supplier_part_id'] . ' no existe'
                ], Response::HTTP_BAD_REQUEST);
            }
            $products[] = [
                'id' => $product->id,
                'supplier_part_id' => $item["supplier_part_id"],
                'unit_cost' => $item["unit_cost"],
                'quantity' => $item['quantity'],
                'print_customization_id' => $item['print_customization_id'],
                'image' => $item['url_image'] ?? $product->firstImage->url,
            ];
        }
        // Guardar la compra en la base de datos

        return response()->json([
            "msg" => 'Carrito validado correctamente, se ha guardado con exito la orden de compra'
        ], Response::HTTP_OK);
    }
}
