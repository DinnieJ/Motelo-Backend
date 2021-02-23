<?php

namespace App\Http\Controllers\Inn;

use App\Http\Requests\Inn\DetailInnRequest;
use App\Http\Requests\Inn\InnDetailRequest;
use App\Repositories\Inn\InnRepository;
use App\Repositories\Inn\InnRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class InnController extends BaseController
{
    //
    protected $innRepository;
    protected $innRepositoryInterface;

    /**
     * InnController constructor.
     * @param $innRepository
     * @param $innRepositoryInterface
     */
    public function __construct(InnRepository $innRepository, InnRepositoryInterface $innRepositoryInterface)
    {
        $this->innRepository = $innRepository;
        $this->innRepositoryInterface = $innRepositoryInterface;
    }

    public function getDetailInn(Request $request, $id)
    {
        
        $inn = $this->innRepository->find($id);
        if (!$inn) {
            return response()->json(null, 404);
        }
        return response()->json($inn, 200);
    }


}
