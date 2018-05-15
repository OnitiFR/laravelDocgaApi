<?php
namespace Oniti\DocgaApi;

/**
*  class pour gérer les intéraction avec docga
*/
class DocgaApi
{
  /**
   * Constructeur
   */
  public function __construct(){
    //Vérifie la présence des variable d'env nécéssaire
    $envs = ['DOCGA_API_URL','DOCGA_API_KEY','DOCGA_API_SECRET'];
    foreach ($envs as $env) {
      if(is_null(env($env))) throw new \Exception("Variable d'environement {$env} non présente");
    }
  }
  /**
   * Appel l'api avec les paramètres passé en argument
   * @param  array  $params   [description]
   * @param  [type] $onlyData [description]
   * @return [type]           [description]
   */
  public function callWithParams(array $params,$onlyData = false){
    $response = $this->call($this->generateUrl('api/list', $params));
    return $onlyData ? $response['data'] : $response;
  }

  /**
  * génère l'url avec les parametres
  * @param  [type] $route  [description]
  * @param  array  $params [description]
  * @return [type]         [description]
  */
  private function generateUrl($route,$params = []){
    $params['api_key'] = env('DOCGA_API_KEY');
    $params['api_sig'] = $this->generateSignature($params);

    ksort($params);

    return env('DOCGA_API_URL').$route.'?'.http_build_query($params);
  }

  /**
   * Fonction d'appel à l'api
   * @param  [type] $url [description]
   * @return [type]      [description]
   */
  public function call($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    $data = curl_exec($ch);
    curl_close($ch);

    $responseDecode = json_decode($data,true);

    if(!is_array($responseDecode) || !array_key_exists('data', $responseDecode)){
      if(is_array($responseDecode) && array_key_exists('message', $responseDecode)) $error = new \Exception($responseDecode['message'], 500);
      else $error = new \Exception("Serveur non joignable", 500);

      throw $error;

    }

    return $responseDecode;
  }
  /**
  * Calcule la signature des parametres
  * @param  [type] $params [description]
  * @return [type]         [description]
  */
  private function generateSignature($params){
    ksort($params);
    $signature = env('DOCGA_API_SECRET');

    foreach ($params as $key => $value) {
      if(is_array($value)){
        $value = 'Array';
      }
      if($key != 'api_sig' && $key != 'source' && !is_null($value)) $signature .= $key.$value;
    }
    return md5($signature);
  }
}
?>
