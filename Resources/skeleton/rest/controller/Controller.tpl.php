<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $entity_full_class_name ?>;
<?php if (isset($repository_full_class_name)): ?>
use <?= $repository_full_class_name ?>;
<?php endif ?>
use Symfony\Bundle\FrameworkBundle\Controller\<?= $parent_class_name ?>;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use \JsonSerializable;

/**
 * @Route("<?= $route_path ?>")
 */
class <?= $class_name ?> extends <?= $parent_class_name; ?><?= "\n" ?>
{
    /**
    * @param Request $request
    * @param EntityManagerInterface $entityManager
    * @param <?=$repository_class_name?> $repository
    * @return JsonResponse
    * @Route("/", methods={"POST"})
    */
    public function addElement(
        Request $request,
        EntityManagerInterface $entityManager,
        <?=$repository_class_name?> $repository
    ): JsonResponse {
        try {
            $request = $this->transformJsonBody($request);

            $element = new <?=$entity_class_name?>();

            // TODO set params

            $entityManager->persist($element);
            $entityManager->flush();

            return $this->response($element, 200);
        } catch (\Exception $e) {
            $data = [
                'success' => 0,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 400);
        }
    }


    /**
    * @param <?=$repository_class_name?> $repository
    * @return JsonResponse
    * @Route("/", methods={"GET"})
    */
    public function getElements(<?=$repository_class_name?> $repository) {
        try {
            $data = $repository->findAll();
            return $this->response($data);
        } catch (\Exception $e) {
            $data = [
                'success' => 0,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 400);
        }
    }


    /**
    * @param <?=$repository_class_name?> $repository
    * @param $id
    * @return JsonResponse
    * @Route("/{id}", methods={"GET"})
    */
    public function getElement(<?=$repository_class_name?> $repository, string $id) {
        try {
            $element = $repository->find($id);

            if (!$element){
                $data = [
                    'success' => 0,
                    'errors' => "Element not found",
                ];
                return $this->response($data, 404);
            }
            return $this->response($element);
        } catch (\Exception $e) {
            $data = [
                'success' => 0,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 400);
        }
    }

    /**
    * @param Request $request
    * @param EntityManagerInterface $entityManager
    * @param <?=$repository_class_name?> $repository
    * @param string $id
    * @return JsonResponse
    * @Route("/{id}", methods={"PUT"})
    */
    public function updateElement(
        Request $request,
        EntityManagerInterface $entityManager,
        <?=$repository_class_name?> $repository,
        string $id
    ) {
        try {
            $request = $this->transformJsonBody($request);

            $element = $repository->find($id);

            if (!$element){
                $data = [
                    'success' => 0,
                    'errors' => "Element not found",
                ];
                return $this->response($data, 404);
            }

            $queryData = $request->request->all();

            foreach ($queryData as $key => $val) {
                $method = 'set' . lcfirst($key);
                $element->$method($val);
            }
            // TODO set params

            $entityManager->persist($element);
            $entityManager->flush();

            return $this->response($element, 200);
        } catch (\Exception $e) {
            $data = [
                'success' => 0,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 400);
        }
    }

    /**
    * @param EntityManagerInterface $entityManager
    * @param <?=$repository_class_name?> $repository
    * @param string $id
    * @return JsonResponse
    * @Route("/{id}", methods={"DELETE"})
    */
    public function deleteElement(
        EntityManagerInterface $entityManager,
        <?=$repository_class_name?> $repository,
        string $id
    ) {
        try {
            $element = $repository->find($id);

            if (!$element) {
                return $this->response(['error' => 'element not found', 'success' => 0], 400);
            }

            $entityManager->remove($element);
            $entityManager->flush();

            return $this->response(['success' => 1]);
        } catch (\Exception $e) {
            $data = [
                'success' => 0,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 400);
        }
    }

    /**
    * Returns a JSON response
    *
    * @param array|JsonSerializable $data
    * @param int $status
    * @param array $headers
    * @return JsonResponse
    */
    protected function response($data, int $status = 200, $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }

    /**
    * @param Request $request
    * @return Request
    */
    protected function transformJsonBody(Request $request) : Request
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
