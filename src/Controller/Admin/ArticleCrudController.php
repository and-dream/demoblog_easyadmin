<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),  //écrire le label que l'on souhaite à la suite
            TextField::new('image'),
            TextEditorField::new('content')->onlyOnForms(),   //on le veut que sur le form (ajout & édition)
            TextareaField::new('content', 'Contenu')->hideOnForm()->setMaxlength(20),
            DateTimeField::new('createdAt', "Date d'enregistrement")->hideOnForm()->setFormat('dd.MM.yyy à HH:mm:ss zzz'),
            AssociationField::new('category', 'Catégorie'),
        ];
    }
    //surcharger et non créer une nouvelle entité
    //$entityFqcn c'est Article, la classe dans laquelle on est
    public function createEntity(string $entityFqcn)
    {
        $article = new $entityFqcn;   //équivaut à faire $article = new Article();
        $article->setCreatedAt(new \DateTime());  //on le set à la main car on veut qu'il soit créé automatiquement lors de createEntity()
        return $article;

    }
    
}
