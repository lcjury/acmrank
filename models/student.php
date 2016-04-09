<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Student extends Eloquent {
    protected $fillable = ['uva_id', 'name'];
    public $timestamps = false;

    /*
     * User with most accepted first, if two users have
     * the same amount of accepted, the user with less
     * submissions is higher on the ranking
     */
    public static function accepted_cmp($user, $other_user)
    {
        if($user->accepted == $other_user->accepted)
            if($user->submissions == $other_user->submissions)
                return 0;
            else
                return $user->submissions > $other_user->submissions ? 1 : -1;

        return $user->accepted > $other_user->accepted ? -1 : 1;
    }


}

?>
