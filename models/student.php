<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Student extends Eloquent {
    protected $fillable = ['uva_id', 'name'];
    public $timestamps = false;

    public static function accepted_cmp($user, $other_user)
    {
        if($user['accepted'] == $other_user['accepted'])
            if($user['submissions'] == $other_user['submissions'])
                return 0;
            else
                return $user['submissions'] > $other_user['submissions'] ? 1 : -1;

        return $user['accepted'] > $other_user['accepted'] ? -1 : 1;
    }


}

?>
