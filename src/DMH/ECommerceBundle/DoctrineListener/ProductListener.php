<?php
namespace DMH\ECommerceBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use DMH\ECommerceBundle\Entity\Product;
use DMH\ECommerceBundle\Entity\Media;

class ProductListener
{
    public function __construct()
    {
    }
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $isInstanceOfProduct = $entity instanceof Product;
        $isInstanceOfMedia = $entity instanceof Media;
        if ( $isInstanceOfProduct != true) {
            return;
        }
        /* @var Product $entity */
        $entity->setThumbnailDir();
        $entity->getThumbnail()->upload();
        $entity->setPatternDir();
        $entity->getPattern()->upload();
        $entity->setModel3DDir();
        $entity->getModel3D()->upload();
//        switch ($entity->getModel()){
//            case "multiple":
//                break;
//            case "unique":
//                break;
//            case "zip":
//                break;
//            default:
//
//
//        }
    }
}