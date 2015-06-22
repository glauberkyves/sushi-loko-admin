<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 28/01/15
 * Time: 13:48
 */

namespace Base\BaseBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintCPFValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $valid = true;
        $cpf   = str_pad(preg_replace('/[^0-9]/', '', $value), 11, '0', STR_PAD_LEFT);

        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111'
            || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444'
            || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777'
            || $cpf == '88888888888' || $cpf == '99999999999'
        ) {
            $valid = false;
        } else { // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $valid = false;
                }
            }

            $valid = true;
        }

        if (!$valid) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $cpf)
                ->addViolation();
        }
    }
}