<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productsCount = Product::where('is_active','=',1)->count();
        $usersCount = User::count();
        $categoryCount = Category::where('is_active','=',1)->count();
        return view('home',compact('productsCount','usersCount','categoryCount'));
    }
}
