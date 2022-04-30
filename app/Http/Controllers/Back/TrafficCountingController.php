<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use App\Models\TrafficCounting;
use Alert;
use Storage;
use File;

class TrafficCountingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['traffic_counting'] = TrafficCounting::all();
        $data['web'] = Web::all();
        return view('back.traffic_counting.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function status(Request $request, $id)
    {
        $traffic_counting = TrafficCounting::where('id', $id)->first();

            $data = [   
                'status' => $request->status
            ];

        $traffic_counting->update($data)
        ? Alert::success('Berhasil', "Status Traffic Counting telah berhasil diubah!")
        : Alert::error('Error', "Status Traffic Counting gagal diubah!");

        return redirect()->back();
    }

    public function create()
    {
        $data['web'] = Web::all();

        return view('back.traffic_counting.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');

            $gambar = config('app.url') . '/images/traffic_counting/' .  time() . "_" . $file->getClientOriginalName();

            $tujuan_upload = public_path('images/traffic_counting');

            $file->move($tujuan_upload, $gambar);
            
        } else {
            $gambar = null;
        }

        $data = [
            'gambar' => $gambar,
            'status' => 'on',
        ];

        TrafficCounting::create($data)
        ? Alert::success('Berhasil', 'Data Traffic Counting telah berhasil ditambahkan!')
        : Alert::error('Error', 'Data Traffic Counting gagal ditambahkan!');

        return redirect()->route('traffic-counting.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['traffic_counting'] = TrafficCounting::find($id);
        $data['web'] = Web::all();

        return view('back.traffic_counting.edit', $data);
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
        $traffic_counting = TrafficCounting::findOrFail($id);
        
        if ($request->hasFile('edit_gambar')) {

            $StoredImage = public_path("images/traffic_counting/{$traffic_counting->gambar}");
            if (File::exists($StoredImage) && !empty($traffic_counting->gambar)) {
                unlink($StoredImage);
            }

            $file = $request->file('edit_gambar');

            $edit_gambar = config('app.url') . '/images/traffic_counting/' . time() . "_" . $file->getClientOriginalName();

            $tujuan_upload = public_path('images/traffic_counting');

            $file->move($tujuan_upload, $edit_gambar);
        }
        
        $data = [
            'gambar' => $request->hasFile('edit_gambar') ? $edit_gambar : $traffic_counting->gambar,          
            'status' => $request->edit_status ? $request->edit_status : $traffic_counting->status,
        ];

        $traffic_counting->update($data)
        ? Alert::success('Berhasil', "Traffic Counting telah berhasil diubah!")
        : Alert::error('Error', "Traffic Counting gagal diubah!");

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
        $traffic_counting = TrafficCounting::findOrFail($id);
       
        $traffic_counting->delete()
            ? Alert::success('Berhasil', "Traffic Counting telah berhasil dihapus.")
            : Alert::error('Error', "Traffic Counting gagal dihapus!");

        return redirect()->back();
    }
}
