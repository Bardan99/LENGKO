<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Pengadaan;
use App\PengadaanDetil;
use App\BahanBaku;
use Auth;
use Hash;
use Validator;

class PengadaanController extends Controller {

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


  public function createrequest(Request $request) {

    $data = $request->all();
    $max = $data['material-request-create-max'] + 1;
    $items['material-request-create-subject'] = 'required|min:4';
    $items['material-request-create-priority'] = 'required|min:1';
    if ($max > 2) {
      for ($i = 0; $i < $max; $i++) {
        $items['material-request-create-item-' . $i] = 'required|min:1';
      }
    }
    else {
      $items['material-request-create-item-0'] = 'required|min:1';
    }
    $this->validate($request, $items);

    $try = Pengadaan::create([
      'subjek_pengadaan_bahan_baku' => $data['material-request-create-subject'],
      'tanggal_pengadaan_bahan_baku' => date('Y-m-d'),
      'waktu_pengadaan_bahan_baku' => date('H:m:s'),
      'catatan_pengadaan_bahan_baku' => $data['material-request-create-addition'],
      'status_pengadaan_bahan_baku' => 0,
      'kode_pegawai' => Auth::user()->kode_pegawai,//sementara
      'kode_prioritas' => $data['material-request-create-priority']
    ]);
    $id = $try->kode_pengadaan_bahan_baku;

    if ($max > 2) {
      for ($i = 0; $i < $max; $i++) {
        $detils[] = array(
          'nama_bahan_baku' => $data['material-request-create-item-' . $i],
          'jumlah_bahan_baku' => 0,
          'satuan_bahan_baku' => '',
          'kode_pengadaan_bahan_baku' => $id,
        );
      }
    }
    else {
      $detils[] = array(
        'nama_bahan_baku' => $data['material-request-create-item-0'],
        'jumlah_bahan_baku' => 0,
        'satuan_bahan_baku' => '',
        'kode_pengadaan_bahan_baku' => $id,
      );
    }

    $try = PengadaanDetil::insert($detils);

    return redirect('/dashboard/material');
  }

  public function acceptrequest(Request $request) {
    $data = $request->all();
    $req = Pengadaan::findOrFail($data['_id']);
    if ($req) {
      $invalid = 0;
      foreach ($data['_data'] as $key => $value) {
        if ($data['_data'][$key]['material-request-detail-count'] > 0) { //jumlah di isi > 0
          $items['material-request-detail-name-' . $data['_id'] . '-' . $key] = 'required|min:3';
          $items['material-request-detail-count-' . $data['_id'] . '-' . $key] = 'required|min:1';
          $items['material-request-detail-unit-' . $data['_id'] . '-' . $key] = 'required|min:1';
          $items['material-request-detail-date-' . $data['_id'] . '-' . $key] = 'required|date_format:Y-m-d';
          $data['_data'][$key]['material-request-detail-date'] = date('Y-m-d', strtotime($value['material-request-detail-date']));

          $assign['material-request-detail-name-' . $data['_id'] . '-' . $key] = $data['_data'][$key]['material-request-detail-name'];
          $assign['material-request-detail-count-' . $data['_id'] . '-' . $key] = $data['_data'][$key]['material-request-detail-count'];
          $assign['material-request-detail-unit-' . $data['_id'] . '-' . $key] = $data['_data'][$key]['material-request-detail-unit'];
          $assign['material-request-detail-date-' . $data['_id'] . '-' . $key] = $data['_data'][$key]['material-request-detail-date'];
        }
        else {
          $invalid++;
        }
      }
      if ($invalid == count($data['_data'])) {
        return response()->json(['status' => 400,'text' => 'Silahkan isi salah satu bahan baku.']);
      }
      else {
        $validator = Validator::make($assign, $items);

        if ($validator->fails()) {
          return response()->json(['status' => 500, 'text' => 'Perhatikan bahwa semua kolom harus diisi']);
        }
        else {
          $tmp = 0;
          foreach ($data['_data'] as $key => $value) {
            if ($data['_data'][$key]['material-request-detail-count'] > 0) {
              $materials[] = array(
                'nama_bahan_baku' => $data['_data'][$key]['material-request-detail-name'],
                'stok_bahan_baku' => $data['_data'][$key]['material-request-detail-count'],
                'satuan_bahan_baku' => $data['_data'][$key]['material-request-detail-unit'],
                'tanggal_kadaluarsa_bahan_baku' => $data['_data'][$key]['material-request-detail-date']
              );

              $include[$tmp] = $data['_data'][$key]['material-request-detail-id'];
              $tmp++;
              $materialdetails[] = array(
                'nama_bahan_baku' => $data['_data'][$key]['material-request-detail-name'],
                'jumlah_bahan_baku' => $data['_data'][$key]['material-request-detail-count'],
                'satuan_bahan_baku' => $data['_data'][$key]['material-request-detail-unit'],
                'kode_pengadaan_bahan_baku' => $data['_id']
              );
            }
          }

          $try = BahanBaku::insert($materials);
          if ($try) {
              Pengadaan::find($data['_id'])->update([
                'status_pengadaan_bahan_baku' => 1
              ]);

              $all = DB::table('pengadaan_bahan_baku_detil')
                    ->where('kode_pengadaan_bahan_baku', $data['_id'])
                    ->whereIn('kode_pengadaan_bahan_baku_detil', $include)
                    ->get();

              foreach ($all as $key => $value) {
                PengadaanDetil::find($value->kode_pengadaan_bahan_baku_detil)
                ->update($materialdetails[$key]);
              }

              return response()->json(['status' => 200,'text' => 'Berhasil menambahkan data bahan baku.']);
          }
        }//end case validator

      }
    }
    else {
      return response()->json(['status' => 400,'text' => 'Kode pengajuan bahan baku tidak diketahui']);
    }
  }

  public function declinerequest(Request $request) {
    $data = $request->all();
    $req = Pengadaan::find($data['_id']);
    if ($req) {
      $validator = Validator::make($data, [
        '_id' => 'required|min:1'
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Terjadi kesalahan']);
      }
      else {
        $try = Pengadaan::find($data['_id'])->update([
          'status_pengadaan_bahan_baku' => -1
        ]);
        return response()->json(['status' => 200,'text' => '']);
      }//end case validator
    }
    else {
      return response()->json(['status' => 400,'text' => 'Kode pengajuan bahan baku tidak diketahui']);
    }
    return redirect('/dashboard/material');
  }


  /* currently unused
  public function searchrequest(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'search-material-request-query' => 'required|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Jangan lupa diisi ya kata kunci nya!']);
      }

      $req = DB::table('pengadaan_bahan_baku')
        ->where('status_pengadaan_bahan_baku', 0)
        ->where(function($qry) use($data) {
         $qry->orwhere('kode_pengadaan_bahan_baku', 'LIKE', '%' . $data['search-material-request-query'] . '%')
             ->orwhere('subjek_pengadaan_bahan_baku', 'LIKE', '%' . $data['search-material-request-query'] . '%')
             ->orwhere('catatan_pengadaan_bahan_baku', 'LIKE', '%' . $data['search-material-request-query'] . '%');
        })
        ->join('prioritas', 'prioritas.kode_prioritas', '=', 'pengadaan_bahan_baku.kode_prioritas')
        ->orderBy('tanggal_pengadaan_bahan_baku', 'DSC')
        ->get();

        foreach ($req as $key => $value) {
          $reqdet[] = DB::table('pengadaan_bahan_baku_detil')
            ->where('kode_pengadaan_bahan_baku', '=', $value->{'kode_pengadaan_bahan_baku'})
            ->orderBy('nama_bahan_baku', 'ASC')
            ->get();
        }

      if ($req) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'request' => $req,
            'details' => $reqdet
          ]);
      }

    }
  }
  */

}
