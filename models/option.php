<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Option extends Eloquent {
    public $primaryKey = 'name';
    protected $fillable = ['name', 'value'];
    public $timestamps = false;

}

?>
