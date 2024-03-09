@extends('base')

@section('title', 'Accueil du blog')

@section('content')
    <h1>Mon blog</h1>
    @foreach ($posts as $post)
        <article>
            <h2>{{ $post->title }}</h2>
            <p class="small">
                ID : <a href="{{ route('blog.edit', ['post' => $post->id]) }}"><strong>{{ $post->id }}</strong></a>
                @if($post->category)
                    Catégorie : 
                    <a href="{{ route('blog.showCategory', ['id' => $post->category->id]) }}">
                        <strong>{{ $post->category?->name }}</strong>
                    </a>
                    @if(!$post->tags->isEmpty()),@endif
                @endif
                @if(!$post->tags->isEmpty())
                    Tags : 
                    @foreach($post->tags as $tag)
                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                    @endforeach
                @endif
            </p>
            @if($post->image)
                <img style="width: 100%; height:200px; object-fit:cover;" src="{{ $post->imageUrl() }}" alt="">
            @endif
            <p>{{ $post->content }}</p>
            <p>
                <a href="{{ route('blog.show', ['slug' => $post->slug, 'id' => $post->id]) }}" class="btn btn-primary">Lire la suite</a>
            </p>
        </article>
    @endforeach

    {{ $posts->links() }}
@endsection
