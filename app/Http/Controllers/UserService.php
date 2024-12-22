<?php

namespace App\Http\Controllers;

use App\Jobs\DeletePendingUsersJob;
use App\Mail\VerificationCodeMail;
use App\Models\PendingUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserService
{
    use UplodeImageHelper;
    function generateUniqueVerificationCode()
    {
        do {
            $code = random_int(100000, 999999); // توليد رقم عشوائي
        } while (PendingUser::where('verfication_code', $code)->exists()); // التحقق من التكرار

        return $code;
    }

    public function register_pendding_user($request):array
    {

        // create a new user with the specified password and password hash and password confirmation code and
        $verificationCode = $this->generateUniqueVerificationCode();

        $pendingUser = PendingUser::create([
            'image_path' => 'users/profile_user.png',
            "first_name"=>$request['first_name'],
            "last_name"=>$request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'phone_number' => $request['phone_number'],
            'verfication_code' => $verificationCode,
        ]);




        Mail::to($pendingUser->email)->send(new VerificationCodeMail($verificationCode));
        DeletePendingUsersJob::dispatch()->delay(now()->addMinutes(10));

        $data = [
            'id' => $pendingUser->id,
            'first_name' => $pendingUser->first_name,
            'last_name'=>$pendingUser->last_name,
            'email' => $pendingUser->email,
            'phone_number' => $pendingUser->phone_number,
        ];

        $message = 'Verification code sent to your email.';
        $code = 200;

        // Send the token to the client and send it to the server with the authorization
        return ['data' =>$data,'message'=>$message,'code'=>$code];

    }


    public function register_user($request):array
    {
        // create a new instance of User object with the specified permissions

        $pendingUser = PendingUser::where('verfication_code', $request['verification_code'])->first();

        if (!$pendingUser) {
            return [
                'data' => [],
                'message' => 'Invalid verification code.',
                'code' => 400
            ];
        }

        $user = User::create([
            'image_path' => 'users/profile_user.png',
            "first_name"=>$pendingUser->first_name,
            "last_name"=>$pendingUser->last_name,
            'email' => $pendingUser->email,
            'password' => $pendingUser->password,
            'phone_number' => $pendingUser->phone_number,
        ]);


        // Assigning the client role to the user and giving the user all permissions of the client role

        $clientRole = Role::query()->where('name', '=', 'client')->first();
        $user->assignRole($clientRole);

        $permissions = $clientRole->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);


        // Creating a token for the user and sending it as a response
        $token = $user->createToken("api_token")->plainTextToken;


        $pendingUser->delete();

        // Send the token to the client and send it to the server with the authorization information in the response object and the user
        $data = [
            'id' => $user->id,
            'image_url' =>Storage::url($user->image_path),
            'first_name' => $user->first_name,
            'last_name'=>$user->last_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'roles' => $user->roles->pluck('name')->toArray(),
            'permissions' => $user->permissions->pluck('name')->toArray(),
            'token'=>$token
        ];

        $message = 'User created successfully';
        $code = 201;

        // Send the token to the client and send it to the server with the authorization
        return ['data' =>$data,'message'=>$message,'code'=>$code];

    }

    public function login($request):array
    {
        $user = User::query()->where('phone_number',$request['phone_number'])->first();

        if(!is_null($user))
        {

            if(!Hash::check($request['password'], $user->password))
            {
                $data = [];
                $message = 'Invalid password';
                $code = 401;
            }
            else
            {
                $token = $user->createToken("api_token")->plainTextToken;
                $data = [
                    'id' => $user->id,
                    'image_url' =>Storage::url($user->image_path),
                    'first_name' => $user->first_name,
                    'last_name'=>$user->last_name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'roles' => $user->roles->pluck('name')->toArray(),
                    'permissions' => $user->permissions->pluck('name')->toArray(),
                    'token'=>$token
                ];
                $code = 200;
                $message = 'User login successful';
            }

            return ['data' =>$data,'message'=>$message,'code'=>$code];
        }
        else
        {
            $data = [];
            $message  = 'Account not found';
            $code = 404;
            return ['data' =>$data,'message'=>$message,'code'=>$code];
        }


    }

    public function logout():array
    {
        $user = Auth::user();

        if(!is_null($user))
        {
            $user->currentAccessToken()->delete();
            $data = [];
            $message = 'User Logged out successfully';
            $code = 200;
        }
        else
        {
            $data = [];
            $message = 'invalid token';
            $code = 404;
        }

        return ['data' =>$data,'message'=>$message,'code'=>$code];

    }

    public function show_info():array
    {

        $data = [
            'id' => Auth::user()->id,
            'image_url' =>Storage::url(Auth::user()->image_path),
            'first_name' => Auth::user()->first_name,
            'last_name'=>Auth::user()->last_name,
            'email' => Auth::user()->email,
            'phone_number' => Auth::user()->phone_number,
            'image_url' =>Storage::url(Auth::user()->image_path)
        ];

        $message = '';
        $code = 200;

        return ['data' =>$data,'message'=>$message,'code'=>$code];

    }

    public function update_user_phone_number($request):array
    {
        Auth::user()->update([
            'phone_number' => $request['phone_number']
        ]);

        $message = 'The number has been modified successfully';
        $code = 200;

        $data = [
            'id' => Auth::user()->id,
            'image_url' =>Storage::url(Auth::user()->image_path),
            'first_name' => Auth::user()->first_name,
            'last_name'=>Auth::user()->last_name,
            'email' => Auth::user()->email,
            'phone_number' => Auth::user()->phone_number,
        ];

        return ['data' =>$data,'message'=>$message,'code'=>$code];

    }

    public function update_user_password($request):array
    {

        Auth::user()->update([
            'password' => Hash::make($request['password'])
        ]);

        $message = 'Password changed successfully';
        $code = 200;
        $data = [
            'id' => Auth::user()->id,
            'image_url' =>Storage::url(Auth::user()->image_path),
            'first_name' => Auth::user()->first_name,
            'last_name'=>Auth::user()->last_name,
            'email' => Auth::user()->email,
            'phone_number' => Auth::user()->phone_number,
        ];

        return ['data' =>$data,'message'=>$message,'code'=>$code];

    }

    public function check_user_password($request) :array
    {
        if(Hash::check( $request['password'],Auth::user()->password))
        {
            $data = [
                'id' => Auth::user()->id,
                'image_url' =>Storage::url(Auth::user()->image_path),
                'first_name' => Auth::user()->first_name,
                'last_name'=>Auth::user()->last_name,
                'email' => Auth::user()->email,
                'phone_number' => Auth::user()->phone_number,
            ];

            $message = 'The password is correct';
            $code = 200;
        }
        else
        {
            $data = [];
            $message = 'Current password is incorrect';
            $code = 401;
        }

        return ['data' =>$data,'message'=>$message,'code'=>$code];
    }

    public function delete_user($request):array
    {
        if(Hash::check($request->password,Auth::user()->password))
        {
            Auth::user()->delete();
            $data = [];
            $message = 'User deleted successfully';
            $code = 200;
        }
        else
        {
            $data = [];
            $message = 'Current password is incorrect';
            $code = 401;
        }

        return ['data' =>$data,'message'=>$message,'code'=>$code];

    }

    public function update_user_image_profile($request):array
    {
        Auth::user()->update([
            'image_path' => $this->uplodeImage($request->file('image'),'users')
        ]);

        $data = [
            'id' => Auth::user()->id,
            'image_url' =>Storage::url(Auth::user()->image_path),
            'first_name' => Auth::user()->first_name,
            'last_name'=>Auth::user()->last_name,
            'email' => Auth::user()->email,
            'phone_number' => Auth::user()->phone_number,
        ];

        $message = 'Profile updated successfully';
        $code = 200;

        return ['data' =>$data,'message'=>$message,'code'=>$code];

    }

}
