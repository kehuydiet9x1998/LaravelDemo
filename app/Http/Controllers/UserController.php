<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    //
    public function getDanhSach(){
        $user = User::all();
        return view('admin.user.danhsach',['user'=>$user]);
    }
    public function getThem(){
        return view('admin.user.them');
    }
    public function postThem(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255|',
            'email'=>'required|unique:users,email',
            'quyen'=>'required',
            'password'=>'required|min:6|max:255',
            'passwordAgain'=>'required|same:password'
        ]);

        if ($validator->fails()) {
            return redirect('admin/user/them')
                ->withErrors($validator)
                ->withInput();
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = $request->quyen;
        $user->save();
        return redirect('admin/user/them')->with('thongbao','Thêm thành công..!');
    }
    public function getSua($id){
        $user = User::find($id);
        return view('admin.user.sua',['user'=>$user]);
    }
    public  function  postSua(Request $request,$id){
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255|',
            'quyen'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/user/sua/'.$id)
                ->withErrors($validator)
                ->withInput();
        }
        $user->name = $request->name;
        if($request->changePassword == "on")
        {
            $validator = Validator::make($request->all(), [
                'password'=>'required|min:6|max:255',
                'passwordAgain'=>'required|same:password'
            ]);

            if ($validator->fails()) {
                return redirect('admin/user/sua/'.$id)
                    ->withErrors($validator)
                    ->withInput();
            }
            $user->password = bcrypt($request->password);
        }
        $user->quyen = $request->quyen;
        $user->save();
        return redirect('admin/user/sua/'.$id)->with('thongbao','Sửa thành công..!');
    }
    public function getXoa($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao', 'Xóa thành công..!');
    }
    public function getDangNhapAdmin(){
        return view('admin.login');
    }
    public function postDangNhapAdmin(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('admin/dangnhap')
                ->withErrors($validator)
                ->withInput();
        }
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
            return redirect('admin/theloai/danhsach');
        else
            return redirect('admin/dangnhap')->with('thongbao','Đăng nhập không thành công..!');
    }
    public function getDangXuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
