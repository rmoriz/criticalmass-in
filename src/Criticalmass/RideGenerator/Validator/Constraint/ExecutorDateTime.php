<?php declare(strict_types=1);

namespace App\Criticalmass\RideGenerator\Validator\Constraint;

use App\Criticalmass\RideGenerator\Validator\ExecutorDateTimeValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ExecutorDateTime extends Constraint
{
    public $message = 'Das Startdatum muss vor dem Enddatum liegen';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return ExecutorDateTimeValidator::class;
    }
}
