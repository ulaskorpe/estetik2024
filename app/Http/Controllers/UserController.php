<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
 
use App\Traits\HttpResponses;
use App\Http\Controllers\Helpers\GeneralHelper;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;
class UserController extends Controller
{

    use HttpResponses;

    public function login(){
        return view('admin.login');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       return view('admin.panel.users.index',['users'=>User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        
        $ch = true ;
        while($ch){
            $user_code = rand(100000,999999);
            $u = User::where('admin_code','=',$user_code)->first();
            $ch  = (!empty($user['id']))?true:false;

        }

        return view('admin.panel.users.create',['user_code'=>$user_code]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
 
        
        $password = GeneralHelper::randomPassword(8,1);
        Session::put('password',  $password);
        $user = new User();
         $user->email= $request['email'];
         $user->admin_code= $request['admin_code'];
         $user->name= $request['name'];
         $user->phone_number= $request['phone_number'];

        $user->password= Hash::make($password);

        $user->save();
         $file = $request->file('avatar');
         if(!empty($file) && !empty($user)){
         $ext = GeneralHelper::findExtension($file->getClientOriginalName());
         if (in_array($ext, $this->allowed_array)) {
      
             if (!empty($file)) {
                 $path = public_path("files/users/" . $user['id']);
                 $filename = GeneralHelper::fixName($request['name']) . "_" . date('YmdHis') . "." . GeneralHelper::findExtension($file->getClientOriginalName());
                 $file->move($path, $filename);
                 $user->avatar = $filename;
                 $user->save();
            

             $path = public_path("files/users/" . $user['id'] . "/" . $filename);

 
                $resizedImage = Image::make($path)->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

 
            $resizedImage->save(public_path("files/users/" . $user['id'] . "/200".$filename));
                }

         }
        }

        
        
        return  $this->success([''],"Kullanıcı eklendi" ,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.panel.users.update' ,['user'=>User::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
   
        $user = User::find( $request['id']);
         $user->email= $request['email'];
  
         $user->name= $request['name'];
         $user->phone_number= $request['phone_number'];
 
         $file = $request->file('avatar');
         if(!empty($file) && !empty($user)){
         $ext = GeneralHelper::findExtension($file->getClientOriginalName());
         if (in_array($ext, $this->allowed_array)) {
      
             if (!empty($file)) {
                 $path = public_path("files/users/" . $user['id']);
                 $filename = GeneralHelper::fixName($request['name']) . "_" . date('YmdHis') . "." . GeneralHelper::findExtension($file->getClientOriginalName());
                 $file->move($path, $filename);
                 $user->avatar = $filename;
               
            

             $path = public_path("files/users/" . $user['id'] . "/" . $filename);

 
                $resizedImage = Image::make($path)->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

 
            $resizedImage->save(public_path("files/users/" . $user['id'] . "/200".$filename));
                }

         }
        }

        $user->save();

        
        
        return  $this->success([''],"Kullanıcı güncellendi" ,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {   $folder= public_path("files/users/" . $request['id']) ;
        if(is_dir($folder)){
        $files = glob($folder . '/*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    } elseif (is_dir($file)) {
        // Recursively delete sub-folders
      //  deleteFolder($file);
    }
    }
        rmdir(public_path("files/users/" . $request['id'] ));
    }
        User::where('id','=',$request['id'])->delete();
        //return $request;
        return redirect()->route('users.index');
    }
}
