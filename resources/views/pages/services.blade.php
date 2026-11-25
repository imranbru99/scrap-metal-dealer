@extends('layouts.app')
@section('title', 'Scrap Metal Services')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">ForgeHarbor buys, grades, and hauls scrap across Milwaukee and southeast Wisconsin — walk-up scale house through industrial contracts.</p>
        <div class="grid-3">
            @foreach([
                ['ferrous-scrap','Ferrous Scrap Buying','https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=1200&q=80'],
                ['non-ferrous-metals','Non-Ferrous Metals','https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=1200&q=80'],
                ['catalytic-converters','Catalytic Converters','https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=1200&q=80'],
                ['industrial-scrap-contracts','Industrial Scrap Contracts','https://images.unsplash.com/photo-1587293852726-70cdb56c2866?auto=format&fit=crop&w=1200&q=80'],
                ['container-pickup','Container & Roll-Off Pickup','https://images.unsplash.com/photo-1565793298595-6a879b1d9492?auto=format&fit=crop&w=1200&q=80'],
                ['scale-house-payouts','Scale House & Payouts','https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad"><h3>{{ $title }}</h3></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
