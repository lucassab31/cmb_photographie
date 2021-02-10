<?php
            function TailleDossier($Rep) {
                $Racine=opendir($Rep);
                $Taille=0;
                while($Dossier = readdir($Racine)) {
                  if ( $Dossier != '..' And $Dossier !='.' ) {
                    //Ajoute la taille du sous dossier
                    if(is_dir($Rep.'/'.$Dossier)) $Taille += TailleDossier($Rep.'/'.$Dossier);
                    //Ajoute la taille du fichier
                    else $Taille += filesize($Rep.'/'.$Dossier);
        
                  }
                }
                closedir($Racine);
                return $Taille;
            }

            echo TailleDossier("img");
        ?>