<?php
use Hunter\Hunter;
use Philo\Blade\Blade;
require "vendor/autoload.php";

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new Blade($views, $cache);

function should_update()
{
    $last_update = Option::find('last_update');
    return $last_update->value + getenv('SCORE_CACHE') < time(); //update is required
}

function update_score()
{
    $hunter = new Hunter();
    foreach(Student::all() as $student)
    {
        $new_accepted = 0;
        $submissions = $hunter->userSubmissions($student->uva_id, $student->last_submission);
        foreach($submissions as $submission)
        {
            if($submission['verdict'] == \Hunter\Status::ACCEPTED)
            {
                $problem_id = $submission['problem'];
                $student->last_submission = max($student->last_submission, $submission['id']);

                $solved = Solved::where('problem_id', $problem_id)
                                ->where('student_id', $student->id)->first();

                if(is_null($solved))
                {
                    $new_accepted++;
                    Solved::create(['problem_id' => $problem_id, 'timestamp' => $submission['time'], 'student_id' => $student->id]);
                }
            }
        }
        $student->accepted = $student->accepted + $new_accepted;
        $student->save();
    }
    $last_update = Option::find('last_update');
    $last_update->value = time();
    $last_update->save();
}

if(should_update()) update_score();

$students = Student::all()->sort('Student::accepted_cmp');
$view = $blade->view()->make('index', ['students' => $students]);

echo $view->render();
?>
