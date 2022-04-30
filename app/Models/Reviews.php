<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class Reviews extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'slug',
        'post_id',
        'content',
        'user_id',
        'status',
        'feature',
        'sort',
        'vote',
        'ip'
    ];
    protected static $onlyField = [
        'id',
        'vote',
        'feature',
        'status',
        'action',
        'time',
    ];

    const STATUS = [
        0 => 'Ẩn',
        1 => 'Hiện'
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'success'
    ];

    protected $table = 'reviews';

    public function user (){
        return $this->hasOne(User::class, 'id','user_id');
    }

    public static function buildDataTable (){
        $model = Reviews::query();
        $dataTable = new DataTables();
        $data = $dataTable->eloquent($model)
//            ->filter( function ($query) {
//                if (request()->has('search')) {
//                    $query->where('title', 'like', "%" . request('search')['value'] . "%");
//                }
//            })
            ->editColumn('vote', function ($instance) {
                return '<span>'.$instance->vote.'</span>';
            })
            ->editColumn('status', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->status].'">'.self::STATUS[$instance->status].'</span>';
            })

            ->editColumn('feature', function ($instance) {
                return '<span class="label label-'.self::STATUS_COLOR[$instance->feature].'">'.self::STATUS[$instance->feature].'</span>';
            })

            ->addColumn( 'action', function ($instance) {
                $html = '';

                if (Gate::allows('reviews.edit')) {
                    $html .= '<a href="'.route('reviews.edit', $instance->id ).'" class="btn btn-xs btn-primary btnEdit" style="margin-right: 5px"><i class="fa fa-fw fa-edit"></i> Sửa</a>';
                }

                if (Gate::allows('reviews.delete')) {
                    $html .= '<a data-href="'.route('reviews.destroy', $instance->id ).'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger btnDelete"><i class="fa fa-fw fa-trash-o"></i> Xóa</a>';
                }


                return $html;
            })

            ->addColumn('time', function ($instance) {
                $html = '<div><b>Ngày tạo: </b>'.date('d/m/Y H:i', strtotime($instance->created_at)).'</div>';
                $html .= '<div><b>Ngày cập nhật: </b>'.date('d/m/Y H:i', strtotime($instance->updated_at)).'</div>';
                return $html;
            })
            ->rawColumns(self::$onlyField)->only(self::$onlyField)->make(true);
        return $data;
    }
}
