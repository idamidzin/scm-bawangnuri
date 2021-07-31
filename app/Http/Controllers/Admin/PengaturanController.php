<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persediaan;

class PengaturanController extends Controller
{
    public function index()
    {
    	$persediaan = Persediaan::where('status', 1)->first();
    	return view('pages.admin.pengaturan.index', compact('persediaan'));
    }

    public function update(Request $request, $id)
    {
    	$persediaan = Persediaan::where('id', $id)->first();
    	
    	$persediaan->stok = $request->stok;
    	$persediaan->update();

    	return redirect()->back()->with('msg', ['type'=>'success', 'text'=>'Persediaan berhasil disimpan']);
    }
}
