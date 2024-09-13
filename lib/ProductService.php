<?php
//use PrestaShop\PrestaShop\Core\Domain\Product\QueryResult\ProductCard;
//use PrestaShop\PrestaShop\Core\Product\ProductRepository;
use PrestaShop\PrestaShop\Core\Domain\Product\Query\GetNewProductsQuery;
use PrestaShop\PrestaShop\Core\QueryBus\QueryBusInterface;

class ProductService
{
    private $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function getNewProducts($page_number, $nb_products, $order_by, $order_way)
    {
        // Prepare the query for new products
        $query = new GetNewProductsQuery($page_number, $nb_products, $order_by, $order_way);

        // Use the query bus to handle the query and fetch the results
        $newProducts = $this->queryBus->handle($query);

        return $newProducts;
    }
}
