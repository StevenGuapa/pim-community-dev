<?php

namespace spec\Pim\Bundle\CatalogBundle\Doctrine\MongoDBODM\Filter;

use Doctrine\ODM\MongoDB\Query\Builder;
use PhpSpec\ObjectBehavior;

/**
 * @require Doctrine\ODM\MongoDB\Query\Builder
 */
class GroupsFilterSpec extends ObjectBehavior
{
    function let(Builder $queryBuilder)
    {
        $this->beConstructedWith(['groups'], ['IN', 'NOT IN']);
        $this->setQueryBuilder($queryBuilder);
    }

    function it_is_a_field_filter()
    {
        $this->shouldImplement('Pim\Bundle\CatalogBundle\Doctrine\Query\FieldFilterInterface');
    }

    function it_adds_a_in_filter_on_the_groups_field_in_the_query(Builder $queryBuilder)
    {
        $queryBuilder->field('groupIds')->willReturn($queryBuilder);
        $queryBuilder->in([1, 2])->willReturn($queryBuilder);

        $this->addFieldFilter('groups', 'IN', [1, 2]);
    }
}
