@extends('admin.layout.master')
@section('content2')
    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Danh sách các loại phòng trọ</h4>
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
                    @if (count($errors)>0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $err)
                                {{$err}}
                            @endforeach
                        </div>
                    @endif
                    @if(session('thongbao'))
                        <div class="alert bg-success">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">Well done!</span>  {{session('thongbao')}}
                        </div>
                    @endif
                </div>
                <form action="{{route('categorie.store')}}" method="post">

                    {{ csrf_field() }}
                    <div class="form-group">
                        <label >Tên thể loại:</label>
                        <input type="text" class="form-control" id="title" name="name"  onkeyup="ChangeToSlug()">
                        <br>
                        <label >Slug:</label>
                        <input type="text" class="form-control" id="slug" name="slug" >
                        <script language="javascript">
                            function ChangeToSlug()
                            {
                                var title, slug;

                                //Lấy text từ thẻ input title
                                title = document.getElementById("title").value;

                                //Đổi chữ hoa thành chữ thường
                                slug = title.toLowerCase();

                                //Đổi ký tự có dấu thành không dấu
                                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                                slug = slug.replace(/đ/gi, 'd');
                                //Xóa các ký tự đặt biệt
                                slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
                                //Đổi khoảng trắng thành ký tự gạch ngang
                                slug = slug.replace(/ /gi, "-");
                                //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
                                //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
                                slug = slug.replace(/\-\-\-\-\-/gi, '-');
                                slug = slug.replace(/\-\-\-\-/gi, '-');
                                slug = slug.replace(/\-\-\-/gi, '-');
                                slug = slug.replace(/\-\-/gi, '-');
                                //Xóa các ký tự gạch ngang ở đầu và cuối
                                slug = '@' + slug + '@';
                                slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                                //In slug ra textbox có id “slug”
                                document.getElementById('slug').value = slug;
                            }
                        </script>
                    </div>
                    <button type="submit" class="btn btn-primary ">Thêm thông tin</button>
                </form>
            </div>
            <!-- Footer -->
            <div class="footer text-muted">
                &copy; 2019. <a href="#">Techmotel Project</a> by <a href="" target="_blank">Nguyễn Thị Bích Thủy</a>
            </div>
            <!-- /footer -->
        </div>
    </div>

@endsection