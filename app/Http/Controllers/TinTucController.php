<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaiTin;
use App\Models\TheLoai;
use App\Models\TinTuc;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class TinTucController extends Controller
{
    //
    public function getDanhSach(){
        $tintuc = TinTuc::all();
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }
    public function getThem(){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }
    public function postThem(Request $request){
        $validator = Validator::make($request->all(), [
            'TieuDe' => 'required|min:3|max:255|unique:TinTuc,TieuDe',
            'TheLoai'=>'required',
            'LoaiTin'=>'required',
            'TomTat'=>'required',
            'NoiDung'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/tintuc/them')
                ->withErrors($validator)
                ->withInput();
        }
        $tintuc = new TinTuc();
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->Ten);
        $tintuc->Tomtat = $request->TomTat;
        $tintuc->NoiBat = $request->NoiBat;
        $tintuc->NoiDung = $request->NoiDung;
        if($request->hasFile('Hinh')){
            $file = $request ->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chon file có đuôi jpg, png, jpeg');
            }
            $name = $file->getClientOriginalName();
            $Hinh = Str::random(4)."_".$name;
            while (file_exists("upload/tintuc/".$Hinh))
            {
                $Hinh = Str::random(4)."_".$name;
            }
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh = $Hinh;
        }else{
            $tintuc->Hinh = "";
        }
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao','Thêm thành công..!');
    }
    public function getSua($id){
        $tintuc = TinTuc::find($id);
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);
    }
    public  function  postSua(Request $request,$id){
        $tintuc = TinTuc::find($id);
        $validator = Validator::make($request->all(), [
            'TieuDe' => 'required|min:3|max:255|',
            'TheLoai'=>'required',
            'LoaiTin'=>'required',
            'TomTat'=>'required',
            'NoiDung'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/tintuc/sua/'.$id)
                ->withErrors($validator)
                ->withInput();
        }
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->Ten);
        $tintuc->Tomtat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        if($request->hasFile('Hinh')){
            $file = $request ->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/sua/'.$id)->with('loi','Bạn chỉ được chon file có đuôi jpg, png, jpeg');
            }
            $name = $file->getClientOriginalName();
            $Hinh = Str::random(4)."_".$name;
            while (file_exists("upload/tintuc/".$Hinh))
            {
                $Hinh = Str::random(4)."_".$name;
            }
            unlink("upload/tintuc/".$tintuc->Hinh);
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh = $Hinh;
        }
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->NoiBat = $request->NoiBat;
        $tintuc->save();
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Sửa thành công..!');
    }
    public function getXoa($id){
        $tintuc = TinTuc::find($id);
        $tintuc ->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao','Xóa thành công..!');
    }
}
