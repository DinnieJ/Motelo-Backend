<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BannerPost\BannerPostRepositoryInterface;
use App\Repositories\BannerPostImage\BannerPostImageRepositoryInterface;
use App\Traits\FileHelper;
use App\Http\Resources\BannerResource;

class BannerPostController extends Controller
{
    use FileHelper;

    private $bannerPostRepository;
    private $bannerPostImageRepository;

    public function __construct(
        BannerPostRepositoryInterface $bannerPostRepository,
        BannerPostImageRepositoryInterface $bannerPostImageRepository
    ) {
        $this->bannerPostRepository = $bannerPostRepository;
        $this->bannerPostImageRepository = $bannerPostImageRepository;
    }

    public function all(Request $request)
    {
        $banners = $this->bannerPostRepository->getAll($request)->toArray();
        
        $banners['data'] = array_map(function ($item) {
            return new BannerResource($item);
        }, $banners['data']);

        return response()->json($banners, 200);
    }

    public function get($id)
    {
        $data = $this->bannerPostRepository->getBanner($id);
        
        if ($data) {
            return response()->json(new BannerResource($data), 200);
        }

        return response()->json(null, 404);
    }

    public function store(Request $request)
    {
        $data = $request->except('image');
        $image = $request->file('image');

        $data['created_by'] = auth('collaborator')->user()->id;
        try {
            $newBanner = $this->bannerPostRepository->create($data);
            $uploadImg = \Storage::disk('s3')->put("/banners/{$newBanner->id}", $image);

            $this->bannerPostImageRepository->create([
                'banner_id' => $newBanner->id,
                'image_url' => \Config::get('filesystems.s3_folder_path') . $uploadImg,
                'filename' => $this->getS3Filename($uploadImg)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 502);
        }

        return response()->json([
            'message' => 'Tạo banner thành công'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('image');
        
        $image = $request->file('image') ?? null;

        $banner = $this->bannerPostRepository->find($id);
        if (!$banner) {
            return response()->json([
                'message' => 'Không tìm thấy banner hoặc banner đã được xóa'
            ], 404);
        }

        try {
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 502);
        }
    }

    public function delete($id)
    {
        $banner = $this->bannerPostRepository->find($id);

        if ($banner) {
            $banner->delete();
            return response()->json([
                'message' => 'Xóa banner thành công'
            ], 200);
        }

        return response()->json([
            'message' => 'Không tìm thấy banner hoặc banner đã được xóa'
        ], 404);
    }

    public function getHomepageBanner()
    {
        $data = $this->bannerPostRepository->getHomepageBanner();

        $banners = array_map(function ($item) {
            return new BannerResource($item);
        }, $data->toArray());

        return response()->json($banners, 200);
    }
}
