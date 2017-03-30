<?php

namespace DMH\ECommerceBundle\Controller\Rest;

use DMH\ECommerceBundle\DoctrineListener\ProductRemoveListener;
use DMH\ECommerceBundle\Entity\Product;
use DMH\ECommerceBundle\Form\ProductType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ProductModelController extends Controller implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *
     * )
     * @Rest\Get("/products/{id}/model.babylon", name="get_product_model", options={ "method_prefix" = false })
     */
    public function getModelAction(Product $product)
    {
        $path = $product->getModel3DLink();
        return $this->file($path);
        //https://github.com/whiteoctober/Pagerfanta PAGINATION A PEUT ETRE UTILISER
        //http://stackoverflow.com/questions/26661201/symfony2-image-path-in-controller
        //https://github.com/willdurand/Hateoas#introduction
        //http://symfony.com/doc/current/components/http_foundation.html
    }

}