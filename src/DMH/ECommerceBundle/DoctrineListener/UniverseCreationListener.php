<?php
namespace DMH\ECommerceBundle\DoctrineListener;

use DMH\ECommerceBundle\Entity\Universe;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use DMH\ECommerceBundle\Entity\Product;
use DMH\ECommerceBundle\Entity\Media;

class UniverseCreationListener
{
    public function __construct()
    {
    }
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $isInstanceOfUniverse= $entity instanceof Universe;
        if ( $isInstanceOfUniverse != true) {
            return;
        }
        /* @var Universe $entity */
        $entity->setThumbnailDir();
        $entity->getThumbnail()->upload();
    }
}