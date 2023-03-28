<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Ramsey\Uuid\Type\Integer;
use Validator;
use App\Http\Resources\UserResource;

class UserController extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel API",
     *      description="",
     *      @OA\Contact(
     *          email="karolpyt1999@gmail.com"
     *      ),
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/users",
     *     description="Gets a list of users",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */


    public function index()
    {
        $products = User::all();
        return $this->sendResponse(UserResource::collection($products), 'Users retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return $this->sendError('User not found.');
        }
        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $input = $request->all();
        $user = User::find($id);
        if (is_null($user)) {
            return $this->sendError('User not found.');
        }
        $validator = Validator::make($input, [
            'email' => 'email'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user->update(array_filter($request->all()));
        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
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
        if (is_null($user)) {
            return $this->sendError('User not found.');
        }
        $user->delete();
        return $this->sendResponse([], 'User deleted successfully.');
    }
}
