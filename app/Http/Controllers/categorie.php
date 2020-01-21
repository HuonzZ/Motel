<?php

namespace App\Http\Controllers;
use App\Categories;
use Validator;
use Illuminate\Http\Request;

class categorie extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theloai = Categories::all();

        return  view('admin.categories.index',compact('theloai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:Categories,name|min:3|max:50',
            'slug'=>'required|unique:Categories,name|min:3|max:50',
        ],[
            'name.required' =>'tên thể loại không được để trống',
            'name.unique' =>'tên thể loại không đã được dùng',
            'name.min' => 'tên thể loại phải nhiều hơn 3 kí tự và nỏ hơn 50 kí tử',
            'name.max' => 'tên thể loại phải nhiều hơn 3 kí tự và nỏ hơn 50 kí tử',

            'slug.required' =>'slug không được để trống',
            'slug.unique' =>'slug không đã được dùng',
            'slug.min' => 'slug phải nhiều hơn 3 kí tự và nỏ hơn 50 kí tử',
            'slug.max' => 'slug phải nhiều hơn 3 kí tự và nỏ hơn 50 kí tử',
        ]);
        if ($validator->fails()) {
            return redirect()->route('categorie.create')
                ->withErrors($validator)
                ->withInput();
        }else{
            $them = Categories::create($request->all());
            return redirect()->route('categorie.index')->with('thongbao','thêm thể loại thành công');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sua = Categories::find($id);
        return view('admin.categories.edit',compact('sua'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Categories::find($id);
        $update-> name =$request->name;
        $update-> slug =$request->slug;
        $update -> update();
        return redirect()->route('categorie.edit',$id)->with('thongbao','sửa thông tin thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function xoa($id){
        $xoa = Categories::find($id);
        $xoa ->delete();
        return redirect()->route('categorie.index')->with('thongbao','xóa thành công');
    }
}
