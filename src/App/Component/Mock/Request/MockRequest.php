<?php

namespace App\App\Component\Mock\Request;

use App\App\Doctrine\Entity\User as UserEntity;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use App\App\Doctrine\Repository\UserRepository as UserEntityRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class MockRequest extends BaseMockRequest
{
    /** @var ContainerInterface */
    private $container;
    /** @var JWTManager */
    private $lexitJwtManager;
    /** @var UserEntityRepository */
    private $userEntityRepository;

    /**
     * MockRequest constructor.
     *
     * @param ContainerInterface $container
     * @param UserEntityRepository $userEntityRepository
     */
    public function __construct(ContainerInterface $container, UserEntityRepository $userEntityRepository)
    {
        $this->container = $container;
        $this->lexitJwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');
        $this->userEntityRepository = $userEntityRepository;
    }

    /**
     * @param string $userEmail
     */
    protected function makeTokenByEmail(string $userEmail)
    {
        /** @var UserEntity $managerEntity */
        $managerEntity = $this->userEntityRepository->findOneBy(['email'=>$userEmail]);
        $jwtAccessToken = $this->lexitJwtManager->create($managerEntity);
        /** @var TokenInterface token */
        $this->token = new JWTUserToken($managerEntity->getRoles(), $managerEntity, $jwtAccessToken);
    }

    /**
     * @param Request $mockRequest
     */
    protected function injectToken(Request $mockRequest)
    {
        $rawToken = $this->token->getCredentials();
        $mockRequest->headers->add([self::ACCESS_TOKEN_HEADER_NAME => $rawToken]);
        $this->container->get('security.token_storage')->setToken($this->token);
    }

    /**
     * @param Request $mockRequest
     */
    protected function pushRequest(Request $mockRequest)
    {
        $requestStack = new RequestStack();
        $requestStack->push($mockRequest);
    }
}
