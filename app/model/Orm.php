<?php declare(strict_types=1);

namespace App;

use App\Orm\ClassroomRepository;
use App\Orm\StudentRepository;
use Nextras\Orm\Model\Model;

/**
 * @property-read ClassroomRepository $classrooms
 * @property-read StudentRepository   $students
 */
class Orm extends Model
{

}
