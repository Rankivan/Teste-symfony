<?php

namespace App\Model\QueryFilter;


class TesteFilter extends AbstractQueryFilter
{
    /**
     * @param string $nome
     */
    public function nome(string $nome)
    {
        $this->builder
            ->andWhere($this->rootAlias . '.nome like :nome')
            ->setParameter('nome', '%' . $nome . '%');
    }

    /**
     * param int $valor
     * @param int $valor
     */
    public function valor(int $valor)
    {
        $this->builder
            ->andWhere($this->rootAlias . '.valor = :valor')
            ->setParameter('valor', '%' . $valor . '%');
    }

    /**
     * @param string $direction
     */
    public function orderNome(string $direction)
    {
        $a = $this->rootAlias;

        $this->builder->orderBy($a . '.nome', $direction);
    }

    /**
     * @param array $ids
     */
    public function ids(array $ids)
    {
        $q = $this->rootAlias;
        $this->builder
            ->andWhere($q . '.id in (:ids)')
            ->setParameter('ids', $ids);
    }

    /**
     * @param string $filtro
     */
    public function filtro(string $filtro)
    {
        $a = $this->rootAlias;
        $this->builder->andWhere("(
            {$a}.nome LIKE :filtro 
        )")->setParameter('filtro','%' . $filtro . '%');
    }

    /**
     * @param string $direction
     */
    public function order(array $arOrder)
    {
        $a = $this->rootAlias;
        $this->builder->orderBy($a . '.' . ($arOrder['field'] ?: 'id'), ($arOrder['direction'] ?: 'asc'));
    }

    /**
     * @param $columns
     */
    public function listColumns($columns)
    {

        $a = $this->rootAlias;
        $select = [
            "$a.id as id",
            "$a.nome",
            "$a.valor"
        ];

        $this->builder->select(implode(', ', $select));
    }

}
