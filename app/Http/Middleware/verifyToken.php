<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class verifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $token= $request->token;
            if($token){
                $user = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
            }
        }catch(Exception $e){
            if($e instanceof  TokenInvalidException){
               return response()->json(['msg'=>'Token is Invalid'],401);

           }elseif($e instanceof  TokenExpiredException){
               return response()->json(['msg'=>'Token is Expired']);
           }else{
            return response()->json(['msg'=>"another exception"]);

               }
        }   
        return $next($request);
           }
           
}
