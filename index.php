<?php
use Hunter\Hunter;
use Philo\Blade\Blade;

require "vendor/autoload.php";
require "config/database.php";
$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new Blade($views, $cache);
$hunter = new Hunter();
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$cache = 1000; // update only each 1000 seconds

$last_update = Option::find('last_update');
if($last_update->value+$cache < time()) //update is required
{
    foreach(Student::all() as $student)
    {
        $new_accepted = 0;
        $last_submission = $student->last_submission;
        $submissions = $hunter->userSubmissions($student->uva_id, $student->last_submission);
        foreach($submissions as $submission)
        {
            if($submission['verdict'] == \Hunter\Status::ACCEPTED)
            {
                $problem_id = $submission['problem'];
                $last_submission = max($last_submission, $submission['time']);
                if(Solved::where('problem_id', $problem_id)->first() == NULL)
                {
                    $new_accepted++;
                    Solved::create(['problem_id' => $problem_id, 'timestamp' => $submission['time'], 'student_id' => $student->id]);
                }
            }
        }
        $student->accepted = $student->accepted + $new_accepted;
        $student->last_submission = $last_submission;
        $student->save();
    }
    $last_update->value = time();
    $last_update->save();
}

$students = Student::all()->sort('Student::accepted_cmp');
$view = $blade->view()->make('index', ['students' => $students]);

echo $view->render();
?>
