<?php

namespace ApiV1Bundle\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Custom exception used to indicate invalid resource.
 */
class InvalidResourceException extends RuntimeException
{
    /** @var ConstraintViolationListInterface */
    protected $violationList;

    /**
     * Constructor used to inject violation list.
     *
     * @param ConstraintViolationListInterface $violationList
     */
    public function __construct($violationList)
    {
        parent::__construct();
        $this->violationList = $violationList;
    }

    /**
     * Getter for violation list.
     *
     * @return ConstraintViolationListInterface
     */
    public function getViolationList()
    {
        return $this->violationList;
    }
}
