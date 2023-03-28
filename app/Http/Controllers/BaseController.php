<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel API",
     *      description="",
     *      @OA\Contact(
     *          email="admin@example.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_LOCALHOST,
     *      description="Local server"
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_TESTINGHOST,
     *      description="Testing server"
     * )

     *
     * @OA\Tag(
     *     name="User",
     *     description="User API"
     * )
     *
     * @OAS\SecurityScheme(
     *      securityScheme="Authentication_Bearer_Token",
     *      type="http",
     *      scheme="bearer"
     * )
     *
     */

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
