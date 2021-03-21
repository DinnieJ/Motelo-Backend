<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Collaborator\CollaboratorRepositoryInterface;
use App\Http\Requests\Collaborator\CreateCollaboratorRequest;
use App\Http\Requests\Collaborator\EditCollaboratorRequest;
use JWTAuth;

class CollaboratorController extends Controller
{
    private $collaboratorRepository;

    public function __construct(CollaboratorRepositoryInterface $collaboratorRepository)
    {
        $this->collaboratorRepository = $collaboratorRepository;
    }

    public function create(CreateCollaboratorRequest $request)
    {
        $data = $request->only('name', 'email', 'password', 'phone_number', 'address', 'date_of_birth', 'identity_number');
        $data['password'] = \bcrypt($data['password']);
        $data['enabled'] = 1;
        try {
            $newCollaborator = $this->collaboratorRepository->create($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong !'
            ], 200);
        }

        return response()->json([
            'message' => 'Tao cong tac vien thanh cong'
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        $profile = $this->collaboratorRepository->find($id);

        if ($profile) {
            $data = $request->all();
            if (isset($data['password'])) {
                $data['password'] = \bcrypt($data['password']);
            }
            foreach ($data as $key => $value) {
                $profile->{$key} = $value;
            }

            try {
                $profile->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Something went wrong'
                ], 500);
            }
            return response()->json([
                'message' => 'Update CTV thanh cong'
            ], 200);
        }

        return response()->json([
            'message' => 'ID not found'
        ], 200);
    }

    public function delete(EditCollaboratorRequest $request, $id)
    {
        $profile = $this->collaboratorRepository->find($id);
        if ($profile) {
            try {
                $profile->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }

            return response()->json([
                'message' => 'Xoa thanh cong CTV'
            ], 200);
        }
        
        return response()->json([
            'message' => 'Khong tim thay CTV'
        ], 200);
    }

    public function all(Request $request)
    {
        $data = $this->collaboratorRepository->paginate(10);

        return response()->json([
            $data
        ], 200);
    }
}
