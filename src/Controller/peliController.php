<?php
namespace App\Controller;
use App\Repository\PeliculaRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class peliController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class peliController
{
    private $peliRepository;

    public function __construct(PeliculaRepository $peliRepository)
    {
        $this->peliRepository = $peliRepository;
    }

    /**
     * @Route("peli", name="add_peli", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nombre = $data['nombre'];
        $genero = $data['genero'];
        $descripcion = $data['descripcion'];

        if (empty($nombre) || empty($nombre) || empty($descripcion)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->peliRepository->savePeli($nombre, $genero, $descripcion);

        return new JsonResponse(['status' => 'Peli created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("peli/{id}", name="get_one_peli", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $peli = $this->peliRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $peli->getId(),
            'nombre' => $peli->getNombre(),
            'genero' => $peli->getGenero(),
            'descripcion' => $peli->getDescripcion(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("pelis", name="get_all_pelis", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $pelis = $this->peliRepository->findAll();
        $data = [];

        foreach ($pelis as $peli) {
            $data[] = [
                'id' => $peli->getId(),
                'name' => $peli->getNombre(),
                'genero' => $peli->getGenero(),
                'descripcion' => $peli->getDescripcion(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("peli/{id}", name="update_peli", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $peli = $this->peliRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['nombre']) ? true : $peli->setNombre($data['nombre']);
        empty($data['genero']) ? true : $peli->setgenero($data['genero']);
        empty($data['descripcion']) ? true : $peli->setdescripcion($data['descripcion']);

        $updatedpeli = $this->peliRepository->updatePeli($peli);

		return new JsonResponse(['status' => 'peli updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("peli/{id}", name="delete_peli", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $peli = $this->peliRepository->findOneBy(['id' => $id]);

        $this->peliRepository->removePeli($peli);

        return new JsonResponse(['status' => 'peli deleted'], Response::HTTP_OK);
    }
}

?>