<?php

declare(strict_types = 1);

namespace App\UI\Pet;

use App\Core\Entity\EntityFactory;
use App\Core\Entity\Pet;
use Nette;
use Nette\Application\Attributes\Requires;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\Responses\TextResponse;

final class PetPresenter extends Nette\Application\UI\Presenter
{
    private EntityFactory $entityFactory;

    public function __construct(EntityFactory $entityFactory)
    {
        parent::__construct();
        $this->entityFactory = $entityFactory;
    }

    #[Requires(methods: ['POST'])]
    public function actionCreatePet(): void
    {
        $request = $this->getHttpRequest();
        $rawBodyData = $request->getRawBody();
        $data = json_decode($rawBodyData, true, 512, JSON_THROW_ON_ERROR);

        //TODO validate data

        /** @var Pet $pet */
        $pet = $this->entityFactory->create($data, Pet::class);

        $this->getHttpResponse()->setCode(Nette\Http\IResponse::S201_Created);

        $acceptHeader = $request->getHeader('accept');
        $xml = $pet->toXML();

        if ($acceptHeader === 'application/xml') {
            $this->sendResponse(new TextResponse($xml));
        }

        $this->sendResponse(new JsonResponse($pet));
    }

    #[Requires(methods: ['GET'])]
    public function actionGetPet(int $id): void
    {
        $this->sendResponse(new JsonResponse(['name' => 'Betka', 'id' => $id]));
    }
}
