<?php
/**
 * User: jithinvijayan
 * Date: 27/02/19
 * Time: 3:02 PM
 */

namespace App\Http\Controllers\API;


use App\Models\Roles;
use App\Models\User;
use Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Storage;

class UserController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->sendResponse($users->toArray(), 'Users retrieved successfully.');
    }


    /**
     * Register api
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'nullable',
            'mobile_number' => 'required|unique:users',
            'country' => 'nullable',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:16',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->sendJsonError('Validation Error.', $errors);
        }
        $input = $request->all();
        $input['user_id'] = Uuid::uuid4();
        $input['activation_token'] = str_shuffle(substr(str_repeat(md5(mt_rand()), 2 + 60 / 32), 0, 60));
        $input['role_id'] = Roles::where('name', '=', 'USER')->first()->role_id;
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
        Storage::put('avatars/' . $user->user_id . '/avatar.png', (string)$avatar);
//        $user->notify(new SignupActivate($user));
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->first_name;
        return $this->sendResponse($success, 'User register successfully.');
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json(['message' => "This activation token is invalid"], 404);
        }
        $user->is_active = true;
        $user->activation_token = '';
        $user->email_verified_at = now()->timestamp;
        $user->save();
    }
}