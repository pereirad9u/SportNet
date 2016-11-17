<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 15/11/16
 * Time: 10:32
 */

namespace App\Controllers;

use App\Models\Epreuves;
use App\Models\Events;
use App\Models\UserEpreuve;
use App\Models\Users;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class EpreuveController
{
    private $view;
    private $logger;
    private $router;

    public function __construct($c)
    {
        $this->view = $c->get('view');
        $this->logger = $c->get('logger');
        $this->router = $c->get('router');
    }

    public function dispatch(Request $request, Response $response, $args) {

        return $this->view->render($response, 'epreuve.twig', []);
    }

    public function creationEpreuve(Request $request, Response $response, $args) {
        return $this->view->render($response, 'creationEpreuve.twig', []);
    }

    public function saveEpreuve(Request $request, Response $response, $args){

        $nbEpreuve = $_POST['nbEpreuve'];
        $nom = filter_var ( $_POST['nom'], FILTER_SANITIZE_STRING );
        $date = $this->modifDate($_POST['date']);
        $description = filter_var ( $_POST['description'], FILTER_SANITIZE_STRING );
        $nbParticipant = filter_var ( $_POST['nbParticipant'], FILTER_SANITIZE_NUMBER_INT );
        $prix = filter_var ( $_POST['nbParticipant'], FILTER_SANITIZE_NUMBER_INT );
        $discipline = filter_var ( $_POST['discipline'], FILTER_SANITIZE_STRING );

        if ($_FILES['image']['name'] != "") {
            $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
            $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
            if (in_array($extension_upload, $extensions_valides)) {
                if ($_FILES['image']['size'] <= 67108864) {
                    $n = uniqid().'.'.$extension_upload;
                    $nom_pic = "images/$n";
                    $pic_r = $_FILES['image']['tmp_name'];
                    $this->resize_image($pic_r, null, 200, 200);
                    $resultat = move_uploaded_file($pic_r, $nom_pic);
                    if ($resultat) {
                    } else {
                        return $this->view->render($response, 'creationEpreuve.twig', ['erreur' => 'Erreur lors de l\'envoye du fichier, merci de recommencer.']);
                    }
                } else {
                    return $this->view->render($response, 'creationEpreuve.twig', ['erreur' => 'Poids du fichier trop important.']);
                }
            } else {
                return $this->view->render($response, 'creationEpreuve.twig', ['erreur' => 'Format de fichier non pris en compte, utiliser un .jpg .png ou .gif.']);
            }
        }

        $epreuve = new Epreuves();
        $epreuve->id = uniqid();
        $epreuve->nom = $nom;
        $epreuve->date = $date;
        $epreuve->description = $description;
        $epreuve->nb_participants_max = $nbParticipant;
        $epreuve->nb_participants = 0;
        $epreuve->prix = $prix;
        $epreuve->inscription = 1;
        $epreuve->id_evenement = $args['id'];
        $epreuve->discipline = $discipline;
        $epreuve->image = $nom_pic;
        $epreuve->save();

        for ($i=1; $i<=$nbEpreuve;$i++){
            $num = $i+1;
            $nom = filter_var ( $_POST['nom'.$num], FILTER_SANITIZE_STRING );
            $date = $this->modifDate($_POST['date'.$num]);
            $description = filter_var ( $_POST['description'.$num], FILTER_SANITIZE_STRING );
            $nbParticipant = filter_var ( $_POST['nbParticipant'.$num], FILTER_SANITIZE_NUMBER_INT );
            $prix = filter_var ( $_POST['nbParticipant'.$num], FILTER_SANITIZE_NUMBER_INT );
            $discipline = filter_var ( $_POST['discipline'.$num], FILTER_SANITIZE_STRING );

            if ($_FILES['image'.$num]['name'] != "") {
                $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                $extension_upload = strtolower(substr(strrchr($_FILES['image'.$num]['name'], '.'), 1));
                if (in_array($extension_upload, $extensions_valides)) {
                    if ($_FILES['image'.$num]['size'] <= 67108864) {
                        $n = uniqid().'.'.$extension_upload;
                        $nom_pic = "images/$n";
                        $pic_r = $_FILES['image'.$num]['tmp_name'];
                        $this->resize_image($pic_r, null, 200, 200);
                        $resultat = move_uploaded_file($pic_r, $nom_pic);
                        if ($resultat) {
                        } else {
                            return $this->view->render($response, 'creationEpreuve.twig', ['erreur' => 'Erreur lors de l\'envoye du fichier, merci de recommencer.']);
                        }
                    } else {
                        return $this->view->render($response, 'creationEpreuve.twig', ['erreur' => 'Poids du fichier trop important.']);
                    }
                } else {
                    return $this->view->render($response, 'creationEpreuve.twig', ['erreur' => 'Format de fichier non pris en compte, utiliser un .jpg .png ou .gif.']);
                }
            }

            $epreuve = new Epreuves();
            $epreuve->id = uniqid();
            $epreuve->nom = $nom;
            $epreuve->date = $date;
            $epreuve->description = $description;
            $epreuve->nb_participants_max = $nbParticipant;
            $epreuve->nb_participants = 0;
            $epreuve->prix = $prix;
            $epreuve->inscription = 1;
            $epreuve->id_evenement = $args['id'];
            $epreuve->discipline = $discipline;
            $epreuve->image = $nom_pic;
            $epreuve->save();
        }

        $event = Events::find($args['id']);
        $event->etat = "ouvert";
        $event->save();
        $url = $this->router->pathfor('anEventOrg',['id' =>$args['id']]);
        return $response->withStatus(302)->withHeader('Location',$url);
    }

    public function participants(Request $request, Response $response, $args){
      $epreuve = Epreuves::find($args['id']);
      $event = Events::find($epreuve->id_evenement);
      $tabUserEpreuve = UserEpreuve::where('id_epreuves','like',$args['id'])->get();
      $tabParticipants = array();
      foreach ($tabUserEpreuve as $u){
        $user = Users::where('id','like',$u->id_users)->first();
        $user->doss = $u->num_dossard;
        array_push($tabParticipants, $user);
      }

      $tab_csv = array(array('Nom','Prénom','Adresse email', 'Téléphone', 'Numéro de dossard'));

      foreach ($tabParticipants as $p) {
        if ($p->telephone != ""){
          $telephone = $p->telephone;
        }else{
          $telephone = 'non transmis';
        }
        array_push($tab_csv,array($p->nom, $p->prenom, $p->email, $telephone, $p->num_dossard));

      }

      $csv = new \SplFileObject('participantscsv/'.$args['id'].'participants.csv', 'w');

      foreach ($tab_csv as $ligne) {
          $csv->fputcsv($ligne, ';');
      }


      return $this->view->render($response,'participants.twig', array( 'event' => $event , 'epreuve'=> $epreuve , 'tabParticipants' => $tabParticipants ));
    }

    private function modifDate($date) {
        $jm = explode(' ', $date);
        $m = explode(',', $jm[1]);
        switch ($m[0]) {
            case "January":
                $m[0] = '01';
                break;
            case "February":
                $m[0] = '02';
                break;
            case "March":
                $m[0] = '03';
                break;
            case "April":
                $m[0] = '04';
                break;
            case "May":
                $m[0] = '05';
                break;
            case "June":
                $m[0] = '06';
                break;
            case "July":
                $m[0] = '07';
                break;
            case "August":
                $m[0] = '08';
                break;
            case "September":
                $m[0] = '09';
                break;
            case "October":
                $m[0] = '10';
                break;
            case "November":
                $m[0] = '11';
                break;
            case "December":
                $m[0] = '12';
                break;
        }
        return "$jm[2]-$m[0]-$jm[0]";
    }


    private function resize_image($file,
                          $string             = null,
                          $width              = 0,
                          $height             = 0,
                          $proportional       = false,
                          $output             = 'file',
                          $delete_original    = true,
                          $use_linux_commands = false,
                          $quality            = 100,
                          $grayscale          = false
    ) {
        if ( $height <= 0 && $width <= 0 ) return false;
        if ( $file === null && $string === null ) return false;
        # Setting defaults and meta
        $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image                        = '';
        $final_width                  = 0;
        $final_height                 = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;
        # Calculating proportionality
        if ($proportional) {
            if      ($width  == 0)  $factor = $height/$height_old;
            elseif  ($height == 0)  $factor = $width/$width_old;
            else                    $factor = min( $width / $width_old, $height / $height_old );
            $final_width  = round( $width_old * $factor );
            $final_height = round( $height_old * $factor );
        }
        else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;
            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }
        # Loading image to memory according to type
        switch ( $info[2] ) {
            case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
            default: return false;
        }
        # Making the image grayscale, if needed
        if ($grayscale) {
            imagefilter($image, IMG_FILTER_GRAYSCALE);
        }
        # This is the resizing/resampling/transparency-preserving magic
        $image_resized = imagecreatetruecolor( $final_width, $final_height );
        if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);
            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color  = imagecolorsforindex($image, $transparency);
                $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            }
            elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
        # Taking care of original, if needed
        if ( $delete_original ) {
            if ( $use_linux_commands ) exec('rm '.$file);
            else @unlink($file);
        }
        # Preparing a method of providing result
        switch ( strtolower($output) ) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }
        # Writing image according to type to the output destination and image quality
        switch ( $info[2] ) {
            case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
            case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int)((0.9*$quality)/10.0);
                imagepng($image_resized, $output, $quality);
                break;
            default: return false;
        }
        return true;
    }


}
