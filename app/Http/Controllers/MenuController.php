<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Menu;
use App\MenuDetil;
use Hash;
use Validator;

class MenuController extends Controller {

  public function create(Request $request) {
    $data = $request->all();

    $menu = Menu::find($data['menu-create-id']);
    if (!$menu) {
      $id = $request->get('menu-create-id');
      $file = $request->file('menu-create-thumbnail');
      $rules = [
        'menu-create-id' => 'required|min:4',
        'menu-create-name' => 'required|min:4',
        'menu-create-price' => 'required|min:1',
        'menu-create-type' => 'required',
        'menu-create-description' => 'required',
      ];

      $input = [
        'kode_menu' => $data['menu-create-id'],
        'nama_menu' => $data['menu-create-name'],
        'harga_menu' => $data['menu-create-price'],
        'jenis_menu' => $data['menu-create-type'],
        'deskripsi_menu' => $data['menu-create-description'],
        'kode_pegawai' => 'toor' //sementara tmp
      ];

      if ($file) {
        $fileName   = strtolower(str_replace(" ", "-", $data['menu-create-name']))  . '.' . $file->getClientOriginalExtension();
        $request->file('menu-create-thumbnail')->move("files/images/menus", $fileName);
        $rules['menu-create-thumbnail'] = 'required';
        $input['gambar_menu'] = $fileName;
      }
      $this->validate($request, $rules);

      $assign = false;
      for ($i = 0; $i < $data['menu-material-max']; $i++) {
        if ($data['menu-material-create-count-' . $i] > 0) {
          $input2[$i] = [
            'kode_bahan_baku' => $data['menu-material-create-id-' . $i],
            'kode_menu' => $id,
            'jumlah_bahan_baku_detil' => $data['menu-material-create-count-' . $i]
          ];
          $rules2[$i] = [
            'menu-material-create-count-' . $i => 'required|min:0.01'
          ];
          $assign = true;
        }
      }

      if ($assign) { //asumsi setiap menu wajib setidaknya punya 1 bahan baku
        $this->validate($request, $rules2);
        $try = Menu::create($input);
        $try = MenuDetil::create($input2);
      }
    }
    return redirect('/dashboard/menu');
  }

  public function searchmaterial(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'material-search-query' => 'required',
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

  public function search(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'menu-search-query' => 'required|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Jangan lupa diisi ya kata kunci nya!']);
      }

      $menus = DB::table('menu')
        ->join('otoritas','otoritas.kode_otoritas', '=', 'menu.kode_otoritas')
        ->select('*', DB::raw('IF (jenis_kelamin_menu = "L", "Laki-Laki", IF (jenis_kelamin_menu = "P", "Perempuan", "-")) AS jenis_kelamin_menu'))
        ->where('kode_menu', 'LIKE', '%' . $data['menu-search-query'] . '%')
        ->orwhere('nama_menu', 'LIKE', '%' . $data['menu-search-query'] . '%')
        ->where('menu.kode_menu', '!=', 'toor') //yg login gk boleh hapus datanya sendiri
        ->orderBy('nama_menu', 'ASC')
        ->get();
      $authority = DB::table('otoritas')
        ->orderBy('nama_otoritas', 'ASC')
        ->get();
      if ($menus) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $menus,
            'authority' => $authority
          ]);
      }

    }
  }

}
