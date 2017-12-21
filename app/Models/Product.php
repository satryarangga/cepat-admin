<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'original_price', 'discount_price', 'modal_price', 'weight', 'description', 'created_by', 'updated_by', 'status',
        'partner_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function getListProduct($filter = [], $sortBy = 'products.updated_at', $limit = 10) {
        $user = Auth::user();
        $where = [];

        $keyword = $filter['keyword'];
        if($filter['search_by'] == 'product_name' && $keyword) {
            $where[] = ['products.name', 'like', "%$keyword%"];
        }

        if($user->partner_id) {
            $where[] = ['partner_id', '=', $user->partner_id];   
        }

        $data = parent::select('products.id', 'name', 'original_price', 'weight', 'duration', 'product_countdown.id as countdown_id', 'end_on', 'start_on')
                        ->leftJoin('product_countdown', 'product_countdown.product_id', '=', 'products.id')
                        ->orderBy($sortBy, 'desc')
                        ->where($where)
                        ->paginate($limit);

        return $data;
    }
}
