<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/12
 * Time: 10:20
 * Function:
 */

namespace App\Api\Controllers;


use App\Contracts\JwtAuthContract;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * @var JwtAuthContract
     */
    protected $auth;

    /**
     * AuthController constructor.
     * @param JwtAuthContract $authContract
     */
    public function __construct(JwtAuthContract $authContract)
    {
        $this->auth = $authContract;
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return $this->auth->login();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        return $this->auth->logout();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        return $this->auth->refresh();
    }
}