<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kemacetan;
use App\Models\Web;
use App\Models\Pos;

use Alert;
use Storage;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KemacetanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['kemacetan'] = Kemacetan::when(Auth::user()->role == 'pos', function ($query) {
            $query->where('pos_id', Auth::user()->pos_id);
        })->get();
        $data['web'] = Web::all();
        return view('back.kemacetan.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function map() {
        $data['web'] = Web::all();
        return view('map.data', $data);
    }

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
        $data['web'] = Web::all();
        $data['pos'] = Pos::all();

        return view('back.kemacetan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $file_pendukung = ($request->file_pendukung) ? $request->file('file_pendukung')->store("/public/input/kemacetan") : null;
        
        $date = Carbon::now();

        $posIdVar = Pos::where('nama', '=', $request->nama_pos)->first();

        $data = [
            'lokasi' => $request->lokasi,
            'ringkas_kejadian' => $request->ringkas_kejadian,
            'detail_kejadian' => $request->detail_kejadian,
            'file_pendukung' => $file_pendukung,
            'waktu' => $request->waktu,
            'tanggal' => $date->toFormattedDateString(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'nama_pos' => $request->nama_pos,
            'pos_id' => $posIdVar->id,
            'status' => 'on',
            'user_id' => Auth::user()->id
        ];

        Kemacetan::create($data)
        ? Alert::success('Berhasil', 'Data Kemacetan telah berhasil ditambahkan!')
        : Alert::error('Error', 'Data Kemacetan gagal ditambahkan!');

        return redirect()->route('kemacetan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        $kemacetan = Kemacetan::where('id', $id)->first();

            $data = [   
                'status' => $request->status
            ];

        $kemacetan->update($data)
        ? Alert::success('Berhasil', "Status Kemacetan telah berhasil diubah!")
        : Alert::error('Error', "Status Kemacetan gagal diubah!");

        return redirect()->back();
    }


    public function show($id)
    {
        $data['kemacetan'] = Kemacetan::find($id);
        $data['web'] = Web::all();

        return view('back.kemacetan.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['kemacetan'] = Kemacetan::find($id);
        $data['pos'] = Pos::all();
        $data['web'] = Web::all();

        return view('back.kemacetan.edit', $data);
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
        $kemacetan = Kemacetan::findOrFail($id);

        if($request->hasFile('edit_file_pendukung')) {
            if(Storage::exists($kemacetan->file_pendukung) && !empty($kemacetan->file_pendukung)) {
                Storage::delete($kemacetan->file_pendukung);
            }

            $edit_file_pendukung = $request->file("edit_file_pendukung")->store("/public/input/kecamatan");
        }

        $posIdVar = Pos::where('nama', '=', $request->edit_nama_pos)->first();

        $data = [
            'lokasi' => $request->edit_lokasi ? $request->edit_lokasi : $kemacetan->lokasi,
            'ringkas_kejadian' => $request->edit_ringkas_kejadian ? $request->edit_ringkas_kejadian : $kemacetan->ringkas_kejadian,
            'detail_kejadian' => $request->edit_detail_kejadian ? $request->edit_detail_kejadian : $kemacetan->detail_kejadian,
            'file_pendukung' => $request->hasFile('edit_file_pendukung') ? $edit_file_pendukung : $kemacetan->file_pendukung,          
            'waktu' => $request->edit_waktu ? $request->edit_waktu : $kemacetan->waktu,
            'tanggal' => $kemacetan->tanggal,
            'latitude' => $request->edit_latitude ? $request->edit_latitude : $kemacetan->latitude,
            'longitude' => $request->edit_longitude ? $request->edit_longitude : $kemacetan->longitude,
            'nama_pos' => $request->edit_nama_pos ? $request->edit_nama_pos : $kemacetan->nama_pos,
            'pos_id' => $posIdVar->id ? $posIdVar->id : $kemacetan->pos_id,
        ];

        $kemacetan->update($data)
        ? Alert::success('Berhasil', "Kemacetan telah berhasil diubah!")
        : Alert::error('Error', "Kemacetan gagal diubah!");

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
        $kemacetan = Kemacetan::findOrFail($id);
       
        $kemacetan->delete()
            ? Alert::success('Berhasil', "Kemacetan telah berhasil dihapus.")
            : Alert::error('Error', "Kemacetan gagal dihapus!");

        return redirect()->back();
    }

}
