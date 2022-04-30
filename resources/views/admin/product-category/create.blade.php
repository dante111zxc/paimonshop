@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{ route('product-category.store') }}" method="POST">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Thêm mới danh mục sản phẩm</h3>
                            <a href="{{ route('product-category.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('product-category.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group has-feedback @if ($errors->has('title')) {{ 'has-error' }} @endif">
                                <label for="title" class="required">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                @if($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('slug')) {{ 'has-error' }} @endif">
                                <label for="slug" class="required">Đường dẫn</label>
                                <input type="text" class="form-control" name="slug" value="{{ old('slug') }}">
                                @if($errors->has('slug'))
                                    <span class="help-block">{{ $errors->first('slug') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('desc')) {{ 'has-error' }} @endif">
                                <label for="desc" class="required">Mô tả</label>
                                <textarea rows="5" class="form-control" name="desc">{{ old('desc') }}</textarea>
                                @if($errors->has('desc'))
                                    <span class="help-block">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('content')) {{ 'has-error' }} @endif">
                                <label for="content">Nội dung</label>
                                <textarea id="content" rows="5" class="form-control" name="content">{{ old('content') }}</textarea>
                                @if($errors->has('content'))
                                    <span class="help-block">{{ $errors->first('content') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group @if ($errors->has('parent_id')) {{ 'has-error' }} @endif">
                                <label for="parent_id">Danh mục cha</label>
                                <select style="width: 100%" name="parent_id" id="parent_id" class="form-control" data-placeholder="Chọn danh mục cha" data-allow-clear="true">
                                    <option value=""></option>
                                    @foreach($taxonomies as $item)
                                        <option value="{{ $item->id }}"> {{ $item->title }}</option>
                                        @if($item->childCategories)
                                            @foreach($item->childCategories as $subCategories)
                                                @include('admin.product-category.creat_sub_categories', ['taxonomies' => $subCategories,  'char' => '--'])
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                                @if($errors->has('parent_id'))
                                    <span class="help-block">{{ $errors->first('parent_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('meta_title')) {{ 'has-error' }} @endif">
                                <label for="meta_title">Tiêu đề SEO</label>
                                <input type="text" name="meta_title" class="form-control" id="meta_title" value="{{ old('meta_title') }}">
                                @if($errors->has('meta_title'))
                                    <span class="help-block">{{ $errors->first('meta_title') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('meta_desc')) {{ 'has-error' }} @endif">
                                <label for="meta_desc">Mô tả SEO</label>
                                <textarea rows="5" class="form-control" name="meta_desc">{{ old('meta_desc') }}</textarea>
                                @if($errors->has('meta_desc'))
                                    <span class="help-block">{{ $errors->first('meta_desc') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('meta_keyword')) {{ 'has-error' }} @endif">
                                <label for="meta_keyword">Từ khóa SEO</label>
                                <input type="text" name="meta_keyword" class="form-control" id="meta_keyword" value="{{ old('meta_keyword') }}">
                                @if($errors->has('meta_keyword'))
                                    <span class="help-block">{{ $errors->first('meta_keyword') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('sort')) {{ 'has-error' }} @endif">
                                <label for="sort">Thứ tự</label>
                                <input type="text" name="sort" class="form-control" id="sort" value="{{ old('sort', 9999) }}">
                                @if($errors->has('sort'))
                                    <span class="help-block">{{ $errors->first('sort') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('feature')) {{ 'has-error' }} @endif">
                                <label for="feature">Nổi bật</label>
                                <select style="width: 100%" name="feature" id="feature" class="form-control">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện</option>

                                </select>
                                @if($errors->has('feature'))
                                    <span class="help-block">{{ $errors->first('feature') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="thumbnail">Ảnh đại diện</label>
                                <input id="thumbnail" type="hidden" class="form-control" name="thumbnail">
                                <div class="box-thumbnail">
                                    <div class="box-preview">
                                        <a href="javascript:void(0)" class="clear-img"> <i class="fa fa-close"></i> </a>
                                        <img id="thumbnailPreview" src="{{ asset('adminLTE') }}/dist/img/no-img.png">
                                    </div>
                                    <button id="uploadThumbnail" class="btn btn-primary btn-block">Upload image</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="pull-right">
                        <a href="{{ route('product-category.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
                    </div>
                </div>

            </div>
        </section>
    </form>

@endsection
@push('script')
    <script type="text/javascript">
        $('#status').select2();
        $('#feature').select2();
        $('#parent_id').select2({
            allowClear: true,
            placeholder: 'Chọn danh mục'
        });
        $('[name="title"]').on('keyup', function () {
            let slug = UI.toSlug($(this).val());
            $('[name="slug"]').val(slug);
        });
    </script>
@endpush
