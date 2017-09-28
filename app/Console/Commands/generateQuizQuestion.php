<?php

namespace App\Console\Commands;

use App\Hero;
use App\Patch;
use App\Quiz;
use Illuminate\Console\Command;

class generateQuizQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new random question';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function createRandomResult($min, $max, $iteration, $previousResults)
    {
        $number = $min + random_int(0, intval(($max - $min) / $iteration)) * $iteration;

        // check if the resulted speed is already in the array
        while (in_array($number, $previousResults)){
            $number = $min + random_int(0, intval(($max - $min) / $iteration)) * $iteration;
        }

        return $number;
    }

    /**
     * Creates a question where you have to guess the value of a certain stat
     *
     * @param $type
     */
    public function createHeroStatQuestion($type)
    {
        $hero = Hero::inRandomOrder()->first();
        $patch = Patch::orderByDesc('started_at')->first();

        $statType = array_random(['ms', 'armor', 'attackRange']);
        $quiz = new Quiz();
        $quiz->type = $type;
        $quiz->patch_id = $patch->id;

        $images = [$hero->image];
        $answers = [];

        switch ($statType) {
            case 'ms':
                $quiz->question = 'What is the base <b>movement speed</b> of ' . $hero->localized_name . '?';

                // generate true answer
                $answers[] = (object)[
                    'text' => $hero->infos->ms,
                    'correct' => true,
                ];

                // put result into an array where we can check for doubles
                $results = [$hero->infos->ms];

                // generate 3 additional answers
                for ($i = 1; $i <= 3; $i++) {
                    // create a random speed
                    $randomSpeed = $this->createRandomResult(270, 370, 5, $results);
                    // add this new speed to the array
                    $results[] = $randomSpeed;
                    // finally place the wrong answer into the array
                    $answers[] = (object)[
                        'text' => $randomSpeed,
                        'correct' => false,
                    ];
                }

                break;
            case 'armor':
                $quiz->question = 'What is the base <b>armor</b> of ' . $hero->localized_name . '?';

                $answers[] = (object)[
                    'text' => $hero->infos->armor,
                    'correct' => true,
                ];

                $results = [$hero->infos->armor];

                for ($i = 1; $i <= 3; $i++) {
                    $random = $this->createRandomResult(-10, 10, 1, $results);
                    $results[] = $random;
                    $answers[] = (object)[
                        'text' => $random,
                        'correct' => false,
                    ];
                }

                break;
            case 'attackRange':
                $quiz->question = 'What is the base <b>attack range</b> of ' . $hero->localized_name . '?';

                $answers[] = (object)[
                    'text' => $hero->infos->attackRange,
                    'correct' => true,
                ];

                $results = [$hero->infos->attackRange];

                for ($i = 1; $i <= 3; $i++) {
                    $random = $this->createRandomResult(120, 800, 10, $results);
                    $results[] = $random;
                    $answers[] = (object)[
                        'text' => $random,
                        'correct' => false,
                    ];
                }

                break;
        }

        if (count($answers)) {
            $quiz->images = json_encode($images);
            $quiz->answers = json_encode($answers);
            $quiz->save();

            $this->info('Generated question: ' . $quiz->question);
        }
    }

    /**
     * Creates a question where you have to tell which hero is better at something
     *
     * @param $type
     */
    public function createHeroCompareQuestion($type)
    {
        $hero1 = Hero::inRandomOrder()->first();
        $hero2 = Hero::inRandomOrder()->where('name', '<>', $hero1->name)->first();
        $patch = Patch::orderByDesc('started_at')->first();

        $statType = array_random(['ms', 'armor', 'attackRange']);
        $quiz = new Quiz();
        $quiz->type = $type;
        $quiz->patch_id = $patch->id;

        $images = [$hero1->image, $hero2->image];
        $answers = [];

        switch ($statType) {
            case 'ms':
                $quiz->question = 'Which hero has a faster <b>movement speed</b>?';
                $solution = $hero1->infos->ms .' vs '. $hero2->infos->ms;

                // generate true answer
                $answers[] = (object)[
                    'text' => $hero1->localized_name,
                    'correct' => $hero1->infos->ms > $hero2->infos->ms,
                    'solution' => $solution,
                ];

                $answers[] = (object)[
                    'text' => 'both are the same',
                    'correct' => $hero1->infos->ms == $hero2->infos->ms,
                    'solution' => $solution,
                ];

                $answers[] = (object)[
                    'text' => $hero2->localized_name,
                    'correct' => $hero1->infos->ms < $hero2->infos->ms,
                    'solution' => $solution,
                ];

                break;
            case 'armor':
                $quiz->question = 'Which hero has more <b>base armor</b>?';
                $solution = $hero1->infos->armor .' vs '. $hero2->infos->armor;

                // generate true answer
                $answers[] = (object)[
                    'text' => $hero1->localized_name,
                    'correct' => $hero1->infos->armor > $hero2->infos->armor,
                    'solution' => $solution,
                ];

                $answers[] = (object)[
                    'text' => 'both are the same',
                    'correct' => $hero1->infos->armor == $hero2->infos->armor,
                    'solution' => $solution,
                ];

                $answers[] = (object)[
                    'text' => $hero2->localized_name,
                    'correct' => $hero1->infos->armor < $hero2->infos->armor,
                    'solution' => $solution,
                ];

                break;
            case 'attackRange':
                $quiz->question = 'Which hero has a bigger <b>attack range</b>?';
                $solution = $hero1->infos->attackRange .' vs '. $hero2->infos->attackRange;

                // generate true answer
                $answers[] = (object)[
                    'text' => $hero1->localized_name,
                    'correct' => $hero1->infos->attackRange > $hero2->infos->attackRange,
                    'solution' => $solution,
                ];

                $answers[] = (object)[
                    'text' => 'both are the same',
                    'correct' => $hero1->infos->attackRange == $hero2->infos->attackRange,
                    'solution' => $solution,
                ];

                $answers[] = (object)[
                    'text' => $hero2->localized_name,
                    'correct' => $hero1->infos->attackRange < $hero2->infos->attackRange,
                    'solution' => $solution,
                ];

                break;
        }

        if (count($answers)) {
            $quiz->images = json_encode($images);
            $quiz->answers = json_encode($answers);
            $quiz->save();

            $this->info('Generated question: ' . $quiz->question);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = array_random(['hero:compare', 'hero:stat']);

        switch ($type) {
            case 'hero:compare':
                $this->createHeroCompareQuestion($type);
                break;
            case 'hero:stat':
                $this->createHeroStatQuestion($type);
                break;
        }
    }
}
