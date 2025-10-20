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
            'creation_date' => $this->creation_date,
            'modification_date' => $this->modification_date
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
                $tasks[] = new Task(
                    $data->_id,
                    $data->title,
                    $data->description,
                    $data->status,
                    $data->creation_date,
                    $data->modification_date
                );
            }

            // Retourne le tableau d’objets Task
            return $tasks;
        } catch (\Exception $e) {
            // En cas d’erreur, on renvoie un tableau vide
            return [];
        }
    }

    /**
     * Récupère une tâche spécifique selon son ID
     */
    public function getTaskById(): ?Task
    {
        // Récupère la connexion à MongoDB (via ma classe Database)
        $mongo = Database::getConnection();
        // Nom de la base et de la collection (équivalent des tables en SQL)
        $namedatabase = 'toDoListPoles';
        $nameCollection = 'task';

        //l'id de notre objet courant
        $id = $this->id;

        // Le filtre "_id" permet de cibler un document précis
        // On doit transformer l'id en objet MongoDB\BSON\ObjectID
        $filter = ['_id' => new \MongoDB\BSON\ObjectID($id)];
        $query = new Query($filter);

        try {
            // Exécute la requête et récupère un curseurr = objet qui contient les résultats d’une requête
            $cursor = $mongo->executeQuery($namedatabase . "." . $nameCollection, $query);

            // Convertit le curseur en tableau de résultats
            $result = $cursor->toArray();

            // Si on trouve un résultat, on crée un objet Task
            if (!empty($result)) {
                return new Task(
                    $result[0]->_id,
                    $result[0]->title,
                    $result[0]->description,
                    $result[0]->status,
                    $result[0]->creation_date,
                    $result[0]->modification_date
                );
            }

            // Si rien n’est trouvé
            return null;
        } catch (\Exception $e) {
            // En cas d’erreur, on renvoie un tableau vide
            return null;
        }
    }

    public function editTask()
    {
        // Récupère la connexion à MongoDB (via ma classe Database)
        $mongo = Database::getConnection();
        // Nom de la base et de la collection (équivalent des tables en SQL)
        $namedatabase = 'toDoListPoles';
        $nameCollection = 'task';

        //l'id de notre objet courant
        $id = $this->id;
        // Données à mettre à jour
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'creation_date' => $this->creation_date,
            'modification_date' => $this->modification_date
        ];

        // Création de l’opération de mise à jour
        $bulk = new BulkWrite();

        // On recherche le document à modifier via son _id
        $filter = ['_id' => new \MongoDB\BSON\ObjectID($id)];

        // L’opérateur "$set" permet de modifier uniquement les champs précisés
        $bulk->update($filter, ['$set' => $data]);

        try {
            $mongo->executeBulkWrite($namedatabase . "." . $nameCollection, $bulk);
            // Retourne true si la mise à jour a réussi
            return true;
        } catch (Exception $e) {
            // Retourne false en cas d'erreur
            return false;
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
