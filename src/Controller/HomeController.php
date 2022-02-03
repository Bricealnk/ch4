<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $projects = $managerRegistry->getRepository(Project::class)
            ->findAll();
        return $this->render('home/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}