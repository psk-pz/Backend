<?php

namespace ApiV1Bundle\Repository;

use ApiV1Bundle\Model\Ticket\TicketInterface;
use ApiV1Bundle\Model\Ticket\TicketRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * Repository of entities responsible for data retrieval and persistence.
 */
class TicketRepository extends EntityRepository implements TicketRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return $this->getClassMetadata()->newInstance();
    }

    /**
     * {@inheritdoc}
     */
    public function save(TicketInterface $entity, $autoCommit = true)
    {
        $this->getEntityManager()->persist($entity);
        if ($autoCommit) {
            $this->getEntityManager()->flush($entity);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(TicketInterface $entity, $autoCommit = false)
    {
        $this->getEntityManager()->remove($entity);
        if ($autoCommit) {
            $this->getEntityManager()->flush($entity);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function commitTransaction()
    {
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $queryBuilder = $this->createQueryBuilder('Ticket');

        $queryBuilder->andWhere('Ticket.id = :id')->setParameter('id', $id);
        $queryBuilder->setMaxResults(1);

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
