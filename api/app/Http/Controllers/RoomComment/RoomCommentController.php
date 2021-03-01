<?php

namespace App\Http\Controllers\RoomComment;

use App\Http\Requests\RoomComment\DeleteCommentRequest;
use App\Http\Requests\RoomComment\RoomCommentRequest;
use App\Http\Requests\RoomComment\UpdateCommentRequest;
use App\Http\Resources\AddCommentResource;
use App\Http\Resources\UpdateCommentResource;
use App\Repositories\RoomComment\RoomCommentRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class RoomCommentController extends BaseController
{
    //
    protected $roomCommentRepository;

    /**
     * RoomCommentController constructor.
     * @param $roomCommentRepository
     */
    public function __construct(RoomCommentRepositoryInterface $roomCommentRepository)
    {
        $this->roomCommentRepository = $roomCommentRepository;
    }

    public function addNewComment(RoomCommentRequest $request)
    {
        $tenant_id = auth('tenant')->user()->id;
        $room_id = $request->post('room_id');
        $comment = $request->post('comment');

        $newComment = $this->roomCommentRepository->create([
            'tenant_id' => $tenant_id,
            'room_id' => $room_id,
            'comment' => $comment
        ]);
        return response()->json(new AddCommentResource($newComment), 201);
    }

    public function updateComment(UpdateCommentRequest $request)
    {
        $id = $request->post('id');
        $commentBody = $request->post('comment');

        $oldComment = $this->roomCommentRepository->find($id);

        if ($oldComment) {
            $newComment = $this->roomCommentRepository->update([
                'comment' => $commentBody
            ], $id);
            return response()->json(new UpdateCommentResource($newComment), 200);

        }
        return response()->json(null, 404);
    }

    public function deleteComment(DeleteCommentRequest $request)
    {
        $comment_id = $request->get('id');
        $comment = $this->roomCommentRepository->find($comment_id);
        if ($comment) {
            $comment->delete();
            return response()->json([
                'message' => 'Comment đã được xóa'
            ]);
        }
        return response()->json(null, 404);
    }

}
