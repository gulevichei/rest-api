<?php

namespace App\Controller\V1;

use App\Form\Type\QuestionFormType;
use App\Service\Data\DataProvider;
use App\Service\Translate\GoogleTranslateService;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/questions")
 *
 * Class QuestionController
 *
 * @package App\Controller\V1
 */
class QuestionController extends AbstractController
{
    /**
     * @Route("/get/{lang}", requirements={"lang": "^[a-z]{2}$"}, name="app_question_get_list", methods={"GET"})
     *
     * @SWG\Parameter(
     *     name="app_question_get_list",
     *     in="body",
     *     description="Language (ISO-639-1 code) in which the questions and choices should be translated",
     *     @SWG\Schema()
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of translated questions and associated choices",
     *     @SWG\Schema()
     * )
     *
     * @param                        $lang
     * @param DataProvider           $dataProvider
     * @param GoogleTranslateService $googleTranslateService
     *
     * @return JsonResponse
     */
    public function list($lang, DataProvider $dataProvider, GoogleTranslateService $googleTranslateService)
    {
        $items = $dataProvider->getListOf('questions');
        if ($lang != 'en') {
            // @todo recursive object traversal
            foreach ($items as $item) {
                $item->text = $googleTranslateService->translate($item->text, 'en', $lang);
                foreach ($item->choices as $choice) {
                    $choice->text = $googleTranslateService->translate($choice->text, 'en', $lang);
                }
            }
        }

        return new JsonResponse(
            [
                'data' => [
                    'items' => $items,
                ],
            ]
        );
    }

    /**
     * @Route("/post", name="app_question_post", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="app_question_post",
     *     in="body",
     *     description="Creates a new question and associated choices (the number of associated choices must be exactly equal to 3)",
     *     @SWG\Schema()
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returns status with error list if exist",
     *     @SWG\Schema()
     * )
     *
     * @param DataProvider $dataProvider
     *
     * @return JsonResponse
     */
    public function post(Request $request, DataProvider $dataProvider): JsonResponse
    {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace((array)$data);
        }

        $form = $this->createForm(QuestionFormType::class);
        $form->submit($request->request->all());
        // @todo custom validation for QuestionFormType with choices equal to 3
        if ($form->isSubmitted() && $form->isValid() && count($data['choices']) == 3) {
            $items   = $dataProvider->getListOf('questions');
            $items[] = json_decode($request->getContent());
            $dataProvider->save($items, 'questions');
        } else {
            return new JsonResponse(["Validation failed"], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], Response::HTTP_CREATED);
    }

}
