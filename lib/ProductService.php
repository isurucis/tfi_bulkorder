<?php
use PrestaShop\PrestaShop\Core\Domain\Product\QueryResult\ProductCard;
use PrestaShop\PrestaShop\Core\Product\ProductRepository;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getNewProducts($id_language, $page_number, $nb_products, $order_by, $order_way)
    {
        $queryBuilder = $this->productRepository->createQueryBuilder('p');
        
        // Filter by new products (within a certain date range)
        $queryBuilder->where('p.date_add > :recentDate')
            ->setParameter('recentDate', (new \DateTime())->modify('-30 days')->format('Y-m-d H:i:s'));
        
        // Add pagination
        $queryBuilder->setFirstResult(($page_number - 1) * $nb_products)
            ->setMaxResults($nb_products);
        
        // Add sorting
        $queryBuilder->orderBy('p.' . $order_by, $order_way);

        // Fetch results
        $products = $queryBuilder->getQuery()->getResult();

        return $products;
    }
}
