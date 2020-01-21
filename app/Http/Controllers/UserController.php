<?php

namespace App\Http\Controllers;
use App\bookroom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\District;
use App\Categories;
use App\Motelroom;
use Image;
use DB;
class UserController extends Controller
{
	/* Register */
   	public function get_register(){
//         $categories = Categories::all();
//   		return view('home.register',['categories'=>$categories]);
        return view('home.register');
   	}

   	public function post_register(Request $req){

   		$req->validate([
   			'txtuser' => 'required|unique:users,username',
            'txtphone' => 'required|unique:users,phone',
   			'txtemail' => 'required|email|unique:users,email',
   			'txtpass' => 'required|min:6',
   			'txt-repass' => 'required|same:txtpass',
   			'txtname' => 'required'
   		],[
   			'txtuser.required' => 'Vui lòng nhập tài khoản',
   			'txtuser.unique' => 'Tài khoản đã tồn tại trên hệ thống',
            'txtphone.required' => 'Vui lòng nhập số điện thoại',
            'txtphone.unique' => 'Số điện thoại đã tồn tại trên hệ thống',

   			'txtemail.unique' => 'Email đã tồn tại trên hệ thống',
   			'txtemail.required' => 'Vui lòng nhập Email',

   			'txtpass.required' => 'Vui lòng nhập mật khẩu',
   			'txtpass.min' => 'Mật khẩu phải lớn hơn 6 kí tự',
   			'txt-repass.required' => 'Vui lòng nhập lại mật khẩu',
   			'txt-repass.same' => 'Mật khẩu nhập lại không trùng khớp',
   			'txtname.required' => 'Nhập tên hiển thị'
   		]);
   		$newuser = new User;
   		$newuser->username = $req->txtuser;
   		$newuser->name = $req->txtname;
        $newuser->phone = $req->txtphone;
        $newuser->gender = 0;
        $newuser->email = $req->txtemail;
   		$newuser->password = bcrypt($req->txtpass);

   		$newuser->save();
   		return redirect('/')->with('success','Đăng kí thành công');
   	}
   	/* Login */
   	public function get_login(){
         $categories = Categories::all();
   		return view('home.login',['categories'=>$categories]);
   	}

   	public function post_login(Request $req){
   		$req->validate([
   			'txtuser' => 'required',
   			'txtpass' => 'required',

   		],[
   			'txtuser.required' => 'Vui lòng nhập tài khoản',
   			'txtpass.required' => 'Vui lòng nhập mật khẩu'

   		]);
   		if(Auth::attempt(['username'=>$req->txtuser,'password'=>$req->txtpass])){
    		return redirect('/');
    	}
    	else
    		return redirect('user/login')->with('warn','Tài khoản hoặc mật khẩu không đúng');
   	}
   	public function logout(){
   		Auth::logout();
		return redirect('user/login');
   	}
      public function getprofile(){
          $mypost = Motelroom::where('user_id',Auth::user()->id)->where('roomstatus',0)->get();
//          dd($mypost);
         $mypost0 = Motelroom::where('user_id',Auth::user()->id)->where('roomstatus',1)->get();
//          dd($mypost);
          $mypost1 = Motelroom::where('user_id',Auth::user()->id)->where('roomstatus',2)->get();
//         dd($mypost1);
          $mypost2 = Motelroom::where('user1_id',Auth::user()->id)->get();
//          dd($mypost2);
         $categories = Categories::all();
         return view('home.profile',[
            'categories'=>$categories,
            'mypost'=> $mypost,
             'mypost0'=> $mypost0,
             'mypost1'=> $mypost1,
             'mypost2'=> $mypost2
         ]);
      }

      public function getEditprofile(){
         $user = User::find(Auth::user()->id);
         $categories = Categories::all();
         return view('home.edit-profile',[
            'categories'=>$categories,
            'user'=> $user
         ]);
      }
      public function postEditprofile(Request $request){
//        dd($request->all());
          $this->validate($request,[
              'avtuser'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              'txtusername'=>'min:3|max:20',
              'txtname' => 'min:3|max:20',
//              'gender'=>'number',
//              'dateofbrith'=>'date',
//              'address'=>'min:3|max:20',
//              'phone'=>'number',
//              'right'=>'number',

          ],[
              'avtuser.image'=>'vui lòng chọn đúng file ảnh',
              'avtuser.mimes'=>'fie ảnh phải có định dạng jpeg,png,jpg,gif,svg',
              'txtusername.min' => 'Tên phải lớn hơn 3 và nhỏ hơn 20 kí tự',
              'txtusername.max' => 'Tên phải lớn hơn 3 và nhỏ hơn 20 kí tự',
              'txtname.min' => 'Tên phải lớn hơn 3 và nhỏ hơn 20 kí tự',
              'txtname.max' => 'Tên phải lớn hơn 3 và nhỏ hơn 20 kí tự'
          ]);
         $categories = Categories::all();
         $user = User::find(Auth::id());

//         if ($request->hasFile('avtuser')){
//            $file = $request->file('avtuser');
//            var_dump($file);
//            $exten = $file->getClientOriginalExtension();
//            if($exten != 'jpg' && $exten != 'png' && $exten !='jpeg' && $exten != 'JPG' && $exten != 'PNG' && $exten !='JPEG' )
//                return redirect('user/profile/edit')->with('thongbao','Bạn chỉ được upload hình ảnh có định dạng JPG,JPEG hoặc PNG');
//            $Hinh = 'avatar-'.$user->username.'-'.time().'.'.$exten;
//            while (file_exists('uploads/avatars/'.$Hinh)) {
//                 $Hinh = 'avatar-'.$user->username.'-'.time().'.'.$exten;
//            }
//            if(file_exists('uploads/avatars/'.$user->avatar))
//               unlink('uploads/avatars/'.$user->avatar);
//
//            $file->move('uploads/avatars',$Hinh);
//            $user->avatar = $Hinh;
//         }

         if(($request->txtpass != '' ) || ($request->retxtpass != '')){
            $this->validate($request,[
               'txtpass' => 'min:3|max:32',
               'retxtpass' => 'same:txtpass',
            ],[
               'txtpass.min' => 'password phải lớn hơn 3 và nhỏ hơn 32 kí tự',
               'txtpass.max' => 'password phải lớn hơn 3 và nhỏ hơn 32 kí tự',
               'retxtpass.same' => 'Nhập lại mật khẩu không đúng',
               'retxtpass.required' => 'Vui lòng nhập lại mật khẩu',
            ]);
            $user->password = bcrypt($request->txtpass);
         }
          if($request->hasFile('avtuser')){
              // luu anh vao csdl
              $file = $request->avtuser;
              $name = $file->getClientOriginalName();

              $image_resize = Image::make($file->getRealPath());
              $image_resize->fit($width = 250, $height = 250, function ($constraint) {
                  $constraint->upsize();
              });
              $image_resize->save('uploads/avatars/'.$name);
              $user->avatar = $name; //Ảnh đại điện
          }

          $user->name = $request->txtname;
          $user->username = $request->txtusername;
          $user->gender = $request->gender;
          $user->dateofbrith = $request->dateofbrith;
          $user->address = $request->address;
          $user->email = $request->txtemail;
          $user->phone = $request->phone;
          $user->right = $request->right;


         $user->save();
         return redirect('user/profile/edit')->with('thongbao','Cập nhật thông tin thành công');

         // return view('home.edit-profile',[
         //    'categories'=>$categories,
         //    'user'=> $user
         // ]);
      }
   	/* Đăng tin */
   	public function get_dangtin(){
         $district = District::all();
         $categories = Categories::all();
   		return view('home.dangtin',[
            'district'=>$district,
            'categories'=>$categories
         ]);
   	}
      public function post_dangtin(Request $request){

         $request->validate([
            'txttitle' => 'required',
            'txtaddress' => 'required',
            'txtprice' => 'required',
            'txtarea' => 'required',
            'txtphone' => 'required',
            'txtdescription' => 'required',
            'txtaddress' => 'required',
         ],
         [
            'txttitle.required' => 'Nhập tiêu đề bài đăng',
            'txtaddress.required' => 'Nhập địa chỉ phòng trọ',
            'txtprice.required' => 'Nhập giá thuê phòng trọ',
            'txtarea.required' => 'Nhập diện tích phòng trọ',
            'txtphone.required' => 'Nhập SĐT chủ phòng trọ (cần liên hệ)',
            'txtdescription.required' => 'Nhập mô tả ngắn cho phòng trọ',
            'txtaddress.required' => 'Nhập hoặc chọn địa chỉ phòng trọ trên bản đồ'
         ]);

         /* Check file */
         $json_img ="";
         if ($request->hasFile('hinhanh')){
            $arr_images = array();
            $inputfile =  $request->file('hinhanh');
            foreach ($inputfile as $filehinh) {
               $namefile = "phongtro-".str_random(5)."-".$filehinh->getClientOriginalName();
               while (file_exists('uploads/images'.$namefile)) {
                 $namefile = "phongtro-".str_random(5)."-".$filehinh->getClientOriginalName();
               }
              $arr_images[] = $namefile;
              $filehinh->move('uploads/images',$namefile);
            }
            $json_img =  json_encode($arr_images,JSON_FORCE_OBJECT);
         }
         else {
            $arr_images[] = "no_img_room.png";
            $json_img = json_encode($arr_images,JSON_FORCE_OBJECT);
         }
         /* tiện ích*/
         $json_tienich = json_encode($request->tienich,JSON_FORCE_OBJECT);
         /* ----*/
         /* get LatLng google map */
         $arrlatlng = array();
         $arrlatlng[] = $request->txtlat;
         $arrlatlng[] = $request->txtlng;
         $json_latlng = json_encode($arrlatlng,JSON_FORCE_OBJECT);

         /* --- */
         /* New Phòng trọ */
         $motel = new Motelroom;
         $motel->title = $request->txttitle;
         $motel->description = $request->txtdescription;
         $motel->price = $request->txtprice;
         $motel->area = $request->txtarea;
         $motel->count_view = 0;
         $motel->address = $request->txtaddress;
         $motel->latlng = $json_latlng;
         $motel->utilities = $json_tienich;
         $motel->images = $json_img;
         $motel->user_id = Auth::user()->id;
         $motel->category_id = $request->idcategory;
         $motel->district_id = $request->iddistrict;
         $motel->phone = $request->txtphone;
          $motel->roomstatus = 0;
         $motel->save();
         return redirect('/user/dangtin')->with('success','Đăng tin thành công. Vui lòng đợi Admin kiểm duyệt');

      }

      public function thue(Request $request,$id){
          $thuephong = Motelroom::where('id',$id)->get();
//         dd($thuephong);
          $thuephong[0] ->user1_id = Auth::user()->id;
          $thuephong[0] ->startday = $request ->startday;
          $thuephong[0] ->endday = $request ->endday;
          $thuephong[0] ->number = $request ->number;
          $thuephong[0] ->check = $request ->check;
          $thuephong[0]->roomstatus = 1;
          $thuephong[0] ->update();

          return redirect('/');
      }
      public function xacnhan($id){
//   	    dd($id);
   	    $xacnhan = Motelroom::find($id);
//          dd($xacnhan);
          $xacnhan ->roomstatus = 2;
          $xacnhan ->save();
          return redirect('/');
      }
}
