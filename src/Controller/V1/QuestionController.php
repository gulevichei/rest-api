<?php

namespace App\Controller\V1;

use App\Form\Type\QuestionFormType;
use App\Service\Data\DataProvider;
use App\Service\Translate\GoogleTranslateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolation;

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
     * @Route("/{lang}/list", requirements={"lang": "aa|ab|ae|af|ak|am|an|ar|as|av|ay|az|ba|be|bg|bh|bi|bm|bn|bo|br|bs|ca|ce|ch|co|cr|cs|cu|cv|cy|da|de|dv|dz|ee|el|en|eo|es|et|eu|fa|ff|fi|fj|fo|fr|fy|ga|gd|gl|gn|gu|gv|ha|he|hi|ho|hr|ht|hu|hy|hz|ia|id|ie|ig|ii|ik|io|is|it|iu|ja|jv|ka|kg|ki|kj|kk|kl|km|kn|ko|kr|ks|ku|kv|kw|ky|la|lb|lg|li|ln|lo|lt|lu|lv|mg|mh|mi|mk|ml|mn|mr|ms|mt|my|na|nb|nd|ne|ng|nl|nn|no|nr|nv|ny|oc|oj|om|or|os|pa|pi|pl|ps|pt|qu|rm|rn|ro|ru|rw|sa|sc|sd|se|sg|si|sk|sl|sm|sn|so|sq|sr|ss|st|su|sv|sw|ta|te|tg|th|ti|tk|tl|tn|to|tr|ts|tt|tw|ty|ug|uk|ur|uz|ve|vi|vo|wa|wo|xh|yi|yo|za|zh|zu"}, name="app_question_get_list", methods={"GET"})
     *
     * @param              $lang
     * @param DataProvider $dataProvider
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
     * @param DataProvider $dataProvider
     *
     * @return JsonResponse
     */
    public function post(Request $request, DataProvider $dataProvider): JsonResponse
    {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : []);
            $data = json_decode($request->getContent());
        }

        $form = $this->createForm(QuestionFormType::class);
        $form->submit($request->request->all());
        // @todo validation for form
        if ($form->isSubmitted() && $form->isValid()) {
            $items   = $dataProvider->getListOf('questions');
            $items[] = $data;
            $dataProvider->save($items, 'questions');
        } else {
            return new JsonResponse(["Validation failed"], 400);
        }

        return new JsonResponse([], 201);
    }

}
