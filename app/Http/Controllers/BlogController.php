<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Http\Requests\FormPostRequest;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function create(): View
    {
        $post = new Post();
        return View('blog.create', [
            'post' => $post,
            'categories' => Category::select('id', 'name')->get(),
            'tags' => Tag::select('id', 'name')->get(),
        ]);
    }

    public function store(FormPostRequest $request)
    {
        $post = Post::create($this->extractData(new Post(), $request));
        $post->tags()->sync($request->validated('tags'));

        return redirect()->route('blog.show', ['slug' => $post->slug, 'id' => $post->id])
            ->with('success', "L'article a bien été sauvegardé");
    }

    public function edit(Post $post): View
    {
        return View('blog.edit', [
            'post' => $post,
            'categories' => Category::select('id', 'name')->get(),
            'tags' => Tag::select('id', 'name')->get(),
        ]);
    }

    public function update(Post $post, FormPostRequest $request)
    {
        $post->update($this->extractData($post, $request));
        $post->tags()->sync($request->validated('tags'));
        return redirect()->route('blog.show', ['slug' => $post->slug, 'id' => $post->id])
            ->with('success', "L'article a bien été modifié");
    }

    private function extractData(Post $post, FormPostRequest $request): array
    {
        $data = $request->validated();
        $image = $request->validated('image');
        if ($image == null || $image->getError()) {
            return $data;
        }
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $data['image'] = $image->store('blog', 'public');
        return $data;
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

    public function showCategory(string $id): RedirectResponse | View
    {
        $posts = Post::whereHas('category', function ($query) use ($id) {
            $query->where('id', $id);
        })->paginate(10);

        return view('blog.index', [
            'posts' => $posts,
        ]);
    }
}
