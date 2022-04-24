<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PosGatur;
use App\Models\Web;
use Alert;
use Storage;

class PosGaturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pos_gatur'] = PosGatur::all();
        $data['web'] = Web::all();
        return view('back.pos_gatur.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkPosGaturName(Request $request) 
    {
        if($request->Input('nama')){
            $pos_gatur = PosGatur::where('nama',$request->Input('nama'))->first();
            if($pos_gatur){
                return 'false';
            }else{
                return  'true';
            }
        }

        if($request->Input('edit_nama')){
            $edit_pos_gatur = PosGatur::where('nama',$request->Input('edit_nama'))->first();
            if($edit_pos_gatur){
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
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ];

        PosGatur::create($data)
        ? Alert::success('Berhasil', 'Pos Gatur telah berhasil ditambahkan!')
        : Alert::error('Error', 'Pos Gatur gagal ditambahkan!');

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
        $pos_gatur = PosGatur::findOrFail($id);
        
        $data = [
            'nama' => $request->edit_nama ? $request->edit_nama : $pos_gatur->nama,
            'longitude' => $request->edit_longitude ? $request->edit_longitude : $pos_gatur->longitude,
            'latitude' => $request->edit_latitude ? $request->edit_latitude : $pos_gatur->latitude,           
        ];

        $pos_gatur->update($data)
        ? Alert::success('Berhasil', "Pos Gatur telah berhasil diubah!")
        : Alert::error('Error', "Pos Gatur gagal diubah!");

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
        $pos_gatur = PosGatur::findOrFail($id);
       
        $pos_gatur->delete()
            ? Alert::success('Berhasil', "Pos Gatur telah berhasil dihapus.")
            : Alert::error('Error', "Pos Gatur gagal dihapus!");

        return redirect()->back();
    }

}
