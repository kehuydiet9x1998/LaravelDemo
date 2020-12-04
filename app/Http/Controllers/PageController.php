<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TheLoai;
use App\Models\Slide;
use App\Models\LoaiTin;
use App\Models\TinTuc;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
class PageController extends Controller
{
    function __construct()
    {
        $theloai = TheLoai::all();
        $slide = Slide::all();
        view()->share('slide',$slide);
        view()->share('theloai',$theloai);
        if(Auth::check())
        {
            \view()->share('nguoidung',Auth::user());
        }
    }

    public function trangchu(){
        return view('page.trangchu');
    }
    public function lienhe()
    {
        return view('page.lienhe');
    }
    public  function loaitin($id){
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('page.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }
    public  function tintuc($id){
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('page.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
    }
    public  function getDangNhap()
    {
        return view('page.dangnhap');
    }
    public function postDangNhap(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('dangnhap')
                ->withErrors($validator)
                ->withInput();
        }
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
            return redirect('trangchu');
        else
            return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công..!');
    }
}
