<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormPostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BlogController extends Controller
{

    public function create(): View
    {
        $post = new Post();
        return View('blog.create', [
            'post' => $post
        ]);
    }

    public function store(FormPostRequest $request)
    {
        $post = Post::create($request->validated());

        return redirect()->route('blog.show', ['slug' => $post->slug, 'id' => $post->id])
                ->with('success', "L'article a bien été sauvegardé");
    }

    public function edit(Post $post): View
    {
        return View('blog.edit', [
            'post' => $post,
            'categories' => Category::select('id', 'name')->get(),
        ]);
    }

    public function update(Post $post, FormPostRequest $request)
    {
        $post->update($request->validated());

        return redirect()->route('blog.show', ['slug' => $post->slug, 'id' => $post->id])
                ->with('success', "L'article a bien été modifié");
    }

    public function index(): View
    {
        return view('blog.index', [
            'posts' => Post::with('tags', 'category')->paginate(10),
        ]);
    }

    public function show(string $slug, string $id): RedirectResponse | View
    {
        $post = Post::findOrFail($id);
        if ($post->slug !== $slug) {
            return to_route('blog.show', ['slug' => $post->slug, 'id' => $post->id]);
        }
        
        return View('blog.show', [
            'post' => $post,
        ]);
    }

}
