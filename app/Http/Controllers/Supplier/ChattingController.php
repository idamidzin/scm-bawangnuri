<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChattingController extends Controller
{
    public function index(Request $request)
    {
    	return view('pages.supplier.chatting.index');
    }
}
