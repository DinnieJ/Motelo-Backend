<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\Collaborator\CollaboratorRepositoryInterface;
use App\Repositories\Owner\OwnerRepositoryInterface;
use App\Repositories\Tenant\TenantRepositoryInterface;
use App\Traits\Randomizer;
use App\Jobs\SendEmail;

class AuthController extends BaseController
{
    use Randomizer;

    private $collaboratorRepository;
    private $tenantRepository;
    private $ownerRepository;


    public function __construct(
        CollaboratorRepositoryInterface $collaboratorRepository,
        TenantRepositoryInterface $tenantRepository,
        OwnerRepositoryInterface $ownerRepository
    ) {
        $this->collaboratorRepository = $collaboratorRepository;
        $this->tenantRepository = $tenantRepository;
        $this->ownerRepository = $ownerRepository;
    }

    public function changePassword(Request $request)
    {
        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $role = \JwtAuth::getPayload()->get('role');
        $user = auth($role)->user();

        if (!\Hash::check($old_password, $user->password)) {
            return response()->json([
                'message' => 'Mật khẩu cũ không khớp'
            ], 400);
        }

        try {
            $user->password = bcrypt($new_password);
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 502);
        }

        return response()->json([
            'message' => 'Đổi mật khẩu thành công'
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $role = $request->role;
        $email = $request->email;

        try {
            $user = null;
            $roleString = null;
            switch ($role) {
                case 'Tenant':
                    $user = $this->tenantRepository->where('email', $email)->first();
                    $roleString = 'Nguời dùng';
                    break;
                case 'Owner':
                    $user = $this->ownerRepository->where('email', $email)->first();
                    $roleString = 'Người chủ trọ';
                    break;
                case 'Collaborator':
                    $user = $this->collaboratorRepository->where('email', $email)->first();
                    $roleString = 'Cộng tác viên';
                    break;
            }

            if (!$user) {
                return response()->json([
                    'message' => 'Email không tồn tại'
                ], 400);
            }
            
            $newPassword = $this->randomString(12);

            $user->password = $newPassword;
            $user->save();

            SendEmail::dispatch([
                'to' => $email,
                'password' => $newPassword,
                'roleString' => $roleString
            ]);
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'message' => 'ok'
        ], 200);
    }
}
