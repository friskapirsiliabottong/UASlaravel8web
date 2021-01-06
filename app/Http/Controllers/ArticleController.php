<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles=Article::orderBy('id','DESC')->paginate();
        //return view('article.index');
        return view('article.manage.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories=Category::get();
        return view('article.manage.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




    public function store(Request $request)
    {
        //
        $rules=[
            'category'=>'required',
            'title'=>'required|unique:articles|min:5|max:75',
            'content'=>'required|min:20|max:2500',
            'file'=>'required|max:500|mimes:jpeg,png,jpg',
        ];
        $messages=[
            'category.required'=>' kategori tidak boleh kosong',
            'title.required'=>'judul tidak boleh kosong',
            'title.unique'=>' judul sudah digunakan',
            'title.min'=>' judul karakter terlalu pendek',
            'title.max'=>' judul karakter terlalu panjang',
            'content.required'=>'artikel tidak boleh kosong',
            'content.min'=>' artikel karakter terlalu pendek',
            'content.max'=>' artikel karakter terlalu panjang',
            'content.required'=>'artikel tidak boleh kosong',
            'content.min'=>' artikel karakter terlalu pendek',
            'content.max'=>' artikel karakter terlalu panjang',
            'file.required'=>'file tidak boleh kosong',
            'file.max'=>' file ukurannya terlalu besar',
        ];
        $this->validate($request,$rules,$messages);
        $fileName=time().'.'.$request->file->extension();
        $request->file('file')->storeAs('public',$fileName);
        $articles=Article::create([
            'category_id'=>$request->category,
            'title'=>$request->title,
            'content'=>$request->content,
            'file'=>$fileName,
          
        ]);

        /*$articles=New Article();
        $articles->category_id=$request->category;
        $articles->title=$request->title;
        $articles->content=$request->content;
        $articles->save();*/
        return back()->with('success','posting data sukses!');
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
        $articles=Article::whereId($id)->first();
        return view('article.show', compact('articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categories=Category::get();
        $articles=Article::find($id);
        return view('article.manage.edit', compact('categories','articles'));
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
        //
        $rules=[
            'category'=>'required',
            'title'=>'required|unique:articles|min:5|max:75',
            'content'=>'required|min:20|max:2500',
            'file'=>'required|max:500|mimes:jpeg,png,jpg',
        ];
        $messages=[
            'category.required'=>' kategori tidak boleh kosong',
            'title.required'=>'judul tidak boleh kosong',
            'title.unique'=>' judul sudah digunakan',
            'title.min'=>' judul karakter terlalu pendek',
            'title.max'=>' judul karakter terlalu panjang',
            'content.required'=>'artikel tidak boleh kosong',
            'content.min'=>' artikel karakter terlalu pendek',
            'content.max'=>' artikel karakter terlalu panjang',
            'content.required'=>'artikel tidak boleh kosong',
            'content.min'=>' artikel karakter terlalu pendek',
            'content.max'=>' artikel karakter terlalu panjang',
            'file.required'=>'file tidak boleh kosong',
            'file.max'=>' file ukurannya terlalu besar',
        ];
        $this->validate($request,$rules,$messages);
        $articles=Article::whereId($id)->first();
        if(\File::exists('storage/'.$articles->file)){
            \File::delete('storage/'.$articles->file);
        }
        $fileName=time().'.'.$request->file->extension();
        $request->file('file')->storeAs('public',$fileName);
        $articles->update([
            'category_id'=>$request->category,
            'title'=>$request->title,
            'content'=>$request->content,
            'file'=>$fileName,
         
        ]);

        /*$articles=Article::find($request->id);
        $articles->category_id=$request->category;
        $articles->title=$request->title;
        $articles->content=$request->content;
        $articles->save();*/

        return back()->with('success','Ubah data sukses!');
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
        $articles=Article::whereId($id)->first();
        if(\File::exists('storage/'.$articles->file)){
            \File::delete('storage/'.$articles->file);
        }
        Article::whereId($id)->delete();
        return back()->with('success','Hapus data sukses!');
    }
}