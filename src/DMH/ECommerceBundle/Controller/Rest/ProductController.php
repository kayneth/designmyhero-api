<?php

namespace DMH\ECommerceBundle\Controller\Rest;

use DMH\ECommerceBundle\Entity\Product;
use DMH\ECommerceBundle\Form\ProductType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class ProductController extends Controller implements ClassResourceInterface
{

    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all Product",
     *  tags={
     *     "stable"
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized",
     *      404={
     *        "Returned when the products is not found",
     *        "Returned when something else is not found"
     *      }
     *  }
     * )
     * @QueryParam(name="offset", requirements="\d+", default="", description="Index de début de la pagination")
     * @QueryParam(name="limit", requirements="\d+", default="", description="Nombre d'éléments à afficher")
     */
    public function cgetAction(Request $request, ParamFetcher $paramFetcher)
    {
        $offset = $paramFetcher->get('offset') ?: null;
        $limit = $paramFetcher->get('limit') ?: null;

        $em = $this->getDoctrine()->getManager();
        $products = $em
            ->getRepository('DMHECommerceBundle:Product')
            ->findBy(
                array(),
                array(),
                $limit,
                $offset
            );
        ;
        return array('products' => $products);
    }

    public function getAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em
            ->getRepository('DMHECommerceBundle:Product')
            ->findOneById($slug);
        ;
        if (empty($product)) {
            return View::create(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        return array('product' => $product);
    }

    /**
     * @ApiDoc(
     *    description="Create a product",
     *    input={"class"=ProductType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Created successfully",
     *        400 = "Invalid Form"
     *    },
     *    responseMap={
     *         201 = {"class"=Product::class, "groups"={""}},
     *         400 = { "class"=ProductType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={""})
     * @Rest\Post("/products")
     */
    public function postAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $data = $request->request->all();

        $submitted = array();
        foreach($data as $key => $item) {
            if($key != "_format"){
                $submitted[$key] = $item;
            }
        }

        $thumbnailFile = $request->files->get('thumbnail');
        $patternFile = $request->files->get('pattern');
        $submitted['thumbnail']['file'] = $thumbnailFile;
        $submitted['pattern']['file'] = $patternFile;
        //Gérer 3 cas : Upload de fichier unique, de fichiers multiples, de zip
        //Choisir sur le formulaire et adapter la méthode d'upload selon le cas

        $form->submit($submitted);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return array('product' => $product);

        }else{
            //essayer ça pour voir si ça retourne un meilleur format qu'avec le form_serializer maison
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *     headers={
     *         {
     *             "name"="X-AUTHORIZE-KEY",
     *             "description"="Authorization key"
     *         }
     *     }
     * )
     */
    public function putAction(Request $request, Product $product)
    {
        $form = $this->createForm(ProductType::class, $product);

        $data = $request->request->all();

        $submitted = array();

        foreach($data as $key => $item) {
            if($key != "_format"){
                $submitted[$key] = $item;
            }
        }

        $file = $request->files->get('image');
        $submitted['image']['file'] = $file;

        $form->submit($submitted);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return array('product' => $product);

        }else{
           return $form;
        }
    }

    public function patchAction(Request $request, Product $product)
    {
        $form = $this->createForm(ProductType::class, $product);
        $data = $request->request->all();

        $submitted = array();

        foreach($data as $key => $item) {
            if($key != "_format"){
                $submitted[$key] = $item;
            }
        }

        $file = $request->files->get('image');
        $submitted['image']['file'] = $file;

        $form->submit($submitted);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return array('product' => $product);

        }else{
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *
     * )
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/products/{id}")
     */
    public function removeAction(Request $request, Product $product)
    {
        /* @var $product Product */
        $em = $this->get('doctrine.orm.entity_manager');
        if ($product) {
            $em->remove($product);
            $em->flush();
        }
    }

    private function addFilesToForm($files, $data)
    {
        $file = $request->files->get('image');
        $file = $request->files->get('pattern');
        $file = $request->files->get('model3D');
        $data['image']['file'] = $file;
        $data['pattern']['file'] = $file;
        $data['model3D']['file'] = $file;
    }

}