<?php

namespace DMH\ECommerceBundle\Controller\Rest;

use DMH\ECommerceBundle\DoctrineListener\ProductRemoveListener;
use DMH\ECommerceBundle\Entity\Product;
use DMH\ECommerceBundle\Form\ProductType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
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

class ProductThumbnailController extends Controller implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *
     * )
     * @Rest\Get("/products/{id}/thumbnail", name="get_product_thumbnail", options={ "method_prefix" = false })
     */
    public function getThumbnailAction(Request $request, Product $product)
    {
//        return "test";
        /* @var CacheManager $imagineCacheManager */
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        /* @var \Liip\ImagineBundle\Controller\ImagineController $imagineManager */
        $imagineManager = $this->get('liip_imagine.controller');
        $path = $product->getThumbnailLink();


        $resolvedPath = $imagineCacheManager->getBrowserPath($path, 'thumb');

        return $this->redirect($resolvedPath);

//        $resolvedImage = $imagineManager->filterAction($request, $path, 'thumb');
        //Retourne l'URL absolue
//        $imagePath = $resolvedImage->headers->get('location');
        /**
         * @var DataManager $processedImage
         * @var FilterManager
         */
//        $processedImage = $this->get('liip_imagine.data.manager')->find('thumb', $path);
//        $newimage_string = $this->get('liip_imagine.filter.manager')->applyFilter($processedImage, 'thumb')->getContent();
    }

}