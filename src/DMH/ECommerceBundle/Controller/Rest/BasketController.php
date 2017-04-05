<?php
/**
 * Created by PhpStorm.
 * User: kyotsunee
 * Date: 23/03/2017
 * Time: 01:58
 */

namespace DMH\ECommerceBundle\Controller\Rest;

use DMH\ECommerceBundle\Entity\Basket;
use DMH\ECommerceBundle\Entity\BasketCreation;
use DMH\ECommerceBundle\Form\BasketType;
use DMH\UserBundle\Entity\User;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DMH\ECommerceBundle\Entity\Category;
use DMH\ECommerceBundle\Form\CategoryType;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BasketController extends Controller implements ClassResourceInterface
{

    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all Category",
     *  tags={
     *     "stable"
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized",
     *      404={
     *        "Returned when the categories is not found",
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
        $categories = $em
            ->getRepository('DMHECommerceBundle:Category')
            ->findBy(
                array(),
                array(),
                $limit,
                $offset
            );
        ;
        return array('categories' => $categories);
    }

    /**
     * @ApiDoc(
     *
     * )
     * @rest\Get("users/{id}/basket")
     */
    public function getAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $basket = $em
            ->getRepository('DMHECommerceBundle:Basket')
            ->findOneByUser($user);
        ;
        if (empty($basket)) {
            return View::create(['error' => 'Basket not found'], Response::HTTP_NOT_FOUND);
        }
        return array('basket' => $basket);
    }

    /**
     * @ApiDoc(
     *    description="Create a category",
     *    input={"class"=CategoryType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Created successfully",
     *        400 = "Invalid Form"
     *    },
     *    responseMap={
     *         201 = {"class"=Category::class, "groups"={""}},
     *         400 = { "class"=CategoryType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={""})
     * @Rest\Post("/baskets")
     */
    public function postAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $data = $request->request->all();

        $submitted = array();
        foreach($data as $key => $item) {
            if($key != "_format"){
                $submitted[$key] = $item;
            }
        }

        $form->submit($submitted);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return array('category' => $category);

        }else{
            //essayer ça pour voir si ça retourne un meilleur format qu'avec le form_serializer maison
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *
     * )
     */
    public function putAction(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $data = $request->request->all();

        $submitted = array();

        foreach($data as $key => $item) {
            if($key != "_format"){
                $submitted[$key] = $item;
            }
        }

        $form->submit($submitted);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return array('category' => $category);

        }else{
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *    input={"class"=BasketType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Created successfully",
     *        400 = "Invalid Form"
     *    },
     *    responseMap={
     *         201 = {"class"=Basket::class, "groups"={""}},
     *         400 = { "class"=BasketType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     * @Rest\Patch("/users/{id}/basket")
     *
     * //@Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function patchAction(Request $request, User $user)
    {

        $em = $this->getDoctrine()->getManager();
        $basketRep = $em->getRepository("DMHECommerceBundle:Basket");
        $basket = $basketRep->findOneByUser($user);

        if(empty($basket)) {
            $basket = new Basket();
            $basket->setUser();
            $em->persist($basket);
            $em->flush();
        }

        $form = $this->createForm(BasketType::class, $basket);

        $data = $request->request->all();

        $submitted = array();

        foreach($data as $key => $item) {
            if($key != "_format"){
                $submitted[$key] = $item;
            }
        }

        $form->submit($submitted, false);

        if ($form->isValid()) {

            foreach ($basket->getItems() as $item) {
                /* @var BasketCreation $item */
                $item->setBasket($basket);
                $em->persist($item);
            }

            $em->flush();
            return array('basket' => $basket);

        }else{
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *
     * )
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/users/{id}/basket/items/{item}")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function removeItemAction(Request $request, User $user, BasketCreation $item)
    {
        /* @var $item BasketCreation */
        $em = $this->get('doctrine.orm.entity_manager');
        if ($item) {
            $em->remove($item);
            $em->flush();
        }
    }


}