<?php

namespace App\Controller\Auth;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class LoginController extends AbstractController
{
    private $hashed;
    private $db;
    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
        )
    {
        $this->hashed = $passwordHasher;
        $this->db = $entityManager;
    }
    #[Route('/auth/login', name: 'app_auth_login')]
    public function index(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            return self::login($request->toArray());
        }
        return $this->render('auth/login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    public function login(array $data):JsonResponse
    {
        $user = $this->db->getRepository(User::class)->findOneBy(['email'=>$data['email']]);
        if(!$user){
            return custom_response(
                'login failed',
                'Email no encontrado',
                422
            );
        };
        if(!$this->hashed->isPasswordValid($user,$data['password'])){
            return custom_response(
                'Contraseña incorrecta',
                'login falló',
                422
            );
        };

        $this->db->beginTransaction();
        try {
            $token = new Token();
            $token->setUser($user);
            $tokenValue = uniqid().uniqid();
            $token->setValue($tokenValue);
            $this->db->persist($token);
            $this->db->flush();
            $this->db->commit();
            return custom_response('Login exitoso',$tokenValue);
        } catch (\Exception $e) {
            $this->db->rollback();
            return custom_response('Error al registrar', $e->getMessage(), 400);
        }
    }
}
