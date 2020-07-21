<?php  

namespace App\Manager\Tms;


Class TmsManager
{
    public $PTAC = [
        1 => "inférieur à 3,5 t",
        2 => "entre 3,5 et 6 t",
        3 => "entre 6 et 11 t",
        4 => "supérieur à 11 t"
    ];

    public $GENRE = [
        1 => "Véhicule particulier (VP)",
        2 => "Utilitaire (CTTE, Deriv-VP)",
        3 => "Camion, Bus, Tracteur non agricole (CAM, TCP, TRR)",
        4 => "Véhicule spécialisé (VASP)",
        5 => "Moto (MTL, MTT1, MTT2)",
        6 => "Cyclomoteur <= 50cm3 (CL)",
        7 => "Quadricycle à moteur (QM) : voiturette, quad, buggy",
        8 => "Tracteur agricole, quad agricole (TRA)",
        9 => "Remorque, semi-remorque et caravane (REM, SREM, RESP)",
        10 => "Remorque, semi-remorque et caravane (REM, SREM, RESP)" ,
        11 => "Cyclomoteurs carrossés à 3 roues (CYCL)",
    ];

    public $ENERGIE = [
        1 => "Essence ou diesel (gasoil) ‘ES’ / ‘GO’",
        2 => "GPL ou GNV uniquement ‘GP’ / ’GN’",
        3 => "Electricité uniquement ‘EL’",
        4 => [
            "Hybride" => [
                1 => "Electricité – essence ‘EE’", 
                2 => "Electricité – diesel ‘GE’ / ‘OL’", 
                3 => "Electricité – GPL ‘PE’", 
                4 => "Electricité – GNV ‘NE’", 
                5 => "Electricité – Superéthanol ‘FL"
            ]
        ],
        5 => "Bioéthanol E85 ‘FE’",
        6 => [
            "Biocarburant" => [
                1 => "Essence – GPL ‘EG’", 
                2 => "Essence – GNV ‘EN’", 
                3 => "Superéthanol – GPL ‘FG’", 
                4 => "Superéthanol – GNV ‘FN’"
            ]
        ],
    ];
}