<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Web;
use Alert;

class ManajemenUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'pos') {
            return redirect()->back();
        }
        
        $data['user'] = User::orderBy('id')->get();
        $data['web'] = Web::all();

        return view('back.manajemen_user.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    function checkUsername(Request $request)
    {
        if($request->Input('username')){
            $username = User::where('username',$request->Input('username'))->first();
            if($username){
                return 'false';
            }else{
                return  'true';
            }
        }

        if($request->Input('edit_username')){
            $checkUsername = User::where('username',$request->Input('edit_username'))->first();
            if($checkUsername){
                return 'false';
            }else{
                return  'true';
            }
        }
    }

    function checkEmail(Request $request)
    {
        if($request->Input('email')){
            $email = User::where('email',$request->Input('email'))->first();
            if($email){
                return 'false';
            }else{
                return  'true';
            }
        }

        if($request->Input('edit_email')){
            $checkEmail = User::where('email',$request->Input('edit_email'))->first();
            if($checkEmail){
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
        $this->validate($request, [
            'fullname' => 'required|string|min:3|max:35',
            'username' => 'required|string|min:3|unique:users|max:35',
            'email' => 'required|string|min:5|unique:users|max:35',
            'password' => 'required|confirmed',
            'role' => 'required',
        ]);

        $data = [
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];


        User::create($data)
            ? Alert::success('Sukses', "Users berhasil ditambahkan.")
            : Alert::error('Error', "Users gagal ditambahkan!");
            
        return redirect(route('manajemen-user.index'));
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
        $user = User::find($id);
        
        $this->validate($request, [
            'edit_fullname' => 'required|string|min:3|max:35',
            'edit_username' => "required|string|min:3",
            'edit_email' => "required|string|min:5",
            'edit_role' => 'required',
        ]);

        
        $data = [
            'fullname' => $request->edit_fullname,
            'username' => $request->edit_username,
            'email' => $request->edit_email,
            'role' => $request->edit_role,
        ];

        $user->update($data)
            ? Alert::success('Sukses', "User berhasil diubah.")
            : Alert::error('Error', "User gagal diubah!");

        return redirect(route('manajemen-user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete()
            ? Alert::success('Sukses', "User berhasil dihapus.")
            : Alert::error('Error', "User gagal dihapus!");
        return redirect(route('manajemen-user.index'));
    }
}
