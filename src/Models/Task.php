<?php

namespace App\Models;

class Task
{
    private ?string $id;
    private ?string $title;
    private ?string $description;
    private ?string $status;
    private ?string $creation_date;
    private ?string $modification_date;

    public function __construct(?string $id, ?string $title, ?string $description, ?string $status, ?string $creation_date, ?string $modification_date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->creation_date = $creation_date;
        $this->modification_date = $modification_date;
    }

    //les getteurs
    public function getId(): ?string
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function getCreationDate(): ?string
    {
        return $this->creation_date;
    }
    public function getModificationDate(): ?string
    {
        return $this->modification_date;
    }

    //les setteurs
    public function setId(string $id)
    {
        $this->id = $id;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
    public function setCreationDate(string $creation_date): void
    {
        $this->creation_date = $creation_date;
    }
    public function setModificationDate(string $modification_date): void
    {
        $this->modification_date = $modification_date;
    }
}
