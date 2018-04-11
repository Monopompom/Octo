<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 4/11/2018
 * Time: 17:49
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Organization extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_octo_organizations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'route_name', 'leader_id'
    ];
}