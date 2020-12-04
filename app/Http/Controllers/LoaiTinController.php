<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaiTin;
use App\Models\TheLoai;
use Illuminate\Support\Facades\Validator;
class LoaiTinController extends Controller
{
    //
    public function getDanhSach(){
        $loaitin = LoaiTin::all();
        return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);
    }
    public function getThem(){
        $theloai = TheLoai::all();

        return view('admin.loaitin.them',['theloai'=>$theloai]);
    }
    public function postThem(Request $request){
        $validator = Validator::make($request->all(), [
            'Ten' => 'required|min:3|max:255|unique:LoaiTin,Ten',
            'TheLoai'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/loaitin/them')
                ->withErrors($validator)
                ->withInput();
        }
        $loaitin = new LoaiTin();
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/them')->with('thongbao','Thêm thành công..!');
    }
    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::find($id);
        return view('admin.loaitin.sua',['loaitin'=>$loaitin,'theloai'=>$theloai]);
    }
    public  function  postSua(Request $request,$id){
        $loaitin = LoaiTin::find($id);
        $validator = Validator::make($request->all(), [
            'Ten' => 'required|min:3|max:255|unique:LoaiTin,Ten',
            'TheLoai'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/loaitin/sua')
                ->withErrors($validator)
                ->withInput();
        }
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/danhsach')->with('thongbao','Thêm thành công..!');
    }
    public function getXoa($id){
        $loaitin = LoaiTin::find($id);
        $loaitin ->delete();
        return redirect('admin/loaitin/danhsach')->with('thongbao','Xóa thành công..!');
    }
}
