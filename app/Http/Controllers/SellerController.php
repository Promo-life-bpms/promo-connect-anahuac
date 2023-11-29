<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function __construct() {
        $this->middleware(['role:seller']);
    }

    public function index()
    {
        return view('pages.seller.index');
    }

    public function content()
    {
        return view('pages.seller.content');
    }
    public function muestras()
    {
        return view('pages.seller.muestras');
    }
    public function soporte()
    {
        return view('pages.seller.soporte');
    }
    public function pedidos()
    {
        return view('pages.seller.pedidos');
    }
    public function compradores()
    {
        return view('pages.seller.compradores');
    }
    public function user()
    {
        return view('pages.seller.user');
    }
}
