<?php

namespace App\Models;

use Config\Database;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Query;
use mysql_xdevapi\Exception;

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

    /**
     * Sauvegarde une tâche dans la base MongoDB
     */
    public function saveTask()
    {
        // Récupère la connexion à MongoDB (via ma classe Database)
        $mongo = Database::getConnection();
        // Nom de la base et de la collection (équivalent des tables en SQL)
        $namedatabase = 'toDoListPoles';
        $nameCollection = 'task';

        // Prépare les données à insérer sous forme de tableau associatif
        // En MongoDB, chaque document est un tableau clé/valeur
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'creation_date' => $this->creation_date
        ];

        // Création d’un objet "BulkWrite"
        // → Permet d’envoyer une ou plusieurs opérations (insert, update, delete)
        $bulk = new BulkWrite();

        // On ajoute l’opération d’insertion
        $bulk->insert($data);

        try {
            // Envoie la requête à MongoDB (exécution de l’écriture)
            $mongo->executeBulkWrite($namedatabase . "." . $nameCollection, $bulk);
            return true;
        } catch (BulkWriteException $e) {
            // En cas d’erreur (connexion, requête, etc.)
            echo "Erreur d'insertion : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Récupère toutes les tâches présentes dans la collection
     */
    public function getAllTasks()
    {
        // Récupère la connexion à MongoDB (via ma classe Database)
        $mongo = Database::getConnection();
        // Nom de la base et de la collection (équivalent des tables en SQL)
        $namedatabase = 'toDoListPoles';
        $nameCollection = 'task';

        // La requête vide [] signifie : "récupère tous les documents"
        $query = new Query([]);

        // Création d'un tableau vide
        $tasks = [];

        try {
            // Exécute la requête et récupère un curseurr = objet qui contient les résultats d’une requête
            $cursor = $mongo->executeQuery($namedatabase . "." . $nameCollection, $query);

            // Convertit le curseur en tableau de résultats
            $result = $cursor->toArray();

            // Pour chaque document renvoyé, on crée un objet Task
            foreach ($result as $data) {
                if (isset($data->modification_date)) {
                    $tasks[] = new Task(
                        $data->_id,
                        $data->title,
                        $data->description,
                        $data->status,
                        $data->creation_date,
                        $data->modification_date
                    );
                } else {
                    $tasks[] = new Task(
                        $data->_id,
                        $data->title,
                        $data->description,
                        $data->status,
                        $data->creation_date,
                        null
                    );
                }
            }

            // Retourne le tableau d’objets Task
            return $tasks;
        } catch (\Exception $e) {
            // En cas d’erreur, on renvoie un tableau vide
            return [];
        }
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
