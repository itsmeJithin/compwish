<?php
/**
 * User: jithinvijayan
 * Date: 12/03/19
 * Time: 6:14 PM
 */

namespace App\Http\Controllers\API;


use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasswordResetController extends BaseController
{
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user)
            return $this->sendError(
                "We can't find a user with that e-mail address.", [], 404);
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_shuffle(substr(str_repeat(md5(mt_rand()), 2 + 60 / 32), 0, 60))
            ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        return $this->sendResponse(null, 'We have e-mailed your password reset link.');
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return \Illuminate\Http\Response
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return $this->sendError(
                'This password reset token is invalid.', [], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return $this->sendError(
                'This password reset token is invalid.', [], 404);
        }
        return $this->sendResponse($passwordReset, '');
    }

    /**
     * Reset password
     *
     * @param Request $request
     * @return \Illuminate\Http\Response [string] message
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return $this->sendError(
                'This password reset token is invalid.', [], 404);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return $this->sendError(
                "We can't find a user with that e-mail address.", [], 404);
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return $this->sendResponse($user, "Password changed successfully");
    }

}