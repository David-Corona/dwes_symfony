<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductoRepository::class)
 * @UniqueEntity("titulo", message="El título introducido ya existe.")
 */
class Producto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="El campo título no puede quedar vacío.")
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="El campo subtítulo no puede quedar vacío.")
     */
    private $subtitulo;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="El campo descripción no puede quedar vacío.")
     * @Assert\Length(
     *      min = 10,
     *      max = 100,
     *      minMessage = "La descripción debe tener al menos {{ limit }} caracteres",
     *      maxMessage = "La descripción debe tener como máximo {{ limit }} caracteres"
     * )
     */
    private $descripcion;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     * @Assert\Type(type="numeric", message="El precio debe ser un número.")
     * @Assert\NotBlank(message="El campo precio no puede quedar vacío.")
     * @Assert\Positive(message="El precio debe ser un número mayor de 0.")
     */
    private $precio;

    //      * @ORM\Column(type="string", length=255, nullable=true)
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(mimeTypes={"image/jpeg", "image/png"})
     * @Assert\NotBlank(message="Debes subir una imagen del producto.")
     */
    private $imagen;

    /**
     * @ORM\ManyToOne(targetEntity=Categoria::class, inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoria;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    public function __construct()
    {
//        $this->imagen = 'images/logotesteo.png';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getSubtitulo(): ?string
    {
        return $this->subtitulo;
    }

    public function setSubtitulo(string $subtitulo): self
    {
        $this->subtitulo = $subtitulo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

}
