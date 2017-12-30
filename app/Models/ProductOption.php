<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'product_options';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'url', 'status', 'created_by', 'updated_by'
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

    public function listOption() {
        $data = parent::all();

        foreach ($data as $key => $value) {
            $category = ProductOptionMapCategory::select('name')
                                                ->leftJoin('categories', 'categories.id', '=', 'product_option_map_category.category_id')
                                                ->where('product_option_id', $value->id)
                                                ->pluck('name');
            $map = [];
            foreach ($category as $value) {
                $map[] = $value;
            }
            $data[$key]->category = implode(', ', $map);
        }

        return $data;
    }
}
