<?php

.
..
...
 /**
     * getDataById
     * dtb_crudの値をIDで引き当て、返却
     *
     * @param string $order
     * @return array|bool
     */
    public function getDataById($id = null)
    {
        if (is_null($id)) {
            return false;
        }

        try {
            $qb = $this->createQueryBuilder('dc');
            $qb->select('dc')
                ->where('dc.id = :Id')
                ->setParameter('Id', $id);

            return $qb->getQuery()->getSingleResult();
        } catch(\NoResultException $e) {
            return false;
        }
    }
.
..
...
