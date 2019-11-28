<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/all_users", name="get_all_users")
     */

    public function all_users(UserRepository $userRepository )
    {
        $users = $userRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'error' => '','users' => $users
        ]);
    }
    /**
     * @Route("/all_users1", name="get_all_users1")
     */
    public function all_users1(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $users=$entityManager->getRepository(User::class)->findAll();
        return $this->render('admin/users1.html.twig', [
            'error' => '','users' => $users
        ]);
    }
    /**
     * @Route("/user_edit", name="app_user_edit")
     */
    public function user_edit(Request $request,EntityManagerInterface $entityManager, UserRepository $userRepository )
    {
        //$user = new User();
        $id=$request->get('user_id');

        $user=$userRepository->find($id);
        $userform=$this->createForm(UserEditFormType::class,$user);
        $userform->handleRequest($request);


        if ($userform->isSubmitted() && $userform->isValid())
        {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success","Sikeres mentés");
            return $this->redirectToRoute("admin/users.html.twig");
        }

        return $this->render('admin/user_edit.html.twig', [
            'userform' => $userform->createView()
        ]);
    }


}
