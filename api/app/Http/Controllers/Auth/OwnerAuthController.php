<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;
use Config;
use App\Repositories\Owner\OwnerRepositoryInterface;
use App\Repositories\OwnerContact\OwnerContactRepositoryInterface;
use App\Http\Requests\Owner\OwnerLoginRequest;
use App\Http\Requests\Owner\OwnerRegisterRequest;

class OwnerAuthController extends BaseController
{
    private $ownerRepository;
    private $ownerContactRepository;

    public function __construct(
        OwnerRepositoryInterface $ownerRepository,
        OwnerContactRepositoryInterface $ownerContactRepository
    ) {
        $this->ownerRepository = $ownerRepository;
        $this->ownerContactRepository = $ownerContactRepository;
    }

    public function login(OwnerLoginRequest $request)
    {
        $creds = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = auth('owner')->attempt($creds)) {
                return response()->json([
                    'message' => 'invalid_email_or_password',
                ], 406);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], 502);
        }
        $user = auth('owner')->user()->with('contacts')->get();
        //dd($user);
        return response()->json([
            'type' => 'Bearer',
            'role' => 'Owner',
            'TTL' => Config::get('jwt.ttl'),
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        try {
            JWTAuth::invalidate($token);

            return response()->json([
                'message' => 'Logout successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], 502);
        }
    }

    public function register(OwnerRegisterRequest $request)
    {
        $data = $request->only('name', 'email', 'date_of_birth', 'address', 'password', 'contacts');
        $data['password'] = bcrypt($data['password']);

        $newOwner = null;
        try {
            $newOwner = $this->ownerRepository->create($data);
            foreach ($data['contacts'] ?? [] as $contact) {
                $this->ownerContactRepository->create([
                    'owner_id' => $newOwner->id,
                    'contact_type_id' => $contact['type'],
                    'content' => $contact['content']
                ]);
            }
            return response()->json([
                'message' => 'Register successful',
                'owner' => $newOwner
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e
            ], 502);
        }
    }
    public function getAuthUser(Request $request)
    {
        return response()->json(auth('owner')->user()->with('contacts')->get());
    }
}
