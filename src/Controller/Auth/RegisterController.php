<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $db;
    public function __construct(EntityManagerInterface $db)
    {
        $this->db = $db;
    }

    #[Route('/auth/register', name: 'app_auth_register')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($request->getMethod() === 'POST') {
            return self::registerUser($request->toArray(), $passwordHasher);
        }
        return $this->render('auth/register/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }

    private function registerUser(array $data, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $this->db->beginTransaction();
        try {
            $user = $this->db->getRepository(User::class)->findOneBy(['email'=>$data['email']]);
            if($user){
                return custom_response(
                    'Email ya existe',
                    'register failed',
                    422
                );
            };
            $user = new User();
            $user->setEmail($data['email']);
            $user->setRoles([Roles::USER->value]);
            $plaintextPassword = $data['password'];
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $this->db->persist($user);
            $this->db->flush();
            $this->db->commit();
            return custom_response('Registrado Correctamente');
        } catch (\Exception $e) {
            $this->db->rollback();
            return custom_response('Error al registrar', $e->getMessage(), 400);
        }
    }
}
