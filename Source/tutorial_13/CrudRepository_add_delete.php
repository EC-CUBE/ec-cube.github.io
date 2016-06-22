<?php
.
..
...
 /**
     * deleteById
     * dtb_crudの値をIDで引き当て、削除
     *
     * @param null $id
     * @return bool|mixed
     */
    public function deleteDataById($id = null)
    {
        if (is_null($id)) {
            return false;
        }

        $qb = $this->createQueryBuilder('dc');
        $qb->delete()
            ->where('dc.id = :Id')
            ->setParameter('Id', $id);

        return $qb->getQuery()->execute();
    }
.
..
...
