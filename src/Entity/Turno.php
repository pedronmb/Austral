<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Turno
 *
 * @ORM\Table(name="turnos")
 * @ORM\Entity
 */
class Turno
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_cola", type="integer", nullable=true)
     */
    private $idCola;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estado", type="boolean", nullable=true)
     */
    private $estado;
    
    /**
     * @var int|null
     *
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCola(): ?int
    {
        return $this->idCola;
    }

    public function setIdCola(?int $idCola): self
    {
        $this->idCola = $idCola;

        return $this;
    }
    
    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(?bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

        public function getNumero(): ?int
    {
        return $this->numero;
    }
    
    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }
}
