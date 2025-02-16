<?php declare(strict_types=1);

namespace Mavimedia\Storefront\Controller;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Framework\Routing\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class WiperFinderProductController extends StorefrontController
{
    private EntityRepository $productRepository;

    public function __construct(EntityRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    #[Route(
        path: '/redirect-product/{uuid}',
        name: 'frontend.alca.wiper.finder',
        methods: ['GET']
    )]

    public function showProduct($uuid, Context $context): Response
    {
        $criteria = new Criteria();

        $criteria->addFilter(
            new EqualsFilter(
                'productNumber', $uuid
            )
        );
        $productId = key($this->productRepository->search($criteria,$context)->getIds());

        return $this->redirectToRoute('frontend.detail.page',['productId' => $productId]);
}}
