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
        return view('posts.create')
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
        // データベースに保存
        $post->save();
        // 二重投稿を防ぐためリダイレクトで送信

        return redairect()->to('/posts');
        
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
        $user = BD::table('users')->where('id'.$usr_id)->first();

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
        $post = Post::findOrFail($id);
        return view('posts.edit',['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // レコードを検索
        $post = Post::findOrFail($id);
        // 更新
        $post->body = $request->body;
        
        // データベースに保存
        $post->save();

        return redairect()->to('/posts');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post = Post::find(id);
        
        $post->delete();
        return redairect()->to('/posts');
        
    }
}
