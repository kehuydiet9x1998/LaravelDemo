<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TheLoai;
use Illuminate\Support\Facades\Validator;
class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
        $theloai = TheLoai::all();
        return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }
    public function getThem(){
        return view('admin.theloai.them');
    }
    public function postThem(Request $request){
        $validator = Validator::make($request->all(), [
            'Ten' => 'required|min:3|max:255|unique:TheLoai,Ten',
        ]);

        if ($validator->fails()) {
            return redirect('admin/theloai/them')
                ->withErrors($validator)
                ->withInput();
        }
        $theloai = new TheLoai();
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/them')->with('thongbao','Thêm thành công..!');
    }
    public function getSua($id){
        $theloai = TheLoai::find($id);
        return view('admin.theloai.sua',['theloai'=>$theloai]);
    }
    public  function  postSua(Request $request,$id){
        $theloai = TheLoai::find($id);
        $validator = Validator::make($request->all(), [
            'Ten' => 'required|unique:TheLoai,Ten|min:3|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('admin/theloai/sua')
                ->withErrors($validator)
                ->withInput();
        }
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/'.$id)->with('thongbao','Sửa thành công..!');
    }
    public function getXoa($id){
        $theloai = TheLoai::find($id);
        $theloai ->delete();
        return redirect('admin/theloai/danhsach')->with('thongbao','Xóa thành công..!');
    }
}
