<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:product.view')->only('index');
        $this->middleware('can:product.create')->only(['create', 'store']);
        $this->middleware('can:product.edit')->only(['edit', 'update']);
        $this->middleware('can:product.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index');
    }


    public function dataTable (){
        return Product::buildDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = ProductCategory::query()->whereNull('parent_id')->where(['status' => 1])->orderBy('id', 'desc')->get();
        $tag = ProductTag::query()->where([
            'status' => 1
        ])->orderBy('id', 'desc')->get();
        $product_related = Product::query()->where([
            'status' => 1
        ])->orderBy('id', 'desc')->get();
        $attribute = ProductAttributes::query()->whereNull('parent_id')->where('status', 1)->orderBy('id','desc')->get();
        return view('admin.product.create', compact('category', 'tag', 'product_related', 'attribute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => "required",
            'slug' => 'required|unique:products,slug',
            'desc' => 'required',
            'category_id' => 'required',
            'sku' => 'required|unique:products,sku',


        ],[
            'title.required' => 'Ti??u ????? kh??ng ???????c b??? tr???ng',
            'slug.required' => 'Slug kh??ng ???????c b??? tr???ng',
            'slug.unique' => 'Slug ???? t???n t???i',
            'desc.required' => 'M?? t??? kh??ng ???????c b??? tr???ng',
            'sku.required' => 'M?? s???n ph???m kh??ng ???????c b??? tr???ng',
            'sku.unique' => 'M?? s???n ph???m ???? t???n t???i',
            'category_id.required' => 'Danh m???c kh??ng ???????c b??? tr???ng',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->input('price_sale') > $request->input('price')) {
            $validator->errors()->add('price_sale', 'Gi?? sale ph???i nh??? h??n gi?? g???c');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new Product();
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'C?? l???i x???y ra'])->withInput();

        $model->category()->attach($request->input('category_id'));
        $model->tag()->attach($request->input('tag_id'));
        $model->attribute()->attach($request->input('attribute_id'));

        return redirect()->route('product.edit', $model->id )->with('success', 'T???o s???n ph???m th??nh c??ng');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::query()->find($id);
        $category = ProductCategory::query()->whereNull('parent_id')
            ->where([
                'status' => 1
            ])->orderBy('id', 'desc')->get();

        $tag = ProductTag::query()->where([
            'status' => 1
        ])->orderBy('id', 'desc')->get();

        $idCategory = ($product->category) ? array_column($product->category->toArray(), 'id') : [];
        $idTag = ($product->tag) ? array_column($product->tag->toArray(), 'id') : [];

        $product_related = Product::query()->where([
            'status' => 1
        ])->whereNotIn('id', [$id])->orderBy('id', 'desc')->get();
        $idProductRelated = ($product->product_related) ? json_decode($product->product_related) : [];

        $attribute = ProductAttributes::query()->whereNull('parent_id')->where('status', 1)->orderBy('id', 'desc')->get();
        $idAttribute = ($product->attribute) ? array_column($product->attribute->toArray(), 'id') : [];


        $gallery = ($product->gallery !== '[null]') ? json_decode($product->gallery) : null;
        return view('admin.product.edit', compact(
            'product',
            'category',
            'tag',
            'idCategory',
            'idTag',
            'product_related',
            'idProductRelated',
            'gallery',
            'attribute',
            'idAttribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            'title' => "required",
            'slug' => "required|unique:products,slug,$id",
            'desc' => 'required',
            'category_id' => 'required',
            'sku' => "required|unique:products,sku,$id",

        ],[
            'title.required' => 'Ti??u ????? kh??ng ???????c b??? tr???ng',
            'slug.required' => 'Slug kh??ng ???????c b??? tr???ng',
            'slug.unique' => 'Slug ???? t???n t???i',
            'desc.required' => 'M?? t??? kh??ng ???????c b??? tr???ng',
            'sku.required' => 'M?? s???n ph???m kh??ng ???????c b??? tr???ng',
            'sku.unique' => 'M?? s???n ph???m ???? t???n t???i',
            'category_id.required' => 'Danh m???c kh??ng ???????c b??? tr???ng',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($request->input('price_sale') > $request->input('price')) {
            $validator->errors()->add('price_sale', 'Gi?? sale ph???i nh??? h??n gi?? g???c');
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $model = Product::query()->find($id);
        $model->fill($request->all());
        $save = $model->save();
        if (!$save) return redirect()->back()->withErrors(['message' => 'C?? l???i x???y ra'])->withInput();

        $model->category()->sync($request->input('category_id'));
        $model->tag()->sync($request->input('tag_id'));
        $model->attribute()->sync($request->input('attribute_id'));

        return redirect()->route('product.edit', $model->id )->with('success', 'C???p nh???t s???n ph???m th??nh c??ng');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $product = Product::query()->find($id);
                if ($product->delete()) {
                    return response()->json([
                        'type' => 'success',
                        'code' => 200,
                        'message' => 'X??a b???n ghi th??nh c??ng'
                    ]);
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }
}
