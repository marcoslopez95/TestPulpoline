<?php

namespace App\Controller\Api;

use App\Entity\ApiCall;
use App\Entity\Token;
use App\Services\CurrencyLayerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class ApiController extends AbstractController
{
    private $db;
    public function __construct(
        EntityManagerInterface $entityManager
        )
    {
        $this->db = $entityManager;
    }

    #[Route('/api/getExchange', name: 'api')]
    public function index(Request $request): JsonResponse
    {
        if($request->getMethod() !== 'POST'){
            $response['success'] = $request->getMethod();
            return custom_response('request error', $response);
        }
        $service = new CurrencyLayerService();
        $req = $request->toArray();
        // $response = $service->getExchange($req['from'], $req['to'], $req['amount']);

        $authorizationHeader = $request->headers->get('Authorization');
        $user = null;
        $ip = $request->getClientIp();

        if ($authorizationHeader) {
            $token = explode(' ', $authorizationHeader)[1];
            $tokenModel = $this->db->getRepository(Token::class)->findOneBy(['value'=> $token]);
            if($tokenModel){
                $user = $tokenModel->getUser();
            }
        }else{
            $now = \Carbon\Carbon::now();
            $startDate = new \DateTimeImmutable($now->startOfDay());
            $endDate = new \DateTimeImmutable($now->endOfDay());

            $apiCalls = $this->db->getRepository(ApiCall::class)->getApiCallsByIpAndDateRange($ip,$startDate,$endDate);

            if(count($apiCalls) > 4){
                return custom_response('request limited', true,205);
            }
        }

        $response= [];
        $this->db->beginTransaction();
        try{
            $apiCall = new ApiCall;
            $date = new \DateTimeImmutable();
            $apiCall->setCreatedAt($date);
            $apiCall->setIp($ip);
            $apiCall->setResponseApi($response);
            $apiCall->setUser($user);
            $this->db->persist($apiCall);
            $this->db->flush();
            $this->db->commit();
        }catch(\Exception $e){
            $this->db->rollback();
            return custom_response('request Error', $e->getMessage(),400);
        }
        return custom_response('request successful', $response);
    }
}