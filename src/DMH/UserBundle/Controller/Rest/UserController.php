<?php

namespace DMH\UserBundle\Controller\Rest;

use DMH\UserBundle\Entity\User;
use DMH\UserBundle\Form\UserType;
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

class UserController extends Controller implements ClassResourceInterface
{

    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all User",
     *  tags={
     *     "stable"
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized",
     *      404={
     *        "Returned when the user is not found",
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
        $user = $em
            ->getRepository('DMHUserBundle:User')
            ->findBy(
                array(),
                array(),
                $limit,
                $offset
            );
        ;
        return array('user' => $user);
    }

    public function getAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em
            ->getRepository('DMHUserBundle:User')
            ->findOneById($slug);
        ;
        if (empty($product)) {
            return View::create(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return array('user' => $user);
    }

    /**
     * @ApiDoc(
     *    description="Create an user",
     *    input={"class"=UserType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Created successfully",
     *        400 = "Invalid Form"
     *    },
     *    responseMap={
     *         201 = {"class"=User::class, "groups"={""}},
     *         400 = { "class"=UserType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={""})
     * @Rest\Post("/users")
     */
    public function postAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $data = $request->request->all();

        $submitted = array();
        foreach($data as $key => $item) {
            if($key != "_format"){
                $submitted[$key] = $item;
            }
        }

        $file = $request->files->get('thumbnail');
        $submitted['thumbnail']['file'] = $file;
        $form->submit($submitted);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return array('user' => $user);

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
    public function putAction(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);

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
            return array('user' => $user);

        }else{
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *
     * )
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/users/{id}")
     */
    public function removeAction(Request $request, User $user)
    {
        /* @var $user User */
        $em = $this->get('doctrine.orm.entity_manager');
        if ($user) {
            $em->remove($user);
            $em->flush();
        }
    }

}