<?php

namespace ApiV1Bundle\Repository;

use ApiV1Bundle\Model\Ticket\TicketRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * Repository of tickets responsible for data retrieval and persistence.
 */
class TicketRepository extends EntityRepository implements TicketRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Ticket')->from('ApiV1Bundle:Ticket', 'Ticket');

        $query->andWhere('Ticket.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        try {
            return $query->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
