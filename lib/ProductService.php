<?php
use PrestaShop\PrestaShop\Core\Domain\Product\QueryResult\ProductCard;
use PrestaShop\PrestaShop\Core\Product\ProductRepository;

class ProductService
{
    private $productRepository;

    // Inject the ProductRepository via the constructor
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    // Remove static keyword to allow instance methods and DI
    public function getNewProducts($id_language, $page_number, $nb_products, $order_by, $order_way)
    {
        // Ensure page number and nb_products are valid numbers
        if (!is_int($page_number) || !is_int($nb_products) || $page_number <= 0 || $nb_products <= 0) {
            throw new \InvalidArgumentException('Page number and number of products must be positive integers.');
        }

        // Set default sorting options if not provided
        $order_by = in_array($order_by, ['id_product', 'price', 'date_add']) ? $order_by : 'date_add';
        $order_way = in_array(strtoupper($order_way), ['ASC', 'DESC']) ? strtoupper($order_way) : 'DESC';

        try {
            $queryBuilder = $this->productRepository->createQueryBuilder('p');
            
            // Filter by products added in the last 30 days
            $queryBuilder->where('p.date_add > :recentDate')
                ->setParameter('recentDate', (new \DateTime())->modify('-30 days')->format('Y-m-d H:i:s'));
            
            // Add pagination
            $queryBuilder->setFirstResult(($page_number - 1) * $nb_products)
                ->setMaxResults($nb_products);
            
            // Add sorting
            $queryBuilder->orderBy('p.' . $order_by, $order_way);

            // Fetch and return results
            return $queryBuilder->getQuery()->getResult();
        } catch (\Exception $e) {
            // Handle potential errors (log them, rethrow, etc.)
            throw new \RuntimeException('Error fetching new products: ' . $e->getMessage());
        }
    }
}
