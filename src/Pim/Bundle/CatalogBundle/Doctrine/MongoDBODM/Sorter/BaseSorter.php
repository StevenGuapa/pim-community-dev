<?php

namespace Pim\Bundle\CatalogBundle\Doctrine\MongoDBODM\Sorter;

use Pim\Bundle\CatalogBundle\Model\AttributeInterface;
use Pim\Bundle\CatalogBundle\Doctrine\Query\AttributeSorterInterface;
use Pim\Bundle\CatalogBundle\Doctrine\Query\FieldSorterInterface;
use Pim\Bundle\CatalogBundle\Doctrine\MongoDBODM\ProductQueryUtility;
use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;

/**
 * Base sorter
 *
 * @author    Nicolas Dupont <nicolas@akeneo.com>
 * @copyright 2014 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class BaseSorter implements AttributeSorterInterface, FieldSorterInterface
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
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute(AttributeInterface $attribute)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributeSorter(AttributeInterface $attribute, $direction, array $context = [])
    {
        $sortField = ProductQueryUtility::getNormalizedValueFieldFromAttribute($attribute, $context);
        $this->qb->sort(ProductQueryUtility::NORMALIZED_FIELD.'.'.$sortField, $direction);
        $this->qb->sort('_id');

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldSorter($field, $direction, array $context = [])
    {
        $this->qb->sort(ProductQueryUtility::NORMALIZED_FIELD.'.'.$field, $direction);
        $this->qb->sort('_id');

        return $this;
    }
}
