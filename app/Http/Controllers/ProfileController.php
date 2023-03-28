<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\UserResource;

class ProfileController extends BaseController
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'email' => 'email'
        ]);

        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());
        if (!empty($request->file('image'))) {
            $request['avatar'] = $request->file('image')->store('public/avatars');
        }

        $user->update(array_filter($request->all()));
        return $this->sendResponse(new ProfileResource(Auth::user()), 'Profile updated successfully.');
    }
}
