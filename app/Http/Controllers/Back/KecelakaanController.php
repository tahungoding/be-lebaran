<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecelakaan;
use App\Models\Web;
use Alert;
use Storage;
use Illuminate\Support\Facades\Auth;

class KecelakaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['kecelakaan'] = Kecelakaan::when(Auth::user()->role == 'pos', function ($query) {
            $query->where('pos_id', Auth::user()->pos_id);
        })->get();
        $data['web'] = Web::all();
        return view('back.kecelakaan.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function checkKemacetanName(Request $request) 
    // {
    //     if($request->Input('kecamatan_name')){
    //         $pos_name = Pos::where('name',$request->Input('pos_name'))->first();
    //         if($pos_name){
    //             return 'false';
    //         }else{
    //             return  'true';
    //         }
    //     }

    //     if($request->Input('edit_pos_name')){
    //         $edit_pos_name = Pos::where('name',$request->Input('edit_pos_name'))->first();
    //         if($edit_pos_name){
    //             return 'false';
    //         }else{
    //             return  'true';
    //         }
    //     }
    // }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $file_pendukung = ($request->file_pendukung) ? $request->file('file_pendukung')->store("/public/input/kecelakaan") : null;

        $data = [
            'lokasi' => $request->lokasi,
            'ringkas_kejadian' => $request->ringkas_kejadian,
            'detail_kejadian' => $request->detail_kejadian,
            'file_pendukung' => $file_pendukung,
            'waktu' => $request->waktu,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'user_id' => Auth::user()->id
        ];

        if (Auth::user()->role != 'admin') {
            $data['pos_id'] = Auth::user()->pos_id;
        }

        Kecelakaan::create($data)
        ? Alert::success('Berhasil', 'Data Kecelakaan telah berhasil ditambahkan!')
        : Alert::error('Error', 'Data Kecelakaan gagal ditambahkan!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kecelakaan = Kecelakaan::findOrFail($id);
        if($request->hasFile('edit_file_pendukung')) {
            if(Storage::exists($kecelakaan->file_pendukung) && !empty($kecelakaan->file_pendukung)) {
                Storage::delete($kecelakaan->file_pendukung);
            }

            $edit_file_pendukung = $request->file("edit_file_pendukung")->store("/public/input/kecelakaan");
        }
        
        $data = [
            'lokasi' => $request->edit_lokasi ? $request->edit_lokasi : $kecelakaan->lokasi,
            'ringkas_kejadian' => $request->edit_ringkas_kejadian ? $request->edit_ringkas_kejadian : $kecelakaan->ringkas_kejadian,
            'detail_kejadian' => $request->edit_detail_kejadian ? $request->edit_detail_kejadian : $kecelakaan->detail_kejadian,
            'file_pendukung' => $request->hasFile('edit_file_pendukung') ? $edit_file_pendukung : $kecelakaan->file_pendukung,          
            'waktu' => $request->edit_waktu ? $request->edit_waktu : $kecelakaan->waktu,
            'latitude' => $request->edit_latitude ? $request->edit_latitude : $kecelakaan->latitude,
            'longitude' => $request->edit_longitude ? $request->edit_longitude : $kecelakaan->longitude,
        ];

        $kecelakaan->update($data)
        ? Alert::success('Berhasil', "Kecelakaan telah berhasil diubah!")
        : Alert::error('Error', "Kecelakaan gagal diubah!");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kecelakaan = Kecelakaan::findOrFail($id);
       
        $kecelakaan->delete()
            ? Alert::success('Berhasil', "Kecelakaan telah berhasil dihapus.")
            : Alert::error('Error', "Kecelakaan gagal dihapus!");

        return redirect()->back();
    }
}
