@extends('layouts.master')
@section('content')
<?php 
function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'năm',
		'm' => 'tháng',
		'w' => 'tuần',
		'd' => 'ngày',
		'h' => 'giờ',
		'i' => 'phút',
		's' => 'giây',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' trước' : 'Vừa xong';
}
?>

<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="banner-info mb-5">
				<div class="mapInfo false" style="" data-reactid="47">
					@if(Auth::user()->avatar == 'no-avatar.jpg')
					<img style="color:#ffffff;background-color:rgb(188, 188, 188);user-select:none;display:inline-flex;align-items:center;justify-content:center;font-size:40px;border-radius:50%;height:80px;width:80px;" alt="Thành Trung" size="80" src="images/no-avatar.jpg" class="avatar" data-reactid="57">
					@else
					<img style="color:#ffffff;background-color:rgb(188, 188, 188);user-select:none;display:inline-flex;align-items:center;justify-content:center;font-size:40px;border-radius:50%;height:80px;width:80px;" alt="Thành Trung" size="80" src="uploads/avatars/{{Auth::user()->avatar}}" class="avatar" data-reactid="57">
					@endif
					<a href="user/profile/edit"><div style="color: rgba(0, 0, 0, 0.87); background-color: transparent; transition: all 450ms cubic-bezier(0.23, 1, 0.32, 1) 0ms; box-sizing: border-box; font-family: Verdana, Arial, sans-serif; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 10px, rgba(0, 0, 0, 0.23) 0px 3px 10px; border-radius: 50%; display: inline-block; position: absolute; right: 20px; bottom: -17px;"><button tabindex="0" type="button" style="border: 10px; box-sizing: border-box; display: inline-block; font-family: Verdana, Arial, sans-serif; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: pointer; text-decoration: none; margin: 0px; padding: 0px; outline: none; font-size: 25px; font-weight: inherit; position: relative; vertical-align: bottom; z-index: 1; background-color: rgb(255, 255, 255); transition: all 450ms cubic-bezier(0.23, 1, 0.32, 1) 0ms; height: 35px; width: 35px; overflow: hidden; border-radius: 50%; text-align: center; color: rgb(51, 51, 51);"><div><div style="transition: all 450ms cubic-bezier(0.23, 1, 0.32, 1) 0ms; top: 0px;"><span class="ion-android-create" style="color: rgb(51, 51, 51); position: relative; font-size: 25px; display: inline-block; user-select: none; transition: all 450ms cubic-bezier(0.23, 1, 0.32, 1) 0ms; height: 35px; line-height: 35px; fill: rgb(255, 255, 255);"><i class="fas fa-pencil-alt"></i></span></div></div></button></div></a>
				</div>
				<div class="info">
					<h4 class="name" data-reactid="59">{{ Auth::user()->name }}</h4>
					<div class="infoText">
						Tham gia {{ time_elapsed_string(Auth::user()->created_at) }} - {{ Auth::user()->created_at }}
					</div>
				</div>
			</div>
			@if((Auth::user()->right)>=1)
				<div class="mainpage">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item active" >
							<a class="nav-link active" data-toggle="tab" href="#home">Danh sách các phòng còn trống</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#menu1">Danh sách các phòng đã có người đăng ký</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#menu2">Danh sách các phòng đã có người ở</a>
						</li>

					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div id="home" class=" tab-pane active"><br>
							@if(session('thongbao'))
								<div class="alert bg-danger">
									<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
									<span class="text-semibold">Hi!</span>  {{session('thongbao')}}
								</div>
							@endif
							<div class="mypage">

										@if( count($mypost) < 1)
											<div class="alert alert-info">
												Bạn chưa có tin đăng phòng trọ nào đang cho thuê, thử đăng ngay.
											</div>
											<a href="user/dangtin" class="btn-post">ĐĂNG TIN</a>

										@else
											<div class="table-responsive">
											<table class="table" style="table-layout:fixed;">
											<thead>
												<tr>
													<th>Tiêu đề</th>
													<th>Danh mục</th>
													<th>Gía phòng</th>
													<th>Lượt xem</th>
													<th>Tình trạng</th>
													<th>Trạng thái phòng</th>
													<th>Chức năng</th>
												</tr>
											</thead>
											<tbody>
												@foreach($mypost as $post)
												<tr>
													<td style="width: auto;
															text-overflow: ellipsis;
															overflow: hidden;
															white-space: nowrap;">
														<a href="phongtro/{{ $post->slug }}">{{ $post->title }}</a>	</td>
													<td>{{ $post->category->name }}</td>
													<td>{{ $post->price }}</td>
													<td>{{ $post->count_view }}</td>
													<td>
														@if($post->approve == 1)
															<span class="label label-success">Đã kiểm duyệt</span>
														@elseif($post->approve == 0)
															<span class="label label-danger">Chờ Phê Duyệt</span>
														@endif
													</td>
													<td>
														@if($post->roomstatus == 0)
															<span class="label label-success">Còn trống</span>
														@else($post->roomstatus == 1)
															<span class="label label-danger">Đang có người đăng ký</span>
{{--														@else($post->roomstatus == 2)--}}
{{--															<span class="label label-danger">Đang có người ở</span>--}}
														@endif
													</td>
													<td>
{{--														<a href="{{route('xacnhan',$post->id)}}" title="Xác nhận thuê"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></i></button></a>--}}
{{--														<a href="" title="Sửa"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button></a>--}}
														<a href="motelroom/del/{{ $post->id }}" title="Xóa"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
													</td>
												</tr>
												@endforeach
											</tbody>
											</table>
											</div>
										@endif

							</div>

						</div>
						<div id="menu1" class="container tab-pane fade"><br>
							{{--							<div class="mypage">
                            {{--								@if(session('thongbao'))--}}
							{{--									<div class="alert bg-danger">--}}
							{{--										<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>--}}
							{{--										<span class="text-semibold">Hi!</span>  {{session('thongbao')}}--}}
							{{--									</div>--}}
							{{--								@endif--}}

							{{--								@if( count($mypost) < 1)--}}
							{{--									<div class="alert alert-info">--}}
							{{--										Bạn chưa có tin đăng phòng trọ nào đang cho thuê, thử đăng ngay.--}}
							{{--									</div>--}}
							{{--									<a href="user/dangtin" class="btn-post">ĐĂNG TIN</a>--}}

							{{--								@else--}}

							<div class="table-responsive">
								<table class="table" style="table-layout:fixed;">
									<thead>
									<tr>
										<th>Tên người đặt</th>
										<th>Số điện thoại</th>
										<th>Email</th>
										<th>Tiêu đề</th>
{{--										<th>Danh mục</th>--}}
										<th>Gía phòng</th>
										<th>Thời gian thuê</th>
										<th>Trạng thái phòng</th>
										<th>Chức năng</th>
									</tr>
									</thead>
									<tbody>
									@foreach($mypost0 as $post)
										<tr>
											<td>{{$post->nguoithue['name']}}</td>
											<td>{{$post->nguoithue['phone']}}</td>
											<td>{{$post->nguoithue['email']}}</td>
											<td style="width: auto;
															text-overflow: ellipsis;
															overflow: hidden;
															white-space: nowrap;">
												<a href="phongtro/{{ $post->slug }}">{{ $post->title }}</a>	</td>
{{--											<td>{{ $post->category->name }}</td>--}}
											<td>{{ $post->price }}</td>
											<td>{{ $post->startday }} đến {{ $post->endday }}</td>
											<td>
												{{--														@if($post->roomstatus == 0)--}}
												{{--															<span class="label label-success">Còn trống</span>--}}
												{{--														@elseif($post->roomstatus == 1)--}}
												{{--															<span class="label label-danger">Đã có người đăng ký</span>--}}
												@if($post->roomstatus == 1)
													<span class="label label-danger">Đã có người đăng ký</span>
												@endif
											</td>
											<td>
												<a href="{{route('xacnhan',$post->id)}}" title="Xác nhận thuê"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></i></button></a>
												{{--														<a href="" title="Sửa"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button></a>--}}
												<a href="motelroom/del/{{ $post->id }}" title="Xóa"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
											</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
							{{--								@endif--}}

						</div>
						<div id="menu2" class="tab-pane fade"><br>
							<div class="mypage">
{{--								@if(session('thongbao'))--}}
{{--									<div class="alert bg-danger">--}}
{{--										<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>--}}
{{--										<span class="text-semibold">Hi!</span>  {{session('thongbao')}}--}}
{{--									</div>--}}
{{--								@endif--}}

{{--								@if( count($mypost) < 1)--}}
{{--									<div class="alert alert-info">--}}
{{--										Bạn chưa có tin đăng phòng trọ nào đang cho thuê, thử đăng ngay.--}}
{{--									</div>--}}
{{--									<a href="user/dangtin" class="btn-post">ĐĂNG TIN</a>--}}

{{--								@else--}}

									<div class="table-responsive">
										<table class="table" style="table-layout:fixed;">
											<thead>
											<tr>
												<th>Tên người đặt</th>
												<th>Số điện thoại</th>
												<th>Email</th>
												<th>Tiêu đề</th>
												<th>Danh mục</th>
												<th>Gía phòng</th>
												<th>Thời gian thuê</th>
												<th>Trạng thái phòng</th>
{{--												<th>Chức năng</th>--}}
											</tr>
											</thead>
											<tbody>
											@foreach($mypost1 as $post)
												<tr>
													<td>{{$post->nguoithue['name']}}</td>
													<td>{{$post->nguoithue['phone']}}</td>
													<td>{{$post->nguoithue['email']}}</td>
													<td style="width: auto;
															text-overflow: ellipsis;
															overflow: hidden;
															white-space: nowrap;">
														<a href="phongtro/{{ $post->slug }}">{{ $post->title }}</a>	</td>
													<td>{{ $post->category->name }}</td>
													<td>{{ $post->price }}</td>
													<td>{{ $post->startday }} đến {{ $post->endday }}</td>
													<td>
{{--														@if($post->roomstatus == 0)--}}
{{--															<span class="label label-success">Còn trống</span>--}}
{{--														@elseif($post->roomstatus == 1)--}}
{{--															<span class="label label-danger">Đã có người đăng ký</span>--}}
														@if($post->roomstatus == 2)
															<span class="label label-danger">Đã có người ở</span>
														@endif
													</td>
{{--													<td>--}}

{{--														<a href="" title="Sửa"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button></a>--}}
{{--														<a href="motelroom/del/{{ $post->id }}" title="Xóa"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>--}}
{{--													</td>--}}
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
{{--								@endif--}}

							</div>
						</div>

						</div>
					</div>
				</div>
			@else((Auth::user()->right)==0)
				<div class="mypage">

{{--								@if(session('thongbao'))--}}
{{--									<div class="alert bg-danger">--}}
{{--									<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>--}}
{{--									<span class="text-semibold">Hi!</span>  {{session('thongbao')}}--}}
{{--								</div>--}}
{{--								@endif--}}
								<div class="mainpage">
{{--									@if( count($mypost) < 1)--}}
{{--										<div class="alert alert-info">--}}
{{--											Bạn chưa có tin đăng phòng trọ nào đang cho thuê, thử đăng ngay.--}}
{{--										</div>--}}
{{--										<a href="user/dangtin" class="btn-post">ĐĂNG TIN</a>--}}

{{--									@else--}}
										<div class="table-responsive">
										<table class="table" style="table-layout:fixed;">
										<thead>
											<tr>
												<th>Người chủ phòng</th>
												<th>Số điện thoại</th>
												<th>Email</th>
												<th>Tiêu đề</th>
{{--												<th>Danh mục</th>--}}
												<th>Gía phòng</th>
{{--												<th>Lượt xem</th>--}}
												<th>Thời gian thuê</th>
{{--												<th>Trạng thái phòng</th>--}}
												<th>Chức năng</th>
											</tr>
										</thead>
										<tbody>
											@foreach($mypost2 as $post)
											<tr>
												<td>{{ $post->chuphong->name }}</td>
												<td>{{ $post->chuphong->phone }}</td>
												<td>{{ $post->chuphong->email }}</td>
												<td style="width: auto;
				                                        text-overflow: ellipsis;
				                                        overflow: hidden;
				                                        white-space: nowrap;">
													<a href="phongtro/{{ $post->slug }}">{{ $post->title }}</a>	</td>
{{--												<td>{{ $post->category->name }}</td>--}}
												<td>{{ $post->price }}</td>
												<td>{{ $post->startday }} đến {{ $post->endday }}</td>
{{--												<td>{{ $post->count_view }}</td>--}}
{{--												<td>--}}
{{--													@if($post->approve == 1)--}}
{{--														<span class="label label-success">Đã kiểm duyệt</span>--}}
{{--													@elseif($post->approve == 0)--}}
{{--														<span class="label label-danger">Chờ Phê Duyệt</span>--}}
{{--													@endif--}}
{{--												</td>--}}
{{--												<td>--}}
{{--													@if($post->roomstatus == 0)--}}
{{--														<span class="label label-success">Còn trống</span>--}}
{{--													@elseif($post->approve == 1)--}}
{{--														<span class="label label-danger">Đã có người đăng ký</span>--}}
{{--													@endif--}}
{{--												</td>--}}
												<td>
{{--													<a href="phongtro/{{ $post->slug }}"><i class="fas fa-eye"></i> Xem</a>--}}
{{--													<a href="motelroom/del/{{ $post->id }}" style="color:red"><i class="fas fa-trash-alt"></i> Xóa</a>--}}
													<a href="" title="Sửa"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button></a>
													<a href="" title="Xóa"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
									</div>
{{--									@endif--}}
								</div>
							</div>

			@endif

{{--			@if((Auth::user()->right)>=1)--}}
{{--				<div class="mypage">--}}
{{--				<h4>Tin đã đăng gần đây</h4>--}}
{{--				@if(session('thongbao'))--}}
{{--					<div class="alert bg-danger">--}}
{{--					<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>--}}
{{--					<span class="text-semibold">Hi!</span>  {{session('thongbao')}}--}}
{{--				</div>--}}
{{--				@endif--}}
{{--				<div class="mainpage">--}}
{{--					@if( count($mypost) < 1)--}}
{{--						<div class="alert alert-info">--}}
{{--							Bạn chưa có tin đăng phòng trọ nào đang cho thuê, thử đăng ngay.--}}
{{--						</div>--}}
{{--						<a href="user/dangtin" class="btn-post">ĐĂNG TIN</a>--}}

{{--					@else--}}
{{--						<div class="table-responsive">--}}
{{--						<table class="table" style="table-layout:fixed;">--}}
{{--						<thead>--}}
{{--							<tr>--}}
{{--								<th>ID</th>--}}
{{--								<th>Tiêu đề</th>--}}
{{--								<th>Danh mục</th>--}}
{{--								<th>Gía phòng</th>--}}
{{--								<th>Lượt xem</th>--}}
{{--								<th>Tình trạng</th>--}}
{{--								<th>Trạng thái phòng</th>--}}
{{--								<th>Chức năng</th>--}}
{{--							</tr>--}}
{{--						</thead>--}}
{{--						<tbody>--}}
{{--							@foreach($mypost as $post)--}}
{{--							<tr>--}}
{{--								<td>{{ $post->id }}</td>--}}
{{--								<td style="width: auto;--}}
{{--                                        text-overflow: ellipsis;--}}
{{--                                        overflow: hidden;--}}
{{--                                        white-space: nowrap;">--}}
{{--									<a href="phongtro/{{ $post->slug }}">{{ $post->title }}</a>	</td>--}}
{{--								<td>{{ $post->category->name }}</td>--}}
{{--								<td>{{ $post->price }}</td>--}}
{{--								<td>{{ $post->count_view }}</td>--}}
{{--								<td>--}}
{{--									@if($post->approve == 1)--}}
{{--										<span class="label label-success">Đã kiểm duyệt</span>--}}
{{--									@elseif($post->approve == 0)--}}
{{--										<span class="label label-danger">Chờ Phê Duyệt</span>--}}
{{--									@endif--}}
{{--								</td>--}}
{{--								<td>--}}
{{--									@if($post->roomstatus == 0)--}}
{{--										<span class="label label-success">Còn trống</span>--}}
{{--									@elseif($post->approve == 1)--}}
{{--										<span class="label label-danger">Đã có người đăng ký</span>--}}
{{--									@endif--}}
{{--								</td>--}}
{{--								<td>--}}
{{--									<a href="phongtro/{{ $post->slug }}"><i class="fas fa-eye"></i> Xem</a>--}}
{{--									<a href="motelroom/del/{{ $post->id }}" style="color:red"><i class="fas fa-trash-alt"></i> Xóa</a>--}}
{{--									<a href="" title="Sửa"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button></a>--}}
{{--									<a href="" title="Xóa"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button></a>--}}
{{--								</td>--}}
{{--							</tr>--}}
{{--							@endforeach--}}
{{--						</tbody>--}}
{{--					</table>--}}
{{--					</div>--}}
{{--					@endif--}}
{{--				</div>	--}}
{{--			</div>--}}
{{--			@endif--}}
		</div>
	</div>
</div>
@endsection