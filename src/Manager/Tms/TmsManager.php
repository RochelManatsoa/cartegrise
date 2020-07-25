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
        1 => ["ESSENCE", "ESSENC","GAZOLE","CARB GAZEUX","ESS+GAZO","FUEL-OIL","GAZOGENE","GAZOLE+GAZO","INCONN","INCONNU"],
        2 => ["G.P.L.", "GAZ NAT.VEH"],
        3 => ["ELECTRIC", "ESS+ELEC HR"],
        4 => ["ELEC+ESSENC", "ELEC+G.P.L.", "ELEC+GAZOLE", "ESS+ELEC HNR", "ESSENCE+HYB", "GAZ+ELEC HNR", "GAZ+ELEC HR", "GAZOL+G.NAT+HYB", "GAZOLE+HYB", "HYDROGENE"],
        5 => ["SUPERETHANOL"],
        6 => ["BICARBUR", "ESS+G.NAT", "ESS+G.P.L."],
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
        $energie = trim(strtoupper($energie));
        // loop all value 
        foreach($this->GENRE as $key=>$value) {
            if (in_array($energie, $value)) {
                // return value coresponding of weight
                return $key;
            }
        }
        // default value
        return 0;
    }
}