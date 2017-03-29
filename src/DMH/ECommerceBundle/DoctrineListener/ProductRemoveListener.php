<?php
namespace DMH\ECommerceBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use DMH\ECommerceBundle\Entity\Product;
use DMH\ECommerceBundle\Entity\Media;

class ProductRemoveListener
{

    private $id;

    public function __construct()
    {
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $isInstanceOfProduct = $entity instanceof Product;
        if ( $isInstanceOfProduct != true) {
            return;
        }
        /* @var Product $entity */
        $this->id = $entity->getId();

    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $isInstanceOfProduct = $entity instanceof Product;
        if ( $isInstanceOfProduct != true) {
            return;
        }
        /* @var Product $entity */
        $entity->setProductDir();

        $productDir = $entity->getProductDir().$this->id;

        $this->removeProductDir($productDir);

    }

    public function removeProductDir($productDir)
    {
        $dir = __DIR__.'/../../../../web/'.$productDir;
        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($it,
            \RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
}