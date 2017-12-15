<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\BahanBaku;
use Hash;
use Auth;
use Validator;

class MaterialController extends Controller {

  public function get($param) {
    $data = null;
    if ($param) {
      switch ($param) {
        case 'material':
          $data['material'] = DB::table('bahan_baku')
            ->orderBy('nama_bahan_baku', 'ASC')
            ->get();
        break;
        default:break;
      }
    }
    return $data;
  }


  public function generate_textbox(Request $request) {
    if ($request->isMethod('get')) {
      $data['material'] = DB::table('bahan_baku')
        ->orderBy('nama_bahan_baku', 'ASC')
        ->get();
      return response()->json(['data' => $data]);
    }
  }

  public function search(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'material-search-query' => 'required|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Jangan lupa diisi ya kata kunci nya!']);
      }

      $materials = DB::table('bahan_baku')
        ->where('kode_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orwhere('nama_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orwhere('stok_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orwhere('satuan_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orwhere('tanggal_kadaluarsa_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orderBy('nama_bahan_baku', 'ASC')
        ->get();
      if ($materials) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $materials
          ]);
      }

    }
  }

  public function create(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'material-create-name' => 'required|min:3',
        'material-create-stock' => 'required|min:1',
        'material-create-unit' => 'required|min:1',
        'material-create-date' => 'required'
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Perhatikan bahwa semua kolom harus diisi']);
      }

      $try = BahanBaku::create([
        'nama_bahan_baku' => $data['material-create-name'],
        'stok_bahan_baku' => $data['material-create-stock'],
        'satuan_bahan_baku' => $data['material-create-unit'],
        'tanggal_kadaluarsa_bahan_baku' => $data['material-create-date']
      ]);
      return response()->json(['status' => 200,'text' => 'Yey, berhasil menambahkan bahan baku.']);

    }
  }

  public function retrieve() {
    $materials = DB::table('bahan_baku')
      ->orderBy('nama_bahan_baku', 'ASC')
      ->get();
    return response()->json(['status' => 200, 'content' => $materials]);
  }

  public function changematerial($id) {
    if (view()->exists('dashboard.materialchange')) {
      $navbar = new MethodController;
      $pages = $navbar->get_navbar(Auth::guard('employee')->user()->kode_otoritas);
      $access = false;
      foreach ($pages as $key => $value) {
        if ('material' == $value->kode_halaman) {
          $access = true;
        }
      }
      if (!$access) {
        return abort(403);
      }
      else {
        $try = BahanBaku::find($id);
        if ($try) {
          $data['material'] = BahanBaku::where('kode_bahan_baku', $id)->first();
          return view('dashboard.materialchange', ['pages' => $pages, 'page' => 'material', 'data' => $data, 'auth' => Auth::guard('employee')->user()->kode_otoritas]);
        }
        return redirect('/dashboard/material');
      }
    }
    return abort(404);
  }

}
