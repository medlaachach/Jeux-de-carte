<?php

namespace Cards\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Stdlib\Parameters;


class CardsController extends AbstractActionController
{
	/*
	 * Appel du 1er WS pour récupérer les cartes
	 * Trier les cartes selon categoryOrder et valueOrder
	 * Envoi le résultat au 2eme WS de vérification
	 * Envoyer le résultat à la vue
	*/
    public function indexAction()
    {
		$request = new Request();
		$request->getHeaders()->addHeaders(array(
			'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
		));
		$request->setUri("https://recrutement.local-trust.com/test/cards/57187b7c975adeb8520a283c");
		$request->setMethod('GET');
		
		$client = new Client();
		$response = $client->dispatch($request);
		$data = json_decode($response->getBody());
		
	    // Trier les cartes
        $result = $this->sortCards($data);
        // Vérifier si le résultat est exact
		$client = new Client("https://recrutement.local-trust.com/test/".$data->exerciceId);
        $client->setHeaders([
                'Content-Type' => 'application/json',
            ])
            ->setMethod('POST')
            ->setRawBody(json_encode($result));
		
		$res["sortcards"] = json_encode($result);
        $res["codeverif"] = $response->getStatusCode();
		$res["retourverif"] = $response->getBody();
        return new ViewModel(array('reponse'=>$res));
    }
	/*
     * Ordonner les cartes selon la catégorie et la valeur
     * @param $data: donnée JSON des cartes non triées
     * @return array: tableau trié des cartes
    */
    public function sortCards($data)
    {
        $categoryOrder = $data->data->categoryOrder;
        $valueOrder = $data->data->valueOrder;

        $cards = [];
        // Pour chaque carte non ordonnée
        foreach ($data->data->cards as $card) {
            // Récupérer l'ordre de la catégorie et de la valeur selon le tableau d'ordres
            $category = array_search($card->category, $categoryOrder);
            $value = array_search($card->value, $valueOrder);
            // Créer un tableau de 2 dimensions contenant la valeur et l'ordre de la carte
            // Les clés de ce tableau sont la catégorie et la valeur de la carte
            $cards[$category][$value] = ["category" => $card->category, "value" => $card->value];
        }
        // Ordonner le tableau récursivement selon les clés
        $this->ksortRecursive($cards);
        // Transformer le tableau en une seule dimension
        $cards = call_user_func_array("array_merge", $cards);

        $result["cards"] = $cards;
        $result["categoryOrder"] = $categoryOrder;
        $result["valueOrder"] = $valueOrder;

        return $result;
    }

    /*
     * Ordonner un tableau récursivement selon les clés
     * @param $array: tableau à trier
     * @return boolean
    */
    public function ksortRecursive(&$array) {
        if (!is_array($array))
        {
            return false;
        }
        ksort($array);
        foreach ($array as &$arr) {
            $this->ksortRecursive($arr);
        }
        return true;
    }

}

