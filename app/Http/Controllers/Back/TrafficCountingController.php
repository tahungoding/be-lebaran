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
        $data['traffic_counting'] = TrafficCounting::all();

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
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $traffic_counting = TrafficCounting::all();
            foreach($traffic_counting as $tk) {
                $tk->delete();
            }

            $FolderToDelete = public_path('images/traffic_counting');
            $fs = new \Illuminate\Filesystem\Filesystem;
            $fs->cleanDirectory($FolderToDelete);   

            foreach ($file as $images) {
                $gambar = config('app.url') . '/images/traffic_counting/' .  time() . "_" . $images->getClientOriginalName();

                $tujuan_upload = public_path('images/traffic_counting');
    
                $images->move($tujuan_upload, $gambar);
                
              
                TrafficCounting::create([
                    'gambar' => $gambar,
                ]);
            }
            
        } 
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
