<?php


namespace App\Utils;

abstract class AbstractController
{
    protected array $arrayError = [];

    public function redirectToRoute($route, $code)
    {
        http_response_code($code);
        header("Location: {$route}");
        exit;
    }

    public function debug($value)
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
    }

    public function isNotEmpty($value)
    {
        if (empty($_POST[$value])) {
            $this->arrayError[$value] = "Le champ ne peut pas être vide.";
            return $this->arrayError;
        }
        return false;
    }

    public function checkFormat($nameInput, $value)
    {
        $regexTitle = '/^[a-zA-Zà-üÀ-Ü -]{2,255}$/';
        $regexDescription = '/^[a-zA-Zà-üÀ-Ü0-9 #?!@$%^,.;&*-]{4,}$/';
        $regexStatus = '/^[a-zA-Z ]{3,10}$/';

        switch ($nameInput) {
            case 'title':
                if (!preg_match($regexTitle, $value)) {
                    $this->arrayError['title'] = 'Merci de renseigner un titre correcte!';
                }
                break;
            case 'description':
                if (!preg_match($regexDescription, $value)) {
                    $this->arrayError['description'] = 'Merci de donné une description correcte';
                }
                break;
            case 'status':
                if (!preg_match($regexStatus, $value)) {
                    $this->arrayError['status'] = 'Merci de renseigner un statut correcte!';
                }
                break;
        }
    }

    //Méthode qui permet d'appeler les deux autre méthodes
    public function totalCheck($nameInput, $valueInput)
    {
        //appel la méthode checkformat et je lui donne le nom et la valeur de mon input
        $this->checkFormat($nameInput, $valueInput);
        //appel la méthode isNotEmpty et je lui donne le nom de mon input
        $this->isNotEmpty($nameInput);
        //retourne mon tableau d'erreur:
        return $this->arrayError;
    }
}
