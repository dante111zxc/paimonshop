@extends('public.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product-category-content">
                    <h1>{{ $category->title }}</h1>
                    <div class="desc">
                        {{ $category->desc }}
                    </div>
                </div>


                @if(!$category->childCategories->count())
                    @if( !empty($productFeature) )
                        <div class="product-feature">
                            <div class="swiper-container">

                                <div class="swiper-wrapper">
                                    @foreach ( $productFeature as $key => $item)
                                        <div class="swiper-slide">
                                            <div data-wow-duration="1.5s" class="card border-0 wow fadeIn">
                                                <a class="d-block position-relative card-img"
                                                   href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}"
                                                   title="{{ $item->title }}">

                                                    <img src="{{ getThumbnail($item->thumbnail) }}" class="card-img-top" alt="{{ $item->title }}">
                                                    {!! saleOff($item) !!}
                                                </a>

                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <a href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}" title="{{ $item->title }}">
                                                                {{ $item->title }}
                                                            </a>
                                                        </h5>
                                                    </div>


                                                    <div class="price">

                                                        @if ( !empty($item->price) && !empty($item->price_sale) && ( $item->price >  $item->price_sale) )
                                                            <span class="regular-price"><del>{!! showMoney($item->price) !!}</del></span>
                                                        @endif


                                                        @if( !empty($item->price_sale) && ($item->price_sale < $item->price))
                                                            <span class="price-sale">{!! showMoney($item->price_sale) !!}</span>
                                                        @else
                                                            <span class="price-sale">{!! showMoney($item->price) !!}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <i class="button-prev bi bi-chevron-left"></i>
                            <i class="button-next bi bi-chevron-right"></i>
                        </div>
                    @endif
                @endif

            </div>
            @if($category->childCategories->count())

                @foreach ($category->childCategories as $key => $item)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="category-item">
                        <a class="thumbnail" href="{{ route('product_category', ['id' => $item->id, 'slug' => $item->slug]) }}">
                            <img src="{{ getThumbnail($item->thumbnail) }}" alt="{{ $item->title }}">
                        </a>
                        <a class="title" href="{{ route('product_category', ['id' => $item->id, 'slug' => $item->slug]) }}">
                            {{ $item->title }}
                        </a>
                    </div>
                </div>
                @endforeach

                @else
                    <div class="col-12 col-md-3 order-2 order-md-1">
                        <form method="GET" class="form-filter-widget" id="formFilter">
                            @csrf
                            <input type="hidden" name="sort_by" value="1">
                            <div class="widget widget-filter">
                                <h3 class="widget-title">T??nh tr???ng</h3>
                                <select onchange="selected(this)" name="product_status" class="form-control">
                                    <option value="1" {{ ($dataFilter['product_status'] == 1) ? 'selected=selected' : '' }}>C??n h??ng</option>
                                    <option value="0" {{ ($dataFilter['product_status'] == 0) ? 'selected=selected' : '' }}>H???t h??ng</option>
                                </select>
                            </div>

                            @if(!empty($attributes))
                                @foreach($attributes as $key => $attr)
                                    <div class="widget widget-platform">
                                        <h3 class="widget-title">{{ $attr->title }}</h3>

                                        @if($attr->childAttributes)
                                            @foreach($attr->childAttributes as $keyAttr => $itemAttr)
                                                <div class="custom-control custom-checkbox">
                                                    <input name="attribute[]" {{ (!empty($dataFilter['attributes']) && in_array($itemAttr->id, $dataFilter['attributes']) === true ) ? 'checked=checked' : '' }} onclick="checkbox(this)" type="checkbox" class="custom-control-input" id="{{ $itemAttr->slug . $keyAttr }}" value="{{ $itemAttr->id }}">
                                                    <label class="custom-control-label" for="{{ $itemAttr->slug . $keyAttr }}">{{ $itemAttr->title }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            @endif


                            <div class="widget widget-price-range">
                                <h3 class="widget-title">Kho???ng gi??</h3>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Gi?? t???: </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="price_from">
                                    </div>

                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">?????n: </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="price_to">
                                    </div>
                                </div>

                            </div>


                            <a href="{{ route('product_category', ['id' => $category->id, 'slug' => $category->slug]) }}" class="btn"><i class="bi bi-x-lg"></i> Reset filter</a>
                            <button type="submit" class="btn"><i class="bi bi-funnel"></i> L???c s???n ph???m</button>
                        </form>
                    </div>
                    <div class="col-12 col-md-9 order-1 order-md-2">
                        <div class="widget widget-sort-product-by">
                            <form method="GET">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-7 col-form-label">T??m th???y {{ $product->total() }} s???n ph???m</label>
                                    <label class="col-sm-2 col-form-label">S???p x???p theo</label>
                                    <div class="col-sm-3">
                                        <select onchange="sortProduct(this)" class="form-control" name="sort_by" id="sort-by">
                                            <option value="0" {{ ($dataFilter['sort_by'] == 0) ? 'selected=selected' : '' }}>Th??? t??? m???c ?????nh</option>
                                            <option value="1" {{ ($dataFilter['sort_by'] == 1) ? 'selected=selected' : '' }}>Gi?? th???p ?????n cao</option>
                                            <option value="2" {{ ($dataFilter['sort_by'] == 2) ? 'selected=selected' : '' }}>Gi?? cao ?????n th???p</option>
                                            <option value="3" {{ ($dataFilter['sort_by'] == 3) ? 'selected=selected' : '' }}>T??n t??? A-Z</option>
                                            <option value="4" {{ ($dataFilter['sort_by'] == 4) ? 'selected=selected' : '' }}>T??n Z-A</option>
                                            <option value="5" {{ ($dataFilter['sort_by'] == 5) ? 'selected=selected' : '' }}>S???n ph???m gi???m gi??</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(!empty($product))
                            <div class="product-list">
                                @foreach($product as $key => $item)
                                    <div data-wow-duration="1.5s" class="card border-0 col-md-1/4 col-1/2 wow fadeIn">
                                        <a class="d-block position-relative card-img" href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                            <img src="{{ getThumbnail($item->thumbnail) }}" class="card-img-top" alt="{{ $item->title }}">
                                            {!! saleOff($item) !!}
                                        </a>

                                        <div class="card-content">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}" title="{{ $item->title }}">
                                                        {{ $item->title }}
                                                    </a>
                                                </h5>
                                                {{--                                    <div class="platform">--}}
                                                {{--                                        @if($item->attribute) @foreach($item->attribute as $attr)--}}
                                                {{--                                            <span><img src="{{ getThumbnail($attr->thumbnail) }}"></span>--}}
                                                {{--                                        @endforeach @endif--}}
                                                {{--                                    </div>--}}
                                            </div>
                                            <div class="price">
                                                @if ( !empty($item->price) && !empty($item->price_sale) && ( $item->price >  $item->price_sale) )
                                                    <span class="regular-price"><del>{!! showMoney($item->price) !!}</del></span>
                                                @endif

                                                @if( !empty($item->price_sale) && ($item->price_sale < $item->price))
                                                    <span class="price-sale">{!! showMoney($item->price_sale) !!}</span>
                                                @else
                                                    <span class="price-sale">{!! showMoney($item->price) !!}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            {{ $product->links() }}

                        @endif
                    </div>
            @endif

        </div>
    </div>
@endsection
