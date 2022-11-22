<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $searchData = $request->input();
        $posts = (new Post())->getAll($searchData['name'] ?? '')->paginate(config('const.page.limit'));
        return view('admin.posts.index', compact('posts','searchData'));
    }

    public function detail($id = 0)
    {
        $post = !empty($id) ? Post::find($id) : null;

        if (!empty($id) && is_null($post)) {
            return redirect()->route('admin.post.list');
        }
        return view('admin.posts.detail', compact('post'));
    }

    public function store(Request $request)
    {
        try {
            $dataPost = $request->all();
            $dataPost['tag'] = str_replace(' ', '_', $dataPost['tag']);
            $id = $dataPost['id'] ?? 0;
            if (!$id) {
                Post::create($dataPost);
                $request->session()->flash('success', 'Post has been created');
            } else {
                $post = Post::findOrFail($id);
                $post->fill($dataPost);
                $post->save();
                $request->session()->flash('success', 'Post has been updated');
            }
            return redirect()->route('admin.post.list');
        } catch (\Exception $e) {
            Log::info('---store post---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error has occurred");
            return redirect()->route('admin.post.list');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $post = Post::find($id);
            $post->delete();
            $request->session()->flash('success', 'Post has been deleted');
            return [
                'success' => true,
                'redirectTo' => route("admin.post.list")
            ];
        } catch (\Exception $e) {
            Log::info('---Delete post---');
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
