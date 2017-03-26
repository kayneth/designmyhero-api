<?php
/**
 * Created by PhpStorm.
 * User: kyotsunee
 * Date: 23/03/2017
 * Time: 01:58
 */

namespace DMH\ECommerceBundle\Controller\Rest;


use DMH\ECommerceBundle\Entity\Universe;
use DMH\ECommerceBundle\Form\CategoryType;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations as Rest;

class UniverseController extends Controller implements ClassResourceInterface
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
        $universes = $em
            ->getRepository('DMHECommerceBundle:Universe')
            ->findBy(
                array(),
                array(),
                $limit,
                $offset
            );
        ;
        return array('universes' => $universes);
    }

    public function getAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $universe = $em
            ->getRepository('DMHECommerceBundle:Universe')
            ->findOneById($slug);
        ;
        if (empty($universe)) {
            return View::create(['error' => 'Univverse not found'], Response::HTTP_NOT_FOUND);
        }
        return array('universe' => $universe);
    }

    /**
     * @ApiDoc(
     *    description="Create a category",
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
     * @Rest\Post("/categories")
     */
    public function postAction(Request $request)
    {
        $universe = new Universe();
        $form = $this->createForm(CategoryType::class, $universe);

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
            $em->persist($universe);
            $em->flush();

            return array('universe' => $universe);

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
    public function putAction(Request $request, Universe $universe)
    {
        $form = $this->createForm(CategoryType::class, $universe);

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
            return array('universe' => $universe);

        }else{
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *
     * )
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/universes/{id}")
     */
    public function removeAction(Request $request, Universe $universe)
    {
        /* @var $universe Universe */
        $em = $this->get('doctrine.orm.entity_manager');
        if ($universe) {
            $em->remove($universe);
            $em->flush();
        }
    }

}