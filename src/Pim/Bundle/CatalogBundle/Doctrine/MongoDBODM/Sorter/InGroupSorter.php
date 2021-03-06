<?php

namespace Pim\Bundle\CatalogBundle\Doctrine\MongoDBODM\Sorter;

use Pim\Bundle\CatalogBundle\Doctrine\Query\FieldSorterInterface;
use Pim\Bundle\CatalogBundle\Doctrine\MongoDBODM\ProductQueryUtility;
use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;

/**
 * In group sorter
 *
 * @author    Nicolas Dupont <nicolas@akeneo.com>
 * @copyright 2014 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class InGroupSorter implements FieldSorterInterface
{
    /** @var QueryBuilder */
    protected $qb;

    /**
     * {@inheritdoc}
     */
    public function setQueryBuilder($queryBuilder)
    {
        $this->qb = $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsField($field)
    {
        return strpos($field, 'in_group_') !== false;
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldSorter($field, $direction, array $context = [])
    {
        $field = sprintf("%s.%s", ProductQueryUtility::NORMALIZED_FIELD, $field);
        $this->qb->sort($field, $direction);
        $this->qb->sort('_id');

        return $this;
    }
}
