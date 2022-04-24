<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Models\Web;
use Alert;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['permission'] = Permission::all();
        $data['web'] = Web::all();
        return view('back.hak_akses.permission', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkPermissionName(Request $request) 
    {
        if($request->Input('name')){
            $name = Permission::where('name',$request->Input('name'))->first();
            if($name){
                return 'false';
            }else{
                return  'true';
            }
        }

        if($request->Input('edit_name')){
            $edit_name = Permission::where('name',$request->Input('edit_name'))->first();
            if($edit_name){
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
        $new = Permission::create(['name' => $request->name, 'guard_name' => 'web'])
        ? Alert::success('Berhasil', 'Permission telah berhasil ditambahkan!')
        : Alert::error('Error', 'Permission gagal ditambahkan!');

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
        $update = Permission::findOrFail($id);
        $update->name = $request->edit_name;
        $update->save()
        ? Alert::success('Berhasil', "Permission telah berhasil diubah.")
        : Alert::error('Error', "Permission gagal diubah!");

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
        $permission = Permission::findOrFail($id);
       
        $permission->delete()
            ? Alert::success('Berhasil', "Permission telah berhasil dihapus.")
            : Alert::error('Error', "Permission gagal dihapus!");

        return redirect()->back();
    }

    public function destroyAll()
    {
        $permission = Permission::all();

        foreach($permission as $permissions) {
            $permissions->delete();
        }

        (count(Permission::all()) <= 1)
        ? Alert::success('Berhasil', "Permission telah berhasil dihapus.")
        : Alert::error('Error', "Permission gagal dihapus!");

        return redirect()->back();
    }
}
