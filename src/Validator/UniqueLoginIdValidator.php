<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UniqueLoginIdValidator extends ConstraintValidator
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$value) {
            return;
        }

        $existing = $this->em->getRepository(User::class)->findOneBy(['loginId' => $value]);
        if ($existing) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
