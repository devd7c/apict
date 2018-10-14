<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private $client;

    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where('id', '=', 1)->first();
    }

    protected  function authenticate(Request $request)
    {
        $request->request->add([
            'grant_type' => 'password',
            'username' => $request->email,
            'password' => $request->password,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret
            //'scope' => ''
        ]);

        //return response()->json([$this->client]);
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );


        return \Route::dispatch($proxy);

        //$data = $this->getAccess($request);

        //return response()->json(['data' => 'sdsd']);

    }

    public function signup(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return $this->showOne($user, 201);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|string',
            'password' => 'required|min:6|string',
            'remember_me' => 'boolean'
        ];

        $this->validate($request, $rules);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();


        /*$request->request->add([
            'grant_type' => 'password',
            'username' => $request->email,
            'password' => $request->password,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);*/

        /*$tokenResult = $user->createToken('Laravel Personal Access Client');
        $token = $tokenResult->token;*/

        //$token = $user->createToken('password')->accessToken;


        /*if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();*/

        return response()->json([$user]);

        /*return response()->json([
            'id' => $user->id,
            'username' => $user->email,
            'email' => $user->email,
            'roles' => $user->admin,
            'fullName' =>$user->name,
            'accessToken' => $tokenResult->accessToken,
            'tokenType' => 'Bearer',
            'expiresAt' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);*/
    }
}
