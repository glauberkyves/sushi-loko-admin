<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 28/01/15
 * Time: 13:48
 */

namespace Base\BaseBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstraintCPF extends Constraint
{
    public $message = 'O cpf: "%string%" está incorreto.';
}