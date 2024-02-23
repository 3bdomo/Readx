<?php
namespace App\Helpers;
class ApiResponse
{


    static public function SendResponse($code=200,$msg=null,$data=null)
    {

        $response =[
        'status'=>$code,
        'msg'=>$msg,
        'data'=>$data
        ];

        return Response()->json($response,$code);

    }

}
