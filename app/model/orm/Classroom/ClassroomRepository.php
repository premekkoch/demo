<?php declare(strict_types=1);

namespace App\Orm;

use App\Services\Calculator;
use Nette\Utils\ArrayHash;
use Nextras\Orm\Mapper\IMapper;
use Nextras\Orm\Repository\IDependencyProvider;
use Nextras\Orm\Repository\Repository;

class ClassroomRepository extends Repository
{
    /** @var Calculator */
    private $calculator;

    /**
     * @param IMapper                  $mapper
     * @param IDependencyProvider|null $dependencyProvider
     * @param Calculator               $calculator
     */
    public function __construct(IMapper $mapper, IDependencyProvider $dependencyProvider = null, Calculator $calculator)
    {
        parent::__construct($mapper, $dependencyProvider);
        $this->calculator = $calculator;
    }

    /**
     * @return string[]
     */
    public static function getEntityClassNames(): array
    {
        return [Classroom::class];
    }

    /**
     * @return ArrayHash
     */
    public function getGenderRatios(): ArrayHash
    {
        $classrooms = $this->findAll();
        $ratios = [];

        /** @var Classroom $classroom */
        foreach ($classrooms as $classroom) {
            $maleCount = $classroom->students->get()->findBy(['gender' => Student::GENDER_MALE])->countStored();
            $femaleCount = $classroom->students->get()->findBy(['gender' => Student::GENDER_FEMALE])->countStored();

            $ratios[] = [
                'name' => $classroom->name,
                'maleRatio' => $this->calculator->calculateRatio($maleCount, $classroom->students->countStored()),
                'femaleRatio' => $this->calculator->calculateRatio($femaleCount, $classroom->students->countStored()),
            ];
        }

        return ArrayHash::from($ratios);
    }
}
