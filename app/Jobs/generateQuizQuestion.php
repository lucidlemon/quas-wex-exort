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
     * getRandomWeightedElement()
     * Utility function for getting random values with weighting.
     * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
     * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
     * The return value is the array key, A, B, or C in this case.  Note that the values assigned
     * do not have to be percentages.  The values are simply relative to each other.  If one value
     * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
     * chance of being selected.  Also note that weights should be integers.
     *
     * @param array $weightedValues
     * @return int|string
     */
    public function getRandomWeightedElement(array $weightedValues) {
        $rand = mt_rand(1, (int) array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
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

		$statType = $this->getRandomWeightedElement([
		    'ms' => 60,
            'armor' => 40,
//            'armorBase',
            'attackRange' => 5
        ]);
		$quiz = new Quiz();
        $quiz->type = $type . ':' . $statType;
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

				$correct = intval($hero->infos->armor + $hero->infos->attributeAgilityBase * (1 / 7));

				$answers[] = (object)[
					'text' => $correct,
					'correct' => true,
				];

				$results = [$correct];

				for ($i = 1; $i <= 3; $i++) {
					$random = $this->createRandomResult(-2, 10, 1, $results);
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
					$random = $this->createRandomResult(-2, 10, 1, $results);
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

		$statType = $this->getRandomWeightedElement([
		    'ms' => 40,
            'armor' => 30,
            'attackRange' => 5,
            'agilityGain' => 10,
            'strengthGain' => 10,
            'intelligenceGain' => 10,
            'strengthAtX' => 20,
            'agilityAtX' => 20,
            'intelligenceAtX' => 20
        ]);
		$quiz = new Quiz();
		$quiz->type = $type . ':' . $statType;
		$quiz->patch_id = $patch->id;

		$images = [];
		$answers = [];

//        \Log::info('---');
//		\Log::info('Hero1 ' . $hero1->localized_name);
//        \Log::info('Hero2 ' . $hero2->localized_name);

//        \Log::info('Hero1 info ' . gettype($hero1->infos));
//        \Log::info('Hero2 info ' . gettype($hero2->infos));

		switch ($statType) {
			case 'ms':
				$quiz->question = 'Which hero has a faster <b>movement speed</b>?';

                $resHero1 = $hero1->infos->ms;
                $resHero2 = $hero2->infos->ms;

				$solution = $hero1->localized_name . ': ' . $resHero1 .' vs '. $hero2->localized_name . ': ' . $resHero2;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $resHero1 > $resHero2,
					'solution' => $solution,
                    'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $resHero1 == $resHero2,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $resHero1 < $resHero2,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'armor':
				$quiz->question = 'Which hero has more <b>armor at level 1</b>?';

                $resHero1 = intval($hero1->infos->armor + $hero1->infos->attributeAgilityBase * (1 / 7));
                $resHero2 = intval($hero2->infos->armor + $hero2->infos->attributeAgilityBase * (1 / 7));

                $solution = $hero1->localized_name . ': ' . $resHero1 .' vs '. $hero2->localized_name . ': ' . $resHero2;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $resHero1 > $resHero2,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $resHero1 == $resHero2,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $resHero1 < $resHero2,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'attackRange':
				$quiz->question = 'Which hero has a bigger <b>attack range</b>?';

                $resHero1 = $hero1->infos->attackRange;
                $resHero2 = $hero2->infos->attackRange;

                $solution = $hero1->localized_name . ': ' . $resHero1 .' vs '. $hero2->localized_name . ': ' . $resHero2;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $resHero1 > $resHero2,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $resHero1 == $resHero2,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $resHero1 < $resHero2,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'strengthGain':
				$quiz->question = 'Which hero has a better <b>strength gain</b>?';

                $resHero1 = $hero1->infos->attributeStrengthGain;
                $resHero2 = $hero2->infos->attributeStrengthGain;

                $solution = $hero1->localized_name . ': ' . $resHero1 .' vs '. $hero2->localized_name . ': ' . $resHero2;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $resHero1 > $resHero2,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $resHero1 == $resHero2,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $resHero1 < $resHero2,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'agilityGain':
				$quiz->question = 'Which hero has a better <b>agility gain</b>?';

                $resHero1 = $hero1->infos->attributeAgilityGain;
                $resHero2 = $hero2->infos->attributeAgilityGain;

                $solution = $hero1->localized_name . ': ' . $resHero1 .' vs '. $hero2->localized_name . ': ' . $resHero2;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $resHero1 > $resHero2,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $resHero1 == $resHero2,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $resHero1 < $resHero2,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'intelligenceGain':
				$quiz->question = 'Which hero has a better <b>intelligence gain</b>?';

                $resHero1 = $hero1->infos->attributeIntelligenceGain;
                $resHero2 = $hero2->infos->attributeIntelligenceGain;

                $solution = $hero1->localized_name . ': ' . $resHero1 .' vs '. $hero2->localized_name . ': ' . $resHero2;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $resHero1 > $resHero2,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $resHero1 == $resHero2,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $resHero1 < $resHero2,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'strengthAtX':
			    $level = random_int(1, 25);
				$quiz->question = 'Which hero has more <b>strength at level '.$level.'</b>?';

				$resHero1 = $hero1->infos->attributeStrengthGain * $level + $hero1->infos->attributeStrengthBase;
				$resHero2 = $hero2->infos->attributeStrengthGain * $level + $hero2->infos->attributeStrengthBase;

                $solution = $hero1->localized_name . ': ' . $resHero1 .' vs '. $hero2->localized_name . ': ' . $resHero2;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $resHero1 > $resHero2,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $resHero1 == $resHero2,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $resHero1 < $resHero2,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'agilityAtX':
				$level = random_int(1, 25);
				$quiz->question = 'Which hero has more <b>agility at level '.$level.'</b>?';

				$resHero1 = $hero1->infos->attributeAgilityGain * $level + $hero1->infos->attributeAgilityBase;
				$resHero2 = $hero2->infos->attributeAgilityGain * $level + $hero2->infos->attributeAgilityBase;

                $solution = $hero1->localized_name . ': ' . $resHero1 .' vs '. $hero2->localized_name . ': ' . $resHero2;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $resHero1 > $resHero2,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $resHero1 == $resHero2,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $resHero1 < $resHero2,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
			case 'intelligenceAtX':
				$level = random_int(1, 25);
				$quiz->question = 'Which hero has more <b>intelligence at level '.$level.'</b>?';

				$resHero1 = $hero1->infos->attributeIntelligenceGain * $level + $hero1->infos->attributeIntelligenceBase;
				$resHero2 = $hero2->infos->attributeIntelligenceGain * $level + $hero2->infos->attributeIntelligenceBase;

                $solution = $hero1->localized_name . ': ' . $resHero1 .' vs '. $hero2->localized_name . ': ' . $resHero2;

				// generate true answer
				$answers[] = (object)[
					'text' => $hero1->localized_name,
					'correct' => $resHero1 > $resHero2,
					'solution' => $solution,
					'image' => $hero1->image,
				];

				$answers[] = (object)[
					'text' => 'both are the same',
					'correct' => $resHero1 == $resHero2,
					'solution' => $solution,
				];

				$answers[] = (object)[
					'text' => $hero2->localized_name,
					'correct' => $resHero1 < $resHero2,
					'solution' => $solution,
					'image' => $hero2->image,
				];

				break;
		}

		if (count($answers)) {
			$quiz->images = json_encode($images);
			$quiz->answers = json_encode($answers);
			$quiz->save();
		}
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$type = $this->getRandomWeightedElement([
		    'hero:compare' => 80,
            'hero:stat' => 30
        ]);

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
