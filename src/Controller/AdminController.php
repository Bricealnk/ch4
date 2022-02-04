<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function index(ProjectRepository $projectRepository)
    {
        return $this->render('admin/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form    = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('admin/add.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * @Route("/delete",name="delete")
     */
    public function delete(Project $project, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($project);
        $entityManager->flush();
        return $this->redirectToRoute('admin_home');
    }
}
