<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;

class CartController extends Controller
{
    public function getCart()
    {
        return view('front.eCommerce.cart');
    }

    public function removeItem($id)
	{
	    Cart::remove($id);

	    if (Cart::isEmpty()) {
	        return redirect('/');
	    }
	    return redirect()->back()->with('message', 'Item removed from cart successfully.');
	}

	public function clearCart()
	{
	    Cart::clear();

	    return redirect('/');
	}
}
