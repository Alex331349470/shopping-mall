<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    public function goods()
    {
        return $this->hasMany(Good::class);
    }

    public static function getSelectOptions()
    {
        $options = \DB::table('categories')->select('id','name as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }
}
