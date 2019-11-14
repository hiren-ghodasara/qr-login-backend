<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Frontend\Auth\UserRepository;
use Lcobucci\JWT\Parser;
use App\Models\Auth\User;
use App\Models\UniqueCode;
use Illuminate\Http\Request;
use App\Traits\PassportToken;
use App\Events\Api\UniqueCodeDecode;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use PassportToken;

    public function register(Request $request,UserRepository $userRepository)
    {
        //sleep(1);
        $request->validate([
            'first_name' => 'required|max:55',
            'last_name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        //return $validator->errors()->all()->toJson();
        $user = $user = $userRepository->create($request->only('first_name', 'last_name', 'email', 'password'));
        $token = $this->getBearerTokenByUser($user, 3, false);
        return response()->json($token);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid credentials'], 422);
        }
        //$accessToken = auth()->user()->createToken('authToken')->toArray();
        //dd($accessToken->);
        //return response(['user' => auth()->user(), 'access_token' => $accessToken, 'token_type' => 'Bearer']);

        //$objToken = auth()->user()->createToken('authToken');
        //$strToken = $objToken->accessToken;
        //$expiration = $objToken->token->expires_at->diffInSeconds(Carbon::now());

        $token = $this->getBearerTokenByUser(auth()->user(), 3, false);
        return response()->json($token);

    }

    public function logout(Request $request)
    {
        //sleep(5);
        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getHeader('jti');
        $token = $request->user()->tokens->find($id);
        $token->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function userList(Request $request)
    {
        $data = User::all();

        return response($data);
    }

    public function getQrCode(Request $request)
    {
        //sleep(1);
        //echo QrCode::generate('Make me into a QrCode!');die;
        //QrCode::generate('Make me into a QrCode!');
        $code = UniqueCode::create([
            'unique_code' => $this->getUniqueCode(70),
            'visitor' => $request->ip(),
            'channel_id' => uniqid(),
        ]);
        //var_dump($code);
        $data = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->margin(1)->size(400)->generate($code->unique_code));

        return response(['qr_code' => $data, 'channel_id' => $code->channel_id]);
        //<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">
    }

    public function getUniqueCode($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString . '&&' . uniqid(rand());
    }

    public function decodeQrCode(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required',
        ]);

        $code = UniqueCode::where('unique_code', '=', $validatedData['text'])->first();

        if ($code) {
            $code = UniqueCode::orderBy('created_at', 'desc')->first();
            $user = $request->user();
            $token = $this->getBearerTokenByUser($user, 3, false);
            $arr = ['code' => $code, 'token' => $token];

            event(new UniqueCodeDecode($arr));

            return response($arr);
        }

        return response(['message' => 'Invalid credentials']);
    }
}
