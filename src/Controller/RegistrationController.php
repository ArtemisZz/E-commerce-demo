<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/registration", name="registration.")
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/", name="registration")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                ));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
