<?php
namespace App\App\Component\Mock\Request;

use Symfony\Component\HttpFoundation\Request;

interface MockRequestInterface
{
    public function pushRequestByUserEmail(Request $mockRequest, string $userEmail): void;
}
