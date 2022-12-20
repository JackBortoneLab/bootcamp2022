<?php

function correction($reponse, $fichier) {
    $solution = file_get_contents("codes/".$fichier."_solution.txt");
    $resultat = ($reponse == true && $solution == "correct") || ($reponse == false && $solution == "erreur");
    echo "Validation de codes/$fichier.txt: " . ($resultat? "Succès" : "Erreur") . "<br>";

    if (!$resultat) {
        echo "Reçu: " . ($reponse ? "true" : "false") . "<br>";
        echo "Attendu: " . (($solution == "correct") ? "true" : "false") . "<br>";
    }
}