<?php declare(strict_types=1);

namespace App\Orm;

use Nextras\Orm\Entity\Entity;

/**
 * @property int       $id        {primary}
 * @property string    $name
 * @property int       $gender    {enum self::GENDER_*}
 * @property Classroom $classroom {m:1 Classroom::$students}
 */
class Student extends Entity
{
    public const GENDER_MALE = 1;

    public const GENDER_FEMALE = 2;
}
