<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Solved extends Eloquent {
    protected $fillable = ['problem_id', 'timestamp', 'student_id'];
    public $timestamps = false;
}

?>
