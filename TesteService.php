<?php


namespace App\Service;


use App\Model\Entity\Teste;
use App\Model\QueryFilter\TesteFilter;
use App\Model\Repository\TesteRepository;
use App\Service\Main\AbstractService;
use App\Service\Main\NegocialException;
use App\Util\ListaSimples;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;


class TesteService extends AbstractService
{
    /**
     * @var ManagerRegistry
     */
    protected $manager;

    /**
     * @var TesteRepository
     */
    protected $repository;


    /**
     * TesteService constructor.
     * @param ManagerRegistry $doctrine
     * @param Security $security
     * @throws \Exception
     */
    public function __construct(ManagerRegistry $doctrine, Security $security)
    {
        parent::__construct($doctrine, $security);
        $this->repository = $doctrine->getRepository(Teste::class);
    }


    /**
     * Valida os dados antes de salvar
     * @param Request $request
     * @return array
     * @throws NegocialException
     */
    public function validarDados(Request $request)
    {
        $dados = $request->request->all();
        $dados['testeId'] = $dados['testeId'] ?? null;

        //Verificando a obrigatoriedade da descricao
        if (empty($dados['nome'])) {
            throw new NegocialException('O campo Nome é obrigatório!');
        }

        //Verificando a obrigatoriedade da descricao
        if (empty($dados['valor'])) {
            throw new NegocialException('O campo Valor é obrigatório!');
        }

        return $dados;
    }

    /**
     * Método para salvar os dados no banco de dados
     * @param Request $request
     * @return Teste|null
     * @throws NegocialException
     */
    public function salvar(Request $request)
    {
        try {
            $dados = $this->validarDados($request);
            $objeto = new Teste();

            if (!empty($dados['testeId'])) {
                $objeto = $this->getRepository()->find($dados['testeId']);
            }

            $objeto->setNome($dados['nome']);
            $objeto->setValor($dados['valor']);

            $this->manager->getManager()->persist($objeto);
            $this->manager->getManager()->flush();

            return $objeto;

        } catch (NegocialException $e) {
            throw $e;
        }
    }

    /**
     * Aplicação do Filtro para requisição dos dados
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getList(Request $request)
    {
        return ListaSimples::construir(TesteFilter::class, $request, $this);
    }


    /**
     * @return Teste[]
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }


    /**
     * retorna a repository da service
     * @return TesteRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param $id
     * @throws NegocialException
     */
    public function getDadosForm($id)
    {
        $teste = null;
        if (!empty($id)) {
            $teste = $this->getRepository()->find($id);

            if (empty($teste)) {
                throw new NegocialException('Parâmetro não encontrado!');
            }
        }
        return ['teste' => $teste];
    }

    public function excluir($testeId)
    {
        if (empty($testeId)) {
            throw new NegocialException('O ID do elemento não existe!');
        }

        $objetoTeste = $this->getRepository()->find($testeId);

        if (empty($objetoTeste)) {
            throw new NegocialException('O Dado teste não existe!');
        }
        $this->manager->getManager()->remove($objetoTeste);
        $this->manager->getManager()->flush();
    }


}