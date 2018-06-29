<?php declare(strict_types=1);

namespace App\Orm;

use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Repository\Repository;

class StudentRepository extends Repository
{
    /**
     * @return string[]
     */
    public static function getEntityClassNames(): array
    {
        return [Student::class];
    }

    /**
     * @param int $gender
     * @return ICollection|Student[]
     */
    public function findByGender(int $gender): ICollection
    {
        return $this->findBy(['gender' => $gender]);
    }
}
