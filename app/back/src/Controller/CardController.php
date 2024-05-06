<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HandServiceInterface;
use App\Service\HandValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
final class CardController extends AbstractController
{
    private const int DEFAULT_HAND_SIZE = 10;

    public function __construct(private readonly HandServiceInterface $handService, private readonly HandValidatorInterface $validator)
    {
    }

    #[Route('/hand/{size}', name: 'random_hand', requirements: ['size' => '\d+'], methods: Request::METHOD_GET)]
    public function getRandomHand(int $size = self::DEFAULT_HAND_SIZE): JsonResponse
    {
        return new JsonResponse($this->handService->getHand($size));
    }

    /**
     * @throws \JsonException
     */
    #[Route('/sort', name: 'sort_hand')]
    public function getSortedHand(RequestStack $requestStack): JsonResponse
    {
        $request = $requestStack->getCurrentRequest();
        $hand = $request->getContent();
        if (!$hand) {
            throw new BadRequestException('You can not sort an empty hand!');
        }

        return new JsonResponse($this->handService->sortHand($this->validator->validate($hand)));
    }
}
