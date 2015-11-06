<?php

namespace ApiV1Bundle\Service\Resource;

use Doctrine\Common\Persistence\ObjectManager;

class TicketResource implements ResourceInterface
{
    private $om;
    private $entityClass;
    private $repository;

    public function __construct(ObjectManager $om, $entityClass)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }
}
