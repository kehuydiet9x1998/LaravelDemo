<?php

use Illuminate\Support\Facades\Route;
use App\Models\TheLoai;
use App\Http\Controllers\TheLoaiController;
use App\Http\Controllers\LoaiTinController;
use App\Http\Controllers\TinTucController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CommentController;
use  App\Http\Controllers\SlideController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/admin/dangnhap',[UserController::class,'postDangNhapAdmin']);
Route::get('/admin/dangnhap',[UserController::class,'getDangNhapAdmin']);
Route::get('/admin/logout',[UserController::class,'getDangXuatAdmin']);

Route::group(['prefix'=>'admin'],function (){
    Route::group(['prefix'=>'theloai'],function (){
       Route::get('danhsach',[TheLoaiController::class,'getDanhSach']);
       Route::get('sua/{id}',[TheLoaiController::class,'getSua']);
       Route::post('sua/{id}',[TheLoaiController::class,'postSua']);
       Route::get('xoa/{id}',[TheLoaiController::class,'getXoa']);
       Route::get('them',[TheLoaiController::class,'getThem']);
       Route::post('them',[TheLoaiController::class,'postThem']);
    });
    Route::group(['prefix'=>'loaitin'],function (){
        Route::get('danhsach',[LoaiTinController::class,'getDanhSach']);
        Route::get('sua/{id}',[LoaiTinController::class,'getSua']);
        Route::post('sua/{id}',[LoaiTinController::class,'postSua']);
        Route::get('xoa/{id}',[LoaiTinController::class,'getXoa']);
        Route::get('them',[LoaiTinController::class,'getThem']);
        Route::post('them',[LoaiTinController::class,'postThem']);
    });
    Route::group(['prefix'=>'tintuc'],function (){
        Route::get('danhsach',[TinTucController::class,'getDanhSach']);
        Route::get('sua/{id}',[TinTucController::class,'getSua']);
        Route::post('sua/{id}',[TinTucController::class,'postSua']);
        Route::get('xoa/{id}',[TinTucController::class,'getXoa']);
        Route::get('them',[TinTucController::class,'getThem']);
        Route::post('them',[TinTucController::class,'postThem']);
    });
    Route::group(['prefix'=>'comment'],function (){
       Route::get('xoa/{id}/{idTinTuc}',[CommentController::class,'getXoa']);
    });
    Route::group(['prefix'=>'slide'],function (){
        Route::get('danhsach',[SlideController::class,'getDanhSach']);
        Route::get('sua/{id}',[SlideController::class,'getSua']);
        Route::post('sua/{id}',[SlideController::class,'postSua']);
        Route::get('xoa/{id}',[SlideController::class,'getXoa']);
        Route::get('them',[SlideController::class,'getThem']);
        Route::post('them',[SlideController::class,'postThem']);
    });
    Route::group(['prefix'=>'user'],function (){
        Route::get('danhsach',[UserController::class,'getDanhSach']);
        Route::get('sua/{id}',[UserController::class,'getSua']);
        Route::post('sua/{id}',[UserController::class,'postSua']);
        Route::get('xoa/{id}',[UserController::class,'getXoa']);
        Route::get('them',[UserController::class,'getThem']);
        Route::post('them',[UserController::class,'postThem']);
    });
    Route::group(['prefix'=>'ajax'],function (){
        Route::get('loaitin/{idTheLoai}',[AjaxController::class,'getLoaiTin']);
    });
});
Route::get('trangchu',[PageController::class,'trangchu']);
Route::get('lienhe',[PageController::class,'lienhe']);
Route::get('loaitin/{id}/{TenKhongDau}.html',[PageController::class,'loaitin']);
Route::get('tintuc/{id}/{TieuDeKhongDau}.html',[PageController::class,'tintuc']);
Route::get('dangnhap',[PageController::class,'getDangNhap']);
Route::post('dangnhap',[PageController::class,'postDangNhap']);
