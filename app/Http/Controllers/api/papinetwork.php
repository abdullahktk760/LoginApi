<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\password_reset_token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class papinetwork extends Controller
{
    public function register(Request $req){
        $user=user::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req['password']),


        ]);
        return response()->json([
            'status'=>true,
            'Message'=>"Data Registred Successfully",
            'token'=>$user->createToken('apiToken')->plainTextToken,
        ]);
    }

    public function login(Request $req){
        $user=user::where('email',$req->email)->first();

        if(!$user || !Hash::check($req->password, $user->password)){
            return response('Login Inavalid',503);

        }
        return $user->createToken('apiToken')->plainTextToken;
    }



public function forget(Request $req){
try {
    
    $user = User::where('email',$req->email)->get();
    // return response()->json($user);
    if(count($user)>0 ){
        
        $token= Str::random(40);
        $domain=URL::to('/');

        $url=$domain.'/reset-password?token='.$token;
        $data['url']=$url;
        $data['email']=$req->email;
        $data['title']="Passord Reset ";
        
    Mail::send('html',['data'=> $data], function ($message) use ($data) {
        $message->to($data['email'])->subject($data['title']);});

    $date=Carbon::now()->format('Y-m-d');
    password_reset_token::updateOrCreate(
        ['email'=>$req->email],

        ['email'=>$req->email,
        'token'=>$token,
        'created_at'=>$date]
    );
   



    return response()->json(["succes"=>true,'msg'=>"passowrd reset send successful"]);

}
else{
    return response()->json(["succes"=>false,'msg'=>"User does not found"]);
}

}

catch (\Exception $e) {
    //throw $th;
    return response()->json([
        "success"=>false, 'msg'=>$e->getMessage()
    
        ]);
}



}    
    

public function resetpassword(Request $req){

    $resetdata=password_reset_token::where('token',$req->token)->first();
    // dd();

    if(isset($req->token)){
        $user=User::where('email',$resetdata->email)->first();
//  dd($user);
        return view('passwordreset',compact('user'));

    }
    else{
        return "not found";
    }
}

public function updatepassword(Request $req){
    
    $req->validate([
        'password'=>'required|string|min:5|confirmed'
    ]);

    $user=user::find($req->id);
    $user->password=Hash::make($req->password);
    $user->save();
    password_reset_token::where('email',$user->email)->delete();

    return "Password update successful";


}

}
