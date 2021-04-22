<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;
use Config;
use App\Repositories\Owner\OwnerRepositoryInterface;
use App\Repositories\OwnerContact\OwnerContactRepositoryInterface;
use App\Repositories\OwnerImage\OwnerImageRepositoryInterface;
use App\Http\Requests\Owner\OwnerLoginRequest;
use App\Http\Requests\Owner\OwnerRegisterRequest;
use App\Traits\FileHelper;

class OwnerAuthController extends BaseController
{
    use FileHelper;

    private $ownerRepository;
    private $ownerContactRepository;
    private $ownerImageRepository;

    public function __construct(
        OwnerRepositoryInterface $ownerRepository,
        OwnerContactRepositoryInterface $ownerContactRepository,
        OwnerImageRepositoryInterface $ownerImageRepository
    ) {
        $this->ownerRepository = $ownerRepository;
        $this->ownerContactRepository = $ownerContactRepository;
        $this->ownerImageRepository = $ownerImageRepository;
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
        $user = auth('owner')->user()->load(['contacts', 'image']);
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
            $this->ownerContactRepository->create([
                'owner_id' => $newOwner->id,
                'contact_type_id' => 1,
                'content' => $newOwner->email
            ]);
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

    public function update(Request $request)
    {
        $data = $request->only('name', 'date_of_birth', 'address');
        $contacts = $request->contacts;

        $image = $request->file('image') ?? null;
        $user = auth('owner')->user();
        $ownerImage = $user->image;
        
        try {
            foreach ($data as $key => $item) {
                $user->{$key} = $item;
            }
            
            if ($contacts) {
                $this->ownerContactRepository->where('owner_id', $user->id)->delete();
                foreach ($contacts ?? [] as $contact) {
                    $this->ownerContactRepository->create(\json_decode($contact, true));
                }
            }

            if ($image) {
                if ($ownerImage) {
                    \Storage::disk('s3')->delete("/owners/$user->id/$ownerImage->filename");
                    
                    $uploadImg = \Storage::disk('s3')->put("/owners/$user->id", $image);

                    $s3FileName = $this->getS3Filename($uploadImg);
                    $this->ownerImageRepository->update([
                        'filename' => $s3FileName,
                        'image_url' => \Config::get('filesystems.s3_folder_path') . $uploadImg
                    ], $ownerImage->id);
                } else {
                    $uploadImg = \Storage::disk('s3')->put("owners/$user->id", $image);
                    
                    $s3FileName = $this->getS3Filename($uploadImg);

                    $this->ownerImageRepository->create([
                        'original_filename' => $image->getClientOriginalName(),
                        'owner_id' => $user->id,
                        'filename' => $s3FileName,
                        'image_url' => \Config::get('filesystems.s3_folder_path') . $uploadImg
                    ]);
                }
            }

            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 502);
        }

        return response()->json([
            'message' => 'Cap nhat thanh cong',
            'user' => auth('owner')->user()->load(['contacts', 'image'])
        ], 200);
    }

    public function getAuthUser(Request $request)
    {
        $user = auth('owner')->user()->load(['contacts', 'image']);
        return response()->json($user, 200);
    }
}
