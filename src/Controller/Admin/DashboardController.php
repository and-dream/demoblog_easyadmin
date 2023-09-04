<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Back-Office');   //set le titre
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);

        return [
            MenuItem::linkToDashboard("Accueil", 'fa-solid fa-house'),
            MenuItem::section('Membre'),
            MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class),     //il attend en param 3 quel crud
            MenuItem::subMenu('Blog', 'fa fa-newspaper')->setsubItems([
                MenuItem::linkToCrud('Articles', 'fa fa-book', Article::class),
                MenuItem::linkToCrud('Category', 'fa fa-layer-group', Category::class),
                MenuItem::linkToCrud('Comment', 'fa fa-comment', Comment::class),
            ]),
            MenuItem::section('Retour au site'),
            MenuItem::linkToRoute('Accueil du site', 'fa fa-house-user', 'home')
            
        ];
    }
}
