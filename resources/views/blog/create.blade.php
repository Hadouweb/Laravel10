@extends('base')

@section('title', 'Créer un article')

@section('content')
    <form action="" method="post">
        @csrf
        <div>
            <input type="text" name="title" value="{{ old('title', 'Titre') }}">
            @error('title')
                {{ $message }}
            @enderror
        </div>
        <div>
            <textarea name="content">{{ old('content', 'Contenu') }}</textarea>
            @error('content')
                {{ $message }}
            @enderror
        </div>
        <div>
            <span>Catégorie : </span>
            <select name="category">
                <option value="voiture" {{ old('category') == 'voiture' ? 'selected' : '' }}>Voiture</option>
                <option value="blog" {{ old('category') == 'blog' ? 'selected' : '' }}>Blog</option>
            </select>
            @error('category')
                {{ $message }}
            @enderror
        </div>
        <button>Enregistrer</button>
    </form>
@endsection
