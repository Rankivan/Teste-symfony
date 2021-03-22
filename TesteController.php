<?php


namespace App\Controller\Gestao;


use App\Service\Main\NegocialException;
use App\Service\TesteService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * Class TesteController
 * @package App\Controller\Gestao
 *
 * @Route ("/gestao/configuracao/teste")
 */

class TesteController extends AbstractController
{

    /**
     *  Abre a tela inicial do projeto
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     * @Route("/", name="app_gestao_configuracao_teste_index")
     */
    public function index()
    {
        return $this->render('gestao/configuracao/teste/index.html.twig');
    }


    /**
     * Retorna um json com a lista de Testes
     *
     * @Route("/lista", name="app_gestao_configuracao_teste_list_ajax")
     * @throws \Exception
     */
    public function getListAjax(Request $request, TesteService $testeService)
    {
        return $this->json($testeService->getList($request));
    }

    /**
     *  Redireciona para a tela de cadastro
     * @Route("/form/{id}", defaults={"id"=""}, name="app_gestao_configuracao_teste_form")
     */
    public function form($id, TesteService $testeService)
    {
        try {
            return $this->render(
                'gestao/configuracao/teste/form.html.twig',
                 $testeService->getDadosForm($id)
            );
        } catch (NegocialException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_gestao_configuracao_teste_index');
        }
    }


    /**
     *  Salva os valores que vem do ajax
     * @Route("/salvar", name="app_gestao_configuracao_teste_salvar", methods={"POST"})
     * @param Request $request
     */
    public function salvar(Request $request, TesteService $testeService)
    {
        try {
            $result = $testeService->salvar($request);
            $this->addFlash('success', 'Teste salvo com sucesso!');
            return $this->json([
                'success'  => true,
                'id'       => $result->getId(),
            ], Response::HTTP_OK);

        } catch (NegocialException $e) {
            return $this->json(['success' => false, 'message' => $e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        }
    }

    /**
     * @param Request $request
     * @param TesteService $testeService
     * @Route("/excluir", name="app_gestao_configuracao_teste_excluir", methods={"DELETE"})
     */
    public function excluir(Request $request, TesteService $testeService)
    {
        try {
            $testeService->excluir($request->get('testeId'));
            return $this->json(['success'  => true,'message' => 'Excluído com sucesso!'], Response::HTTP_OK);

        } catch (NegocialException $e) {

            return $this->json(['success' => false, 'message' => $e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        }

    }






}