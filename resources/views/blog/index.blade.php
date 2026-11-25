@extends('layouts.app')
@section('title', 'Yard Journal')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Yard Journal</h2>
        <p class="lede">Scale-house notes on grading copper, ferrous loads, and industrial scrap contracts in Cleveland and Northeast Ohio.</p>
        <div class="grid-3">
            @foreach($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    @if($post->cover_image)
                        <img src="{{ $post->cover_image }}" alt="" style="width:100%;height:160px;object-fit:cover;margin-bottom:.8rem;">
                    @endif
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @endforeach
        </div>
        <div style="margin-top:2rem">{{ $posts->links() }}</div>
    </div>
</section>
@endsection
