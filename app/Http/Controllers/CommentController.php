<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getXoa($id,$idTinTuc){
        $comment = Comment::find($id);
        $comment ->delete();
        return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao','Xóa Comment thành công..!');
    }
}
