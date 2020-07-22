<?php  

namespace App\Manager\Tms;


Class TmsManager
{
    private $PTAC = [
        1 => 3500,
        2 => 6000,
        3 => 11000,
        4 => 1000000
    ];

    private $GENRE = [
        1 => ["VP"],
        2 => ["CTTE", "Deriv-VP"],
        3 => ["CAM", "TCP", "TRR"],
        4 => ["VASP"],
        5 => ["MTL", "MTT1", "MTT2"],
        6 => ["CL"],
        7 => ["QM"],
        8 => ["TRA"],
        9 => ["REM", "SREM", "RESP"],
        10 => ["TM"] ,
        11 => ["CYCL"],
    ];

    private $ENERGIE = [
        1 => ["ESSENCE", "GAZOLE"],
        2 => ["GP", "GN"],
        3 => ["ELECTRIC"],
        4 => ["EE", "GE", "OL", "PE", "NE", "FL"],
        5 => "FE",
        6 => ["EG", "EN", "FG", "FN"],
    ];

    private $TYPE = [
        1 => "VN",
        2 => "CTVO",
        4 => "DUP" 
    ];

    /**
     * funciton to get PTCA of auto
     *
     * @param [type] $poids
     * @return void
     */
    public function getPTCA($poids) {
        // loop all value 
        foreach($this->PTAC as $key=>$value) {
            if ($poids < $value) {
                // return value coresponding of weight
                return $key;
            }
        }
        // default value
        return 1;
    }

    /**
     * funciton to get PTCA of auto
     *
     * @param [type] $poids
     * @return void
     */
    public function getTYPE($type) {
        // loop all value 
        foreach($this->TYPE as $key=>$value) {
            if ($type == $value) {
                // return value coresponding of weight
                return $key;
            }
        }
        // default value
        return 2;
    }


    /**
     * funciton to get GENRE of auto
     *
     * @param [type] $genre string
     * @return void
     */
    public function getGENRE($gender) {
        // loop all value 
        foreach($this->GENRE as $key=>$value) {
            if (in_array($gender, $value)) {
                // return value coresponding of weight
                return $key;
            }
        }
        // default value
        return 1;
    }



    /**
     * funciton to get ENERGIE of auto
     *
     * @param [type] $genre string
     * @return void
     */
    public function getENERGIE($energie) {
        // loop all value 
        foreach($this->$GENRE as $key=>$value) {
            if (in_array($energie, $value)) {
                // return value coresponding of weight
                return $key;
            }
        }
        // default value
        return 1;
    }
}