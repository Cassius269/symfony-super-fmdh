<?php
namespace App\Form\DataTransformer;

use App\Entity\TransactionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TransactionTypeToNumberTransformer implements DataTransformerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        
    }
public function transform(mixed $value): mixed
{
    if (null === $value) {
        return '';
    }

    if (!$value instanceof TransactionType) {
        throw new \UnexpectedValueException('Expected a TransactionType.');
    }

    return (string) $value->getId();
}

public function reverseTransform(mixed $value): mixed
{
    if (!$value) {
        return null;
    }

    $transactionType = $this->entityManager
        ->getRepository(TransactionType::class)
        ->find($value);

    if (null === $transactionType) {
        throw new TransformationFailedException(sprintf('Un type de transaction avec l\'Id %s n\'existe pas', $value));
    }

    return $transactionType;
}


}