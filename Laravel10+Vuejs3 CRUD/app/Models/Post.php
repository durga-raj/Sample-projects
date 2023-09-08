<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Post extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'body'];
    protected $hidden = [
        'created_by',
        'status'
    ];
    public $timestamps = false;
    use HasFactory;

    public static function getListPosts($request)
    {
        $role = $request->query('userrole');
        $userId = $request->query('userid');
        $query = Post::select('posts.*', 'users.name as posted_by')
            ->leftJoin('users', 'users.id', '=', 'posts.created_by');

        if ($role !== 'Admin') {
            $query->where('posts.created_by', $userId);
        }
        $query->orderByDesc('posts.id');
        $posts = $query->get();

        $response = [
            'data' => $posts,
            'status' => true
        ];
        return $response;
    }
    public static function savePost($request)
    {
        try {
            $post = new Post();
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->created_by = $request->input('created_by');
            $post->status = 1;
            $post->created_at = date("Y-m-d h:i:s");
            if ($post->save()) {
                $response = [
                    'type' => "success",
                    'message' => "Post created successfully!!"
                ];
            } else {
                $response = [
                    'type' => "error",
                    'message' => "Something went wrong! Please try again!"
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'type' => "error",
                'message' => "Something went wrong! Please try again!"
            ];
            Log::info($e->getMessage());
        }

        return $response;
    }
    public static function showPost($id)
    {
        $query = Post::select('posts.*', 'users.name as posted_by')
            ->leftJoin('users', 'users.id', '=', 'posts.created_by')
            ->where('posts.id', $id);

        $post = $query->first();

        $response = [
            'data' => $post
        ];
        return $response;
    }
    public static function updatePost($request, $id)
    {
        try {
            $post = Post::find($id);

            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->updated_at = date("Y-m-d h:i:s");
            if ($post->save()) {
                $response = [
                    'type' => "success",
                    'message' => "Post updated successfully!!"
                ];
            } else {
                $response = [
                    'type' => "error",
                    'message' => "Something went wrong! Please try again!"
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'type' => "error",
                'message' => "Something went wrong! Please try again!"
            ];
            Log::info($e->getMessage());
        }
        return $response;
    }

    public static function deletePost($id)
    {
        try {
            $result = Post::destroy($id);
            if ($result > 0) {
                $response = [
                    'type' => "success",
                    'message' => "Post deleted successfully!!"
                ];
            } else {
                $response = [
                    'type' => "error",
                    'message' => "Something went wrong! Please try again!"
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'type' => "error",
                'message' => "Something went wrong! Please try again!"
            ];
            Log::info($e->getMessage());
        }
        return $response;
    }
}
