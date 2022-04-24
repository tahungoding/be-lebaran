<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Role_has_permission;
use App\Models\Web;
use Alert;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['role'] = Role::all();
        $data['permission'] = Permission::all();
        $data['web'] = Web::all();
        return view('back.hak_akses.role', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkRoleName(Request $request) 
    {
        if($request->Input('role')){
            $role = Role::where('name',$request->Input('role'))->first();
            if($role){
                return 'false';
            }else{
                return  'true';
            }
        }

        if($request->Input('edit_name')){
            $edit_name = Role::where('name',$request->Input('edit_name'))->first();
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
        $new = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        $new->syncPermissions($request->permission)
        ? Alert::success('Berhasil', 'Role telah berhasil ditambahkan!')
        : Alert::error('Error', 'Role gagal ditambahkan!');

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
        $update = Role::findOrFail($id);
        $update->name = $request->edit_name;
        $update->syncPermissions($request->edit_permission);
        $update->save()
        ? Alert::success('Berhasil', 'Role telah berhasil diubah!')
        : Alert::error('Error', 'Role gagal diubah!');

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
        $role = Role::findOrFail($id);
       
        $role->delete()
            ? Alert::success('Berhasil', "Role telah berhasil dihapus.")
            : Alert::error('Error', "Role gagal dihapus!");

        return redirect()->back();
    }

    public function destroyAll()
    {
        $role = Role::all();

        foreach($role as $roles) {
            $roles->delete();
        }

        (count(Role::all()) <= 1)
        ? Alert::success('Berhasil', "Role telah berhasil dihapus.")
        : Alert::error('Error', "Role gagal dihapus!");

        return redirect()->back();
    }
}
