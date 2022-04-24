<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pos;
use App\Models\Web;
use App\Models\District;
use Alert;
use Storage;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pos'] = Pos::all();
        $data['web'] = Web::all();
        $data['districts'] = District::where('regency_id', '=', '3211')->get();
        return view('back.pos.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkPosName(Request $request) 
    {
        if($request->Input('nama')){
            $nama = Pos::where('nama',$request->Input('nama'))->first();
            if($nama){
                return 'false';
            }else{
                return  'true';
            }
        }

        if($request->Input('edit_nama')){
            $edit_nama = Pos::where('nama',$request->Input('edit_nama'))->first();
            if($edit_nama){
                return 'false';
            }else{
                return  'true';
            }
        }
    }

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
        $data = [
            'nama' => $request->nama,
            'jenis_pos' => $request->jenis_pos,
            'district_id' => $request->district_id,
        ];

        Pos::create($data)
        ? Alert::success('Berhasil', 'Pos telah berhasil ditambahkan!')
        : Alert::error('Error', 'Pos gagal ditambahkan!');

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
        $pos = Pos::findOrFail($id);
        
        $data = [
            'nama' => $request->edit_nama ? $request->edit_nama : $pos->nama,
            'jenis_pos' => $request->edit_jenis_pos ? $request->edit_jenis_pos : $pos->jenis_pos,
            'district_id' => $request->edit_district_id ? $request->edit_district_id : $pos->district_id,           
        ];

        $pos->update($data)
        ? Alert::success('Berhasil', "Pos telah berhasil diubah!")
        : Alert::error('Error', "Pos gagal diubah!");

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
        $pos = Pos::findOrFail($id);
       
        $pos->delete()
            ? Alert::success('Berhasil', "Pos telah berhasil dihapus.")
            : Alert::error('Error', "Pos gagal dihapus!");

        return redirect()->back();
    }

    // public function destroyAll(Request $request)
    // {
    //     if(empty($request->id)) {
    //         Alert::info('Info', "Tidak ada pos yang dipilih.");
    //         return redirect()->back();
    //     } else {
    //         $pos = $request->id;
        
    //         foreach($pos as $allpos) {
    //             pos::where('id', $allpos)->delete()
    //             ? Alert::success('Berhasil', "Semua pos yang dipilih telah berhasil dihapus.")
    //             : Alert::error('Error', "pos gagal dihapus!");
    //         }
               
    
    //         return redirect()->back();
    //     }
    // }
}
