<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Intervention\Image\Facades\Image;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'education_level',
        'location',
        'gender',
        'languages',
        'dob',
        'role',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function Registration($request)
    {
        try {
            $emailExists = User::where('email', $request->email)->first();
            if ($emailExists) {
                $response = [
                    'type' => "error",
                    'message' => "Email address already exist."
                ];
            } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'status' => 0,
                    'role' => $request->role
                ]);
                if ($user) {
                    $response = [
                        'type' => "success",
                        'message' => "Registration successfully completed. Please click the below login link."
                    ];
                } else {
                    $response = [
                        'type' => "error",
                        'message' => "Something went wrong! Please try again!"
                    ];
                }
            }
        } catch (\Exception $e) {
            $response = [
                'type' => "error",
                'message' => "Something went wrong! Please try again!"
            ];
            Log::info($e->getMessage());
        }

        return $response;
    }

    public static function Login($request)
    {
        try {
            $message = $token = '';
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                $type = "error";
                $message = "Invalid email/password.";
            } else if ($user->status != 0) {
                $type = "error";
                $message = "Your account is inactive. Please contact the admin.";
            } else {
                $type = "success";
                $message = "You are successfully logged in";
                $token = $user->createToken('myapptoken')->plainTextToken;
            }

            $response = [
                'type' => $type,
                'user' => $user,
                'token' => $token,
                'message' => $message
            ];
        } catch (\Exception $e) {
            $response = [
                'type' => "error",
                'message' => "Something went wrong! Please try again!"
            ];
            Log::info($e->getMessage());
        }

        return $response;
    }

    public static function Logout($request)
    {
        try {
            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();

            $response = [
                'type' => "success"
            ];
        } catch (\Exception $e) {
            $response = [
                'type' => "errror"
            ];
            Log::info($e->getMessage());
        }
        return $response;
    }

    public static function updateUser($request)
    {
        try {
            $message =  $type = ""; $data=[];
            $userData = json_decode($request->input('user_data'));

            $userDetail = User::find($userData->id);
            if ($request->hasFile('profile_image')) {
            $imageName = time() . '.' . $request->profile_image->extension();
            $imagePath = 'public/images/' . $imageName;
            $fullImagePath = storage_path('app/' . $imagePath);

            Image::make($request->file('profile_image'))
                ->resize(150, 150)
                ->save($fullImagePath, 90);
            }else{
                $imageName=$userDetail->profile_image;
            }
           
            if ($userDetail) {
                $data = [
                    'name' => $userData->name,
                    'phone' => $userData->phone,
                    'education_level' => $userData->education_level,
                    'location' => $userData->location,
                    'dob' => $userData->dob,
                    'languages' => $userData->languages,
                    'gender' => $userData->gender,
                    'profile_image' => $imageName
                ];

                if ($userDetail->update($data)) {
                    $data=$userDetail;
                    $type = "success";
                    $message = "Profile updated successfully";
                } else {
                    $type = "error";
                    $message = "Failed to update profile";
                }
            } else {
                $type = "error";
                $message = "User not found";
            }
            $response = [
                'data' => $data,
                'type' => $type,
                'message' => $message
            ];
        } catch (\Exception $e) {
            $response = [
                'type' => "error",
                'message' => "Something went wrong! Please try again!"
            ];
            Log::info($e->getMessage());
        }
        return $response;
    }

    public static function fetchUser($id)
    {
        $user = User::where('id', $id)->first();
        $response = [
            'user' => $user
        ];
        return $response;
    }
}
