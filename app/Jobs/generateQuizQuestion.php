<?php

namespace App\Jobs;

use App\Hero;
use App\Patch;
use App\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class generateQuizQuestion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

		$statType = array_random(['ms', 'armor', 'armorBase', 'attackRange']);
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
				$quiz->question = 'What is the starting <b>armor</b> of ' . $hero->localized_name . '?';

				$answers[] = (object)[
					'text' => intval($hero->infos->armor + $hero->infos->attributeAgilityBase * (1 / 7)),
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
			case 'armorBase':
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

		shuffle($answers);

		if (count($answers)) {
			$quiz->images = json_encode($images);
			$quiz->answers = json_encode($answers);
			$quiz->save();

//			$this->info('Generated question: ' . $quiz->question);
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

		$statType = array_random(['ms', 'armor', 'attackRange', 'agilityGain', 'strengthGain', 'intelligenceGain']);
		$quiz = new Quiz();
		$quiz->type = $type;
		$quiz->patch_id = $patch->id;

		$images = [];
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
                    'image' => $hero1->image,
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
					'image' => $hero2->image,
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
					'image' => $hero1->image,
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
					'image' => $hero2->image,
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
					'image' => $hero1->image,
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
					'image' => $hero2->image,
				];

				break;
			case 'strengthGain':
				$quiz->question = 'Which hero has a better <b>strength gain</b>?';
				$solution = $hero1->infos->attributeStrengthGain .' vs '. $hero2->infos->attributeStrengthGain;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $hero1->infos->attributeStrengthGain > $hero2->infos->attributeStrengthGain,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $hero1->infos->attributeStrengthGain == $hero2->infos->attributeStrengthGain,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $hero1->infos->attributeStrengthGain < $hero2->infos->attributeStrengthGain,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'agilityGain':
				$quiz->question = 'Which hero has a better <b>agility gain</b>?';
				$solution = $hero1->infos->attributeAgilityGain .' vs '. $hero2->infos->attributeAgilityGain;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $hero1->infos->attributeAgilityGain > $hero2->infos->attributeAgilityGain,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $hero1->infos->attributeAgilityGain == $hero2->infos->attributeAgilityGain,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $hero1->infos->attributeAgilityGain < $hero2->infos->attributeAgilityGain,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'intelligenceGain':
				$quiz->question = 'Which hero has a better <b>intelligence gain</b>?';
				$solution = $hero1->infos->attributeIntelligenceGain .' vs '. $hero2->infos->attributeIntelligenceGain;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $hero1->infos->attributeIntelligenceGain > $hero2->infos->attributeIntelligenceGain,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $hero1->infos->attributeIntelligenceGain == $hero2->infos->attributeIntelligenceGain,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $hero1->infos->attributeIntelligenceGain < $hero2->infos->attributeIntelligenceGain,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
		}

		if (count($answers)) {
			$quiz->images = json_encode($images);
			$quiz->answers = json_encode($answers);
			$quiz->save();

//			$this->info('Generated question: ' . $quiz->question);
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
