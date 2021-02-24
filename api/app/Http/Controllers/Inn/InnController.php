<?php

namespace App\Http\Controllers\Inn;

use App\Http\Requests\Inn\DetailInnRequest;
use App\Http\Requests\Inn\InnDetailRequest;
use App\Http\Resources\InnDetailResource;
use App\Models\Inn;
use App\Repositories\Inn\InnRepository;
use App\Repositories\Inn\InnRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Validation\Rules\In;

class InnController extends BaseController
{
    //
    protected $innRepository;


    /**
     * InnController constructor.
     * @param $innRepository
     */
    public function __construct(InnRepositoryInterface $innRepository)
    {
        $this->innRepository = $innRepository;
    }

    public function getDetailInn(Request $request, $id)
    {

        $inn = $this->innRepository->with(['rooms','features'])->find($id);

        if (!$inn) {
            return response()->json(null, 404);
        }
        return response()->json(new InnDetailResource($inn), 200);
    }


}
