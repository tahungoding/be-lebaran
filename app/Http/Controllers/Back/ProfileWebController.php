<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use Storage;
use Alert;

class ProfileWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['web'] = Web::all();
        return view('back.profile_web.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $logo = ($request->logo) ? $request->file('logo')->store("/public/input/profile_web") : null;
        
        $data = [
            'logo' => $logo,
            'primary_color' => $request->primary_color,
            'name' => $request->name,
            'description' => $request->description,
            'tagline' => $request->tagline,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'github' => $request->github,
            'instagram' => $request->instagram,
            'whatsapp' => $request->whatsapp,
            'updator' => '1',
        ];

        Web::create($data)
        ? Alert::success('Berhasil', 'Profile Web telah berhasil ditambahkan!')
        : Alert::error('Error', 'Profile Web gagal ditambahkan!');

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
        $web = Web::findOrFail($id);
        if($request->hasFile('edit_logo')) {
            if(Storage::exists($web->logo) && !empty($web->logo)) {
                Storage::delete($web->logo);
            }

            $edit_logo = $request->file("edit_logo")->store("/public/input/profile_web");
        }
        $data = [
            'logo' =>  $request->hasFile('edit_logo') ? $edit_logo : $web->logo,
            'primary_color' => $request->edit_primary_color ? $request->edit_primary_color : $web->primary_color,
            'name' => $request->edit_name ? $request->edit_name : $web->name,
            'description' => $request->edit_description ? $request->edit_description : $web->description,
            'tagline' => $request->edit_tagline ? $request->edit_tagline : $web->tagline,
            'address' => $request->edit_address ? $request->edit_address : $web->address,
            'phone' => $request->edit_phone ? $request->edit_phone : $web->phone,
            'email' => $request->edit_email ? $request->edit_email : $web->email,
            'facebook' => $request->edit_facebook ? $request->edit_facebook : $web->facebook,
            'instagram' => $request->edit_instagram ? $request->edit_instagram : $web->instagram,
            'youtube' => $request->edit_youtube ? $request->edit_youtube : $web->youtube,
            'twitter' => $request->edit_twitter ? $request->edit_twitter : $web->twitter,
            'whatsapp' => $request->edit_whatsapp ? $request->edit_whatsapp : $web->whatsapp,
            'updator' => '1',
        ];

        $web->update($data)
        ? Alert::success('Berhasil', "Profil Web telah berhasil diubah!")
        : Alert::error('Error', "Profil Web gagal diubah!");

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
        $web = Web::findOrFail($id);
       
        $web->delete()
            ? Alert::success('Berhasil', "Profil Web telah berhasil dihapus.")
            : Alert::error('Error', "Profil Web gagal dihapus!");

        return redirect()->back();
    }
}
