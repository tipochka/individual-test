<?php

namespace App\Controller;

use App\Entity\Classroom;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/classroom")
 */
class ClassroomController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("")
     * @return View
     */
    public function index(): View
    {
        $repository = $this->getDoctrine()->getRepository(Classroom::class);

        return $this->view($repository->findBy(['is_active' => true]));
    }


    /**
     * @Rest\Post("/add")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return View
     */
    public function add(Request $request, EntityManagerInterface $em): View
    {
        $name = $request->get('name');
        $isActive = $request->get('is_active', true);

        $classroom = new Classroom();
        $classroom->setName($name);
        $classroom->setIsActive($isActive);

        $em->persist($classroom);
        $em->flush();

        return $this->getMessage(Response::HTTP_OK, "Classroom save Successfully");
    }

    /**
     * @Rest\Put("/update/{id}")
     * @RequestParam(name="id", requirements="\d+", description="id")
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return View
     */
    public function update(int $id, Request $request, EntityManagerInterface $em): View
    {
        $name = $request->get('name');
        $isActive = $request->get('is_active', true);

        $classroom = $em->getRepository(Classroom::class)->find($id);
        if (empty($classroom)) {
            return $this->getMessage(Response::HTTP_NOT_FOUND, "Classroom not found");
        }

        $classroom->setName($name);
        $classroom->setIsActive($isActive);

        $em->flush();

        return $this->getMessage(Response::HTTP_OK,"Classroom save Successfully");
    }

    /**
     * @Rest\Delete("/remove/{id}")
     * @RequestParam(name="id", requirements="\d+", description="id")
     * @param int id
     * @param EntityManagerInterface $em
     * @return View
     */
    public function remove(int $id, EntityManagerInterface $em): View
    {
        $classroom = $em->getRepository(Classroom::class)->find($id);
        if (empty($classroom)) {
            return $this->getMessage(Response::HTTP_NOT_FOUND, "Classroom not found");
        }

        $em->remove($classroom);
        $em->flush();

        return $this->getMessage(Response::HTTP_OK, "Classroom Successful remove");
    }

    /**
     * @param int id
     * @Rest\Get("/{id}")
     * @RequestParam(name="id", requirements="\d+", description="id")
     * @return View
     */
    public function getId(int $id): View
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        if (empty($classroom)) {
            return $this->getMessage(Response::HTTP_NOT_FOUND, "Classroom not found");
        }

        return $this->view($classroom);
    }

    private function getMessage(int $code, string $message): View
    {
        return $this->view([
            'status_code' => $code,
            'status_text' => $message,
        ]);
    }
}
