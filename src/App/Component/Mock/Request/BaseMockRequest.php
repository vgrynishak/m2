<?php
namespace App\App\Component\Mock\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

abstract class BaseMockRequest implements MockRequestInterface
{
    protected const ACCESS_TOKEN_HEADER_NAME = 'X-ACCESS-TOKEN';

    /** @var TokenInterface */
    protected $token;

    /**
     * @param Request $mockRequest
     *
     * @param string $userEmail
     */
    public function pushRequestByUserEmail(Request $mockRequest, string $userEmail): void
    {
        $this->makeTokenByEmail($userEmail);
        $this->injectToken($mockRequest);
        $this->pushRequest($mockRequest);
    }

    /**
     * @param string $userEmail
     *
     * @return mixed
     */
    abstract protected function makeTokenByEmail(string $userEmail);

    /**
     * @param Request $mockRequest
     *
     * @return mixed
     */
    abstract protected function injectToken(Request $mockRequest);

    /**
     * @param Request $mockRequest
     *
     * @return mixed
     */
    abstract protected function pushRequest(Request $mockRequest);
}
