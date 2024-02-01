@extends('layouts.app')

@section('breadcrumb-name', 'Product-History')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="timeline">
                        @if($products->isNotEmpty())
                            @foreach($products as $product)
                                @if($product->histories)
                                    @foreach($product->histories as $history)
                                        <div class="time-label">
                                            <span class="bg-green">{{ $history->created_at->format('j M. Y') }}</span>
                                        </div>

                                        <div>
                                            <i class="fas fa-history bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> {{ $history->created_at->format('H:i') }}</span>
                                                <h3 class="timeline-header"><a href="#">{{ $product->name }}</a> - {{ $history->field_name }} changed</h3>
                                                <div class="timeline-body">
                                                    <p>From: {{ $history->old_value }}</p>
                                                    <p>To: {{ $history->new_value }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Check if category_id is not null --}}
                                        @if($product->category_id)
                                            <div>
                                                <i class="fas fa-tags bg-purple"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header">Category Information</h3>
                                                    <div class="timeline-body">
                                                        <p>Category: {{ $product->category->name }}</p>
                                                        <p>Category ID: {{ $product->category_id }}</p>
                                                        <p>Category Description: {{ $product->category->description }}</p>
                                                        <p>Category Created At: {{ $product->category->created_at }}</p>
                                                        <p>Category Updated At: {{ $product->category->updated_at }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @else
                            <div>No data Found</div>
                        @endif

                        <div class="time-label">
                            <span class="bg-gray">End</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
