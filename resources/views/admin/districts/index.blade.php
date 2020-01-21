@extends('admin.layout.master')
@section('content2')
    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Danh sách các quận huyện</h4>
                </div>
            </div>

            <div class="breadcrumb-line">
                <ul class="breadcrumb">
                    <li><a href="admin"><i class="icon-home2 position-left"></i> Trang chủ</a></li>
                    <li class="active">Trang Quản Lý</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="panel panel-flat">
{{--                        <div class="panel-heading">--}}
{{--                            <h5 class="panel-title">Danh sách các phòng trọ <span class="badge badge-primary">{{$motelrooms->count()}}</span></h5>--}}
{{--                        </div>--}}

                        <div class="panel-body">
                            Các <code>Tài khoản</code> được liệt kê tại đây. <strong>Dữ liệu đang cập nhật.</strong>
                        </div>
                        @if(session('thongbao'))
                            <div class="alert bg-success">
                                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                                <span class="text-semibold">Well done!</span>  {{session('thongbao')}}
                            </div>
                        @endif
                        <table class="table datatable-show-all">
                            <thead>
                            <tr class="bg-blue">
                                <th>ID</th>
                                <th>Tên quận/huyện</th>
                                <th>Slug</th>
                                <th class="text-center">Chức năng</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($khuvuc as $kv)
                                <tr>
                                    <td>{{$kv->id}}</td>
                                    <td>{{$kv->name}}</td>
                                    <td>{{$kv->slug}}</td>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{route('districts.create')}}"><i class="glyphicon glyphicon-plus" ></i> Thêm</a></li>
                                                    <li><a href="{{url('admin/districts/'.$kv->id.'/edit')}}"><i class="glyphicon glyphicon-pencil" ></i> Sửa</a></li>
                                                    <li><a href="{{route('xoakv',$kv->id)}}"><i class="glyphicon glyphicon-trash"></i> Xóa</a></li>

                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <div class="footer text-muted">
                &copy; 2019. <a href="#">Techmotel Project</a> by <a href="" target="_blank">Nguyễn Thị Bích Thủy</a>
            </div>
            <!-- /footer -->
        </div>
    </div>

@endsection