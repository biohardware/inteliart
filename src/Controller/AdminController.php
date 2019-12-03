<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{

    /**
     * @Route("/all_users", name="get_all_users")
     */

    public function all_users(UserRepository $userRepository)
    {

        $users = $userRepository->findAll();


        return $this->render('admin/users.html.twig', [
            'error' => '', 'users' => $users
        ]);
    }


    /**
     * @Route("/user_add", name="app_user_add")
     * @Route("/user_edit/{user}", name="app_user_edit")
     */
    public function user_edit(Request $request, EntityManagerInterface $entityManager, User $user=null, UserPasswordEncoderInterface $encoder)
    {
        if (!$user){
            $user=new User();
        }
        $userform = $this->createForm(UserEditFormType::class, $user, [
            'edit' => $user->getId()
        ]);

        $userform->handleRequest($request);

        if ($userform->isSubmitted() && $userform->isValid())
        {
            if (!$user->getId()){
                $password="dfsdafsafadsfadsfasd";
            }else{
                $password = $userform["password"]->getData();
            }

            $encoded = $encoder->encodePassword($user, $password);

            $user->setPassword($encoded);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success", "Sikeres mentés");

            return $this->redirectToRoute("get_all_users");
        }

        return $this->render('admin/user_form.html.twig', [
            'userform' => $userform->createView()
        ]);
    }

        /**
         * @Route("/user_delete/{user}", name="app_user_delete")
         */
        public function user_delete(User $user, EntityManagerInterface $entityManager)
        {
            $entityManager->remove($user);
            $entityManager->flush();
            $error = "";
            return $this->redirectToRoute("get_all_users");

        }
}
