<?php


namespace App\Model\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Teste
 * @package App\Model\Entity
 *
 * @ORM\Table(name="tbl_teste", schema="dbprovas")
 * @ORM\Entity(repositoryClass="App\Model\Repository\TesteRepository")
 */
class Teste
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string")
     */
    private $nome;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getValor(): string
    {
        return $this->valor;
    }

    /**
     * @param string $valor
     */
    public function setValor(string $valor): void
    {
        $this->valor = $valor;
    }


}

