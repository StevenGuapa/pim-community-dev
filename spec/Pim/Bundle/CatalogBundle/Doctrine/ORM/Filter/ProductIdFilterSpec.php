<?php

namespace spec\Pim\Bundle\CatalogBundle\Doctrine\ORM\Filter;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Pim\Bundle\CatalogBundle\Model\AttributeInterface;

class ProductIdFilterSpec extends ObjectBehavior
{
    function let(QueryBuilder $queryBuilder)
    {
        $this->beConstructedWith(['id'], ['=']);
        $this->setQueryBuilder($queryBuilder);
    }

    function it_is_a_filter()
    {
        $this->shouldImplement('Pim\Bundle\CatalogBundle\Doctrine\Query\FieldFilterInterface');
    }

    function it_supports_operators()
    {
        $this->getOperators()->shouldReturn(['=']);
        $this->supportsOperator('=')->shouldReturn(true);
        $this->supportsOperator('FAKE')->shouldReturn(false);
    }

    function it_adds_binary_filter_in_the_query(QueryBuilder $queryBuilder)
    {
        $queryBuilder->expr()->willReturn(new Expr());
        $queryBuilder->getRootAliases()->willReturn(['p']);
        $queryBuilder->andWhere('p.id = \'12\'')->shouldBeCalled();

        $this->addFieldFilter('id', '=', '12');
    }
}
