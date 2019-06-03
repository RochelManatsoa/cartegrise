<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-27 11:09:21 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-05-27 12:38:35
 */
namespace App\Entity\File;

trait FileTrait
{
    private $fileNames = [
        "declatationCession" => "déclaration de cession",
        "procurationParMandat" => "procuration par mandat",
        "recepisseDemandeAchat" => "Récépissé de la demande d'achat",
    ];

    public function getRealFileName($label): string
    {
        if (isset($this->fileNames[$label]))
            return $this->fileNames[$label];
        return $label;
    }
}
