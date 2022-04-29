<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use App\Models\User;
use Storage;
use Alert;
use Hash;
use Auth;
use File;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['web'] = Web::all();
        return view('auth.login.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function profile()
    {
        $data['web'] = Web::all();
        return view('back.profile.index', $data);
    }

    public function checkProfileUsername(Request $request) 
    {
        if($request->Input('username')){
            $username = User::where('username',$request->Input('username'))->first();
            if($username){
                return 'false';
            }else{
                return  'true';
            }
        }
    }

    public function checkProfileEmail(Request $request) 
    {
        if($request->Input('email')){
            $email = User::where('email',$request->Input('email'))->first();
            if($email){
                return 'false';
            }else{
                return  'true';
            }
        }
    }

    public function profileUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->hasFile('photo')) {

            $StoredImage = public_path("images/user/{$user->photo}");
            if (File::exists($StoredImage) && !empty($user->photo)) {
                unlink($StoredImage);
            }

            $file = $request->file('photo');

            $photo = config('app.url') . '/images/user/' . time() . "_" . $file->getClientOriginalName();

            $tujuan_upload = public_path('images/user');

            $file->move($tujuan_upload, $photo);
        }
        
        $data = [
            'fullname' => $request->fullname ? $request->fullname : $user->fullname,
            'username' => $request->username ? $request->username : $user->username,
            'email' => $request->email ? $request->email : $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'photo' => $request->hasFile('photo') ? $photo : $user->photo,
        ];

        $user->update($data)
        ? Alert::success('Berhasil', "User telah berhasil diubah!")
        : Alert::error('Error', "User gagal diubah!");

        return redirect()->back();
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
        $remember = $request->remember ? true : false;
        
        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt(array('username' => $input['username'], 'password' => $input['password']), $remember)) {
            $userId = User::findOrFail(Auth::id());
            $userId->update([
                'last_login_at' => date('Y-m-d H:i:s')  
            ]);
            return redirect()->route('dashboard.index');
        } else {
            Alert::error('Error', 'Username atau Password salah!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login.index');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
    }
}
