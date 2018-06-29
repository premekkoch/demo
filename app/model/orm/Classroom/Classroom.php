<?php declare(strict_types=1);

namespace App\Orm;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * @property int                  $id       {primary}
 * @property string               $name
 * @property OneHasMany|Student[] $students {1:m Student::$classroom}
 */
class Classroom extends Entity
{

}
