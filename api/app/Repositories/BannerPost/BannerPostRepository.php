<?php


namespace App\Repositories\BannerPost;

use App\Models\BannerPost;
use Prettus\Repository\Eloquent\BaseRepository;
use Carbon\Carbon;

class BannerPostRepository extends BaseRepository implements BannerPostRepositoryInterface
{
    public function model()
    {
        // TODO: Implement model() method.
        return BannerPost::class;
    }

    public function getAll($request)
    {
        $query = $this->with('image');

        $status = $request->query('status') ?? 0;

        $currentDate = Carbon::now()->format('Y-m-d');

        switch ($status) {
            case BannerPost::STATUS_EXPIRED:
                $query = $query->whereDate('end_time', '<', $currentDate);
                break;

            case BannerPost::STATUS_FUTURE:
                $query = $query->whereDate('start_time', '>', $currentDate);
                break;

            case BannerPost::STATUS_CURRENT:
                $query = $query->whereDate('start_time', '<=', $currentDate)
                               ->whereDate('end_time', '>=', $currentDate);
                break;

            default:
                break;
        }

        $data = $query->paginate(6)->withQueryString();
        
        return $data;
    }

    public function getBanner($id)
    {
        $data = $this->with('image')->find($id);

        return $data;
    }

    public function getHomepageBanner()
    {
        $currentDate = Carbon::now()->format('Y-m-d');

        $data = $this->with('image')
                ->whereDate('start_time', '<=', $currentDate)
                ->whereDate('end_time', '>=', $currentDate)
                ->limit(5)
                ->get();

        return $data;
    }
}
