<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMeta;
use Illuminate\Support\Facades\Auth;

class UserMetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Lấy tất cả user_meta.
     */
    public function index()
    {
        $userMeta = UserMeta::all();
        return response()->json($userMeta);
    }

    /**
     * Lấy thông tin user_meta theo user_id.
     */
    public function getUserMeta()
    {
        $userId = Auth::id();
        $userMeta = UserMeta::where('user_id', $userId)->first();

        if (!$userMeta) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu'], 404);
        }

        $userMeta->meta = json_decode($userMeta->meta, true);
        return response()->json($userMeta);
    }

    /**
     * Thêm mới user_meta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'meta' => 'required|string',
        ]);

        $userMeta = UserMeta::create($request->all());

        return response()->json($userMeta, 201);
    }

    /**
     * Cập nhật user_meta.
     */
    public function updateUserMeta(Request $request)
    {
        $userId = Auth::id();
        $userMeta = UserMeta::where('user_id', $userId)->first();

        if (!$userMeta) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu'], 404);
        }

        $userMeta->update([
            'meta' => json_encode($request->all()),
        ]);

        return response()->json(['message' => 'Cập nhật thành công', 'userMeta' => json_decode($userMeta->meta, true)]);
    }

    /**
     * Xóa user_meta.
     */
    public function destroy($id)
    {
        $userMeta = UserMeta::find($id);

        if (!$userMeta) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu'], 404);
        }

        $userMeta->delete();

        return response()->json(['message' => 'Xóa thành công'], 200);
    }
}
