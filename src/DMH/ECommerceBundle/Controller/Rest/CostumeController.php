<?php
/**
 * Created by PhpStorm.
 * User: kyotsunee
 * Date: 23/03/2017
 * Time: 01:45
 */

namespace DMH\ECommerceBundle\Controller\Rest;


use DMH\ECommerceBundle\Entity\Costume;
use DMH\ECommerceBundle\Form\CostumeType;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;

class CostumeController extends Controller implements ClassResourceInterface
{

    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all Costumes",
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
        $costumes = $em
            ->getRepository('DMHECommerceBundle:Costume')
            ->findBy(
                array(),
                array(),
                $limit,
                $offset
            );
        ;
        return array('costumes' => $costumes);
    }

    public function getAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em
            ->getRepository('DMHECommerceBundle:Costume')
            ->findOneById($slug);
        ;
        if (empty($category)) {
            return View::create(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }
        return array('category' => $category);
    }

    /**
     * @ApiDoc(
     *    description="Create a new costume",
     *    input={"class"=CostumeType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Created successfully",
     *        400 = "Invalid Form"
     *    },
     *    responseMap={
     *         201 = {"class"=Costume::class, "groups"={""}},
     *         400 = { "class"=CostumeType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={""})
     * @Rest\Post("/costumes")
     */
    public function postAction(Request $request)
    {
        $costume = new Costume();
        $form = $this->createForm(CostumeType::class, $costume);

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
            $em->persist($costume);
            $em->flush();

            return array('costume' => $costume);

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
    public function putAction(Request $request, Costume $costume)
    {
        $form = $this->createForm(CostumeType::class, $costume);

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
            return array('costume' => $costume);

        }else{
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *
     * )
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/costumes/{id}")
     */
    public function removeAction(Request $request, Costume $costume)
    {
        /* @var $category Costume */
        $em = $this->get('doctrine.orm.entity_manager');
        if ($costume) {
            $em->remove($costume);
            $em->flush();
        }
    }

}