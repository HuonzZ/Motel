@extends('layouts.master')
@section('content')
<div class="container" style="padding-left: 0px;padding-right: 0px;">
	<div class="gap"></div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2" style="margin-bottom: 50px">
			<div class="gap"></div>
			<div class="panel panel-primary">
				<div class="panel-heading">Chỉnh sửa hồ sơ</div>
				<div class="panel-body">
					<div class="gap"></div>
					@if ($errors->any())
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					@if(session('thongbao'))
		                        <div class="alert bg-success">
									<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
									<span class="text-semibold">Done</span>  {{session('thongbao')}}
								</div>
		            @endif
					<form class="form-horizontal" method="POST" action="{{ route('user.edit') }}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="content-upload">
							<center>
{{--								@if(Auth::user()->avatar == 'no-avatar.jpg')--}}
{{--									<img class="user_avatar" id="output" src="images/no-avatar.jpg">--}}
{{--								@else--}}
{{--									<img class="user_avatar" id="output" src="uploads/avatars/{{ $user->avatar }}">--}}
{{--								@endif--}}
{{--								<label for="avtuser" class="labelforfile"><i class="fas fa-file-image"></i> Chọn ảnh</label>--}}
{{--								<input class="form-control" name="avtuser" id="avtuser" type="file" accept="image/*" onchange="loadFile(event)" style="display: none">--}}
{{--								<script>--}}
{{--								  var loadFile = function(event) {--}}
{{--								    var output = document.getElementById('output');--}}
{{--								    output.src = URL.createObjectURL(event.target.files[0]);--}}
{{--								  };--}}
{{--								</script>--}}

									@if(Auth::user()->avatar == 'no-avatar.jpg')
										<input hidden id="img" type="file" name="avtuser" class="form-control hidden" onchange="changeImg(this)" >
										<img  id="avatar" width="170px" src="images/no-avatar.jpg">
									@else
										<input hidden id="img" type="file" name="avtuser" class="form-control hidden" onchange="changeImg(this)" >
										<img id="avatar" class="thumbnail" width="170px" src="uploads/avatars/{{ $user->avatar }}" >
									@endif
									<script type="text/javascript">
									$(document).ready(function() {
										$('#avatar').click(function(){
											$('#img').click();
										});
									});
									function changeImg(input){
										//Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
										if(input.files && input.files[0]){
											var reader = new FileReader();
											//Sự kiện file đã được load vào website
											reader.onload = function(e){
												//Thay đổi đường dẫn ảnh
												$('#avatar').attr('src',e.target.result);
											}
											reader.readAsDataURL(input.files[0]);
										}
									}
								</script>
							</center>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3">Tên tài khoản:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="txtusername" value="{{$user->username}}" placeholder="Tên tài khoản đăng nhập hệ thống">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3">Họ và tên:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="txtname" value="{{$user->name}}" placeholder="Tên hiển thị trên hệ thống">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3">Giới tính:</label>
							<div class="col-sm-9">
								<div class="form-check-inline" style="margin-left: 10px;">
									<label class="form-check-label" for="radio1" style="margin-right: 20px;">
										<input type="radio" class="form-check-input" id="radio1" name="gender" value="0" {{0 == $user->gender ? 'checked' : ''}}  >Nam
									</label>
									<label class="form-check-label" for="radio2">
										<input type="radio" class="form-check-input" id="radio2" name="gender" value="1" {{1 == $user->gender ? 'checked' : ''}}>Nữ
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3">Ngày tháng năm sinh:</label>
							<div class="col-sm-9">
								<input type="date" class="form-control" name="dateofbrith" value="{{$user->dateofbrith}}" placeholder="ngày tháng năm sinh">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3">Địa chỉ liên hệ:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="address" value="{{$user->address}}" placeholder="địa chỉ liên hệ">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3">Số điện thoại:</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" name="phone" value="{{$user->phone}}" placeholder="Điện thoại">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="pwd">Email:</label>
							<div class="col-sm-9">
								<input type="email" class="form-control" name="txtemail" value="{{$user->email}}" placeholder="Email của bạn">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="pwd">Mật khẩu:</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" name="txtpass" placeholder="Nhập mật khẩu">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="pwd">Nhập lại mật khẩu:</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" name="retxtpass" placeholder="Nhập lại mật khẩu">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="pwd">Chọn quyền:</label>
							<div class="col-sm-9">
								<select class="custom-select custom-select-sm" name="right">
									@foreach (config('test.qp') as $key => $qp)
										<option value="{{$key}}" {{$key==$user->right ? 'selected' : ''}}>{{$qp}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-5 col-sm-9">
								<button type="submit" class="btn btn-primary">Chỉnh sửa</button>
							</div>
						</div>
					</form><div class="gap"></div>
				</div>

			<div class="gap"></div>
			</div>
		</div>
	</div>

</div>

@endsection