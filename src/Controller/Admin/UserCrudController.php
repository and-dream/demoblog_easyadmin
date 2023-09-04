<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(public UserPasswordHasherInterface $hasher)
    {
        //on peut utiliser le hasher où on veut juste en rajouter cette méthode 
    }
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email', 'E-mail'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('nom', 'Nom de famille'),
            TextField::new('adresse', 'Adresse'),
            TextField::new('ville'),
            IntegerField::new('codePostal', 'Code Postal'),
            TextField::new('password', 'Mot de passe')->setFormType(PasswordType::class)->onlyWhenCreating(),
            CollectionField::new('roles')->setTemplatePath('/admin/field/roles.html.twig'),    
        ];
    }

    //$user = $entityinstance : c'est l'objet qu'on va remplir
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void   //on va typer directement
    {   //si mon objet possède un ID ça veut dire qu'il est créé et que je suis en update
        //!donc si mon user n'a PAS d'id : création de l'utilisateur
        if(!$entityInstance->getId())
        {
            $entityInstance->setPassword(
                $this->hasher->hashPassword($entityInstance, $entityInstance->getPassword())
            );
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
    
}
