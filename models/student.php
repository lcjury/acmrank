<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Student extends Eloquent {
    protected $fillable = ['uva_id', 'name'];
    public $timestamps = false;
}

?>
