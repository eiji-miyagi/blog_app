<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index',['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 以下入力情報をデータベースに入力する関数
        // ログインしているユーザーのidを読み込む
        
        $id = Auth::id();
        // インスタンス化
        $post = new Post();
        // ボデイ、idを変数に入れる
        $post->body = $request->body;
        $post->user_id = $id;
        // エラー出るので仮入力
        $post->updated_at = 20200101;
        $post->created_at = 20200101;
        // データベースに保存


        $post->save();
        // 二重投稿を防ぐためリダイレクトで送信

        return redirect()->to('/posts');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $usr_id = $post->user_id;

        // ユーザーテーブルからデータ取得postとは別のテーブルなので文法変わっている
        
        $user = DB::table('users')->where('id', $usr_id)->first();

        return view('posts.detail',['post' => $post,'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = \App\Post::findOrFail($id);
        
         // $usr_id = $post->user_id;
        
        return view('posts.edit',['post' => $post]);
        // return view('posts.edit');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->post_id;
        // レコードを検索
        $post = Post::findOrFail($id);
        // 更新
        $post->body = $request->body;

        // エラー出るので仮入力
        $post->updated_at = 20200101;
        $post->created_at = 20200101;

        
        // データベースに保存
        $post->save();
        

        return redirect()->to('/posts');
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = \App\Post::find($id);
        
        $post->delete();
        
        return redirect()->to('/posts');
        
    }
}
