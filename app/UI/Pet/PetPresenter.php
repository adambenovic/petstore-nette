<?php

declare(strict_types = 1);

namespace App\UI\Pet;

use Nette;
use Nette\Application\Attributes\Requires;
use Nette\Application\Responses\JsonResponse;

final class PetPresenter extends Nette\Application\UI\Presenter
{
    #[Requires(methods: ['POST'])]
    public function actionCreatePet(): void
    {
        $request = $this->getHttpRequest();
        $rawBodyData = $request->getRawBody();
        $data = json_decode($rawBodyData, true, 512, JSON_THROW_ON_ERROR);

        //TODO validate data

        $pet = [];

        foreach ($data as $key => $value) {
            $pet[$key] = $value;
        }

        $this->getHttpResponse()->setCode(Nette\Http\IResponse::S201_Created);
        $this->sendResponse(new JsonResponse($pet));
    }

    #[Requires(methods: ['GET'])]
    public function actionGetPet(int $id): void
    {
        $this->sendResponse(new JsonResponse(['name' => 'Betka', 'id' => $id]));
    }
}
