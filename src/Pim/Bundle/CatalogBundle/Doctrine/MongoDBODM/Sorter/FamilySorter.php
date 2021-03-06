<?php

namespace Pim\Bundle\CatalogBundle\Doctrine\MongoDBODM\Sorter;

use Pim\Bundle\CatalogBundle\Doctrine\Query\FieldSorterInterface;
use Pim\Bundle\CatalogBundle\Doctrine\MongoDBODM\ProductQueryUtility;
use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;

/**
 * Family sorter
 *
 * @author    Nicolas Dupont <nicolas@akeneo.com>
 * @copyright 2014 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FamilySorter implements FieldSorterInterface
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
        return $field === 'family';
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldSorter($field, $direction, array $context = [])
    {
        if (!isset($context['locale'])) {
            throw new \InvalidArgumentException(
                'Cannot prepare condition on family sorter without locale'
            );
        }

        $fieldLabel = sprintf(
            "%s.%s.label.%s",
            ProductQueryUtility::NORMALIZED_FIELD,
            $field,
            $context['locale']
        );
        $fieldCode = sprintf(
            "%s.%s.code",
            ProductQueryUtility::NORMALIZED_FIELD,
            $field
        );
        $this->qb->sort($fieldLabel, $direction);
        $this->qb->sort($fieldCode, $direction);
        $this->qb->sort('_id');

        return $this;
    }
}
