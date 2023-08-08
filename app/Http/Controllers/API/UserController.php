<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class UserController extends BaseController
{
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            // 'new_password' => 'required|confirmed|min:6',
            'new_password' => 'required|min:6',
        ]);
        if ($validator->fails()) return $this->sendError('VALIDATION_ERROR', $validator->errors(), 200);

        $logged_user = Auth::user();
        if (!Hash::check($request->current_password, $logged_user->password)) {
            // The current passwords is not correct...
            return $this->sendError('PASSWORD_MISMATCH');
        }
        $logged_user->password = bcrypt($request->new_password); //
        // $logged_user->should_reset_password = 0;

        if ($logged_user->save()) {
            $logged_user->createToken('AuthToken')->accessToken;

            return $this->sendResponse(new UserResource($logged_user), 'UPDATE_SUCCESS');
        } else return $this->sendError('UPDATE_FAILED', 403);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
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
        //
    }
}
