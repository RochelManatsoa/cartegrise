<?xml version="1.0" encoding="UTF-8"?>
<wsdl:definitions xmlns:tns="https://misiv.intra.misiv.fr/interface.php?v=2"
                  xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
                  xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/" name="TMS_interface_MISIV"
                  targetNamespace="https://misiv.intra.misiv.fr/interface.php?v=2">
    <wsdl:types>
        <xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema" targetNamespace="https://misiv.intra.misiv.fr/interface.php?v=2" version="2">
            
<!-- ******************************************************************************************************************** -->
<!-- *                                         DEFINITION DES TYPES COMMUNS                                             * -->
<!-- ******************************************************************************************************************** -->

<xsd:annotation>
    <xsd:documentation>DEFINITION DU TYPE ECGACHAT</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeECGAchat">
    <xsd:restriction base="xsd:int">
        <xsd:enumeration value="1" /> <!-- Vehicule Neuf -->
        <xsd:enumeration value="2" /> <!-- Vehicule d Occasion Francais -->
        <xsd:enumeration value="3" /> <!-- Vehicule d Occasion Etranger -->
        <xsd:enumeration value="4" /> <!-- Duplicata -->
        <xsd:enumeration value="5" /> <!-- Modification de caractéristique technique -->
    </xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE ECGVEHICULE</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeECGVehicule">
    <xsd:restriction base="xsd:NMTOKEN" >
        <xsd:enumeration value="1" /> <!-- Reception Nationale -->
        <xsd:enumeration value="2" /> <!-- Reception Communautaire -->
    </xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE ECGGENRE</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeECGGenre">
    <xsd:restriction base="xsd:int" >
        <xsd:enumeration value="1" /> <!-- Vehicule particulier (VP) -->
        <xsd:enumeration value="2" /> <!-- Utilitaire (CTTE, Deriv-VP) -->
        <xsd:enumeration value="3" /> <!-- Camion, Bus, Tracteur non agricole (CAM, TCP, TRR) -->
        <xsd:enumeration value="4" /> <!-- Vehicule specialise (VASP) -->
        <xsd:enumeration value="5" /> <!-- Moto (MTL, MTT1, MTT2) -->
        <xsd:enumeration value="6" /> <!-- Cyclomoteur <= 50cm3 (CL) -->
        <xsd:enumeration value="7" /> <!-- Quadricycle a moteur (QM) : voiturette, quad, buggy -->
        <xsd:enumeration value="8" /> <!-- Tracteur agricole, quad agricole (TRA) -->
        <xsd:enumeration value="9" /> <!-- Remorque, semi-remorque et caravane (REM, SREM, RESP) -->
        <xsd:enumeration value="10" /> <!-- Tricycle a moteur (TM) -->
        <xsd:enumeration value="11" /> <!-- Cyclomoteurs carrosses a 3 roues (CYCL) -->
    </xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE ECGENERGIE</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeECGEnergie">
    <xsd:restriction base="xsd:int" >
        <xsd:enumeration value="1" /> <!-- Essence ou diesel (gasoil) "ES" / "GO" -->
        <xsd:enumeration value="2" /> <!-- GPL ou GNV uniquement "GP" / "GN" -->
        <xsd:enumeration value="3" /> <!-- Electricite uniquement "EL" -->
        <xsd:enumeration value="4" /> <!-- Hybride
                                                                                        - Electricite – essence "EE"
                                                                                        - Electricite – diesel "GE" / "OL"
                                                                                        - Electricite – GPL "PE"
                                                                                        - Electricite – GNV "NE"
                                                                                        - Electricite – Superethanol "FL" -->
        <xsd:enumeration value="5" /> <!-- Bioethanol E85 "FE" -->
        <xsd:enumeration value="6" /> <!-- Bicarburation
                                                                                        - Essence – GPL "EG"
                                                                                        - Essence – GNV "EN"
                                                                                        - Superethanol – GPL "FG"
                                                                                        - Superethanol – GNV "FN" -->
    </xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE ECGDEPARTEMENT</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeECGDepartement">
    <xsd:restriction base="xsd:string">
        <xsd:pattern value="0[1-9]|[1-8]\d|2[AB]|9[0-7]|97[0-7]"/>
    </xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE ECGPTAC</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeECGPTAC">
    <xsd:restriction base="xsd:int" >
        <xsd:enumeration value="1" /> <!-- PTAC inferieur a 3,5 t -->
        <xsd:enumeration value="2" /> <!-- PTAC entre 3,5 et 6 t -->
        <xsd:enumeration value="3" /> <!-- PTAC entre 6 et 11 t -->
        <xsd:enumeration value="4" /> <!-- PTAC superieur a 11 t. -->
    </xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
    <xsd:documentation>DEFINITION DU TYPE IMMATRICULATION</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeImmat">
<xsd:restriction base="xsd:string">
    <xsd:minLength value="7" />
    <xsd:maxLength value="12" />
    <!--<xsd:pattern value="(([A-Z]{1,2}(-|\s)?\d{3}(-|\s)?[A-Z]{2})|(\d{1,4}\s?[A-Z]{2}\s?\d(\d|A|B))|(\d{1,3}\s?[A-Z]{2,3}\s?\d(\d|A|B)))" />-->
    <xsd:pattern value="([A-Z]{1,2}(-|\s)?\d{2,3}(-|\s)?[A-Z]{1,2})|(\d{1,4}\s?[A-Z]{2,3}\s?(2[AB]|\d{1,3}))" />
</xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE SIREN</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeSIREN">
<xsd:restriction base="xsd:string">
    <xsd:length value="9" />
    <xsd:pattern value="[0-9]{9}" />
</xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE SIRET</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeSIRET">
<xsd:restriction base="xsd:string">
 	<xsd:minLength value="9"/>
    <xsd:maxLength value="14" />
    <xsd:pattern value="[0-9]{9,14}" />
</xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE VIN</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeVIN">
<xsd:restriction base="xsd:string">
    <xsd:minLength value="1"/>
    <xsd:maxLength value="17"/>
    <xsd:pattern value="[0-9A-Z]*"/>
</xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE MODEEXPEDITION</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="ModeExp">
<xsd:restriction base="xsd:int">
    <xsd:enumeration value="0"/>  <!-- Retrait a l imprimerie nationale -->
    <xsd:enumeration value="1"/>  <!-- Courrier suivi a la societe de location -->
    <xsd:enumeration value="2"/>  <!-- Courrier suivi au locataire longue duree -->
    <xsd:enumeration value="3"/>  <!-- Courrier suivi loueur -->
</xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE TYPELOCATION</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeLoc">
<xsd:restriction base="xsd:NMTOKEN">
    <xsd:enumeration value="LCD"/>  <!-- Location Courte Duree -->
    <xsd:enumeration value="LLD"/>  <!-- Location Longue Duree -->
    <xsd:enumeration value="LCL"/>  <!-- Location Longue Duree a une societe de LCD -->
    <xsd:enumeration value="LCB"/>  <!-- Location en Credit Bail -->
</xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DATE</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeDate">
<xsd:restriction base="xsd:string">
    <xsd:maxLength value="19" />
    <xsd:pattern value="[0-9]{2}/[0-9]{2}/[0-9]{4}(\s([01][0-9]|2[0123])(:[0-5][0-9]){1,2})?" />
</xsd:restriction>
</xsd:simpleType>


        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE CANAL</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeCanal">
<xsd:restriction base="xsd:string">
    <xsd:enumeration value="PRESAISIE"/> <!-- canal de presaisie -->
    <!-- ... autres plus tard ? -->
</xsd:restriction>
</xsd:simpleType>


        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE MOTIFFIV</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="MotifFIV">
<xsd:restriction base="xsd:NMTOKEN">
    <xsd:enumeration value="CT"/>  <!-- controle technique -->
    <xsd:enumeration value="EXP"/>  <!-- export -->
    <xsd:enumeration value="ENC"/>  <!-- encheres -->
    <xsd:enumeration value="AUT"/>   <!-- autre -->
</xsd:restriction>
</xsd:simpleType>


        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE ADRESSE</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeAdresse">
<xsd:sequence>
    <xsd:element name="Numero"  maxOccurs="1"   minOccurs="0" > <!-- ex : 51 -->
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="4"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="ExtensionIndice" maxOccurs="1"   minOccurs="0" > <!-- ex : B -->
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:length value="1"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="TypeVoie"    maxOccurs="1"   minOccurs="1"> <!-- ex : RUE -->
        <xsd:simpleType>
            <xsd:restriction base="xsd:NMTOKEN">
                <xsd:enumeration value="RUE" /> <!-- Rue -->
                <xsd:enumeration value="BLVD" /> <!-- Boulevard -->
                <xsd:enumeration value="AVN" /> <!-- Avenue -->
                <xsd:enumeration value="ALL" /> <!-- Allee -->
                <xsd:enumeration value="PLC" /> <!-- Place -->
                <xsd:enumeration value="IMP" /> <!-- Impasse -->
                <xsd:enumeration value="CHM" /> <!-- Chemin -->
                <xsd:enumeration value="QUAI" /> <!-- Quai -->
                <xsd:enumeration value="FORT" /> <!-- Fort -->
                <xsd:enumeration value="RTE" /> <!-- Route -->
                <xsd:enumeration value="PASS" /> <!-- Passage -->
                <xsd:enumeration value="CHAU" /> <!-- Chaussee  -->
                <xsd:enumeration value="COUR" /> <!-- Cour -->
                <xsd:enumeration value="PARC" /> <!-- Parc -->
                <xsd:enumeration value="FBG" /> <!-- Faubourg -->
                <xsd:enumeration value="LDIT" /> <!-- Lieu-Dit -->
                <xsd:enumeration value="SQUA" /> <!-- Square -->
                <xsd:enumeration value="SENT" /> <!-- Sente -->
                <xsd:enumeration value="SANS" /> <!-- sinon -->
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NomVoie"             type="xsd:string"   maxOccurs="1"   minOccurs="1" /> <!-- ex : Georges Clemenceau -->
    <xsd:element name="LieuDit"             type="xsd:string"   maxOccurs="1"   minOccurs="0" /> <!-- ex : La Roquette -->
    <xsd:element name="EtageEscAppt"        type="xsd:string"   maxOccurs="1"   minOccurs="0" /> <!-- ex : Appartement 115 -->
    <xsd:element name="Complement"          type="xsd:string"   maxOccurs="1"   minOccurs="0" /> <!-- ex : Batiment C -->
    <xsd:element name="BoitePostale"        type="xsd:string"   maxOccurs="1"   minOccurs="0" /> <!-- ex : BP 3056 -->
    <xsd:element name="CodePostal"          maxOccurs="1"   minOccurs="1" > <!-- ex : 75005 -->
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <!--<xsd:pattern value="((0[1-9])|([1-8]\d)|(9[0-7]))\d{3}"/>-->
                <xsd:pattern value="\d{5}"/> <!-- UPDATE: autorise cession étranger convention -->
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Ville"               type="xsd:string"   maxOccurs="1"   minOccurs="1" /> <!-- ex : Paris -->
    <xsd:element name="Pays"                type="xsd:string"   maxOccurs="1"   minOccurs="0" /> <!-- ex : France -->
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE CO-TITULAIRE</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeCotitulaire">
<xsd:sequence>
    <!-- Indicateur pour le cotitulaire principal -->
    <xsd:element name="PremierCotitulaire"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
    <xsd:choice>
        <!-- En cas de personne morale, juste une raison sociale -->
        <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="RaisonSociale"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>

        <!-- En cas de personne physique ...-->
        <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="Nom"         type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Prenom"      type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                        <xsd:simpleType>
                            <xsd:restriction base="xsd:NMTOKEN">
                                <xsd:enumeration value="M" /> <!-- Masculin -->
                                <xsd:enumeration value="F" /> <!-- Feminin -->
                            </xsd:restriction>
                        </xsd:simpleType>
                    </xsd:element>
                    <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                    <xsd:element name="NomUsage"    type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>
    </xsd:choice>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE MOTIF FUD</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="MotifFUD">
<xsd:restriction base="xsd:NMTOKEN">
    <xsd:enumeration value="VENTE"/>  <!-- dans le cas d'une vente CTVO -->
    <xsd:enumeration value="AFFECTATION"/>  <!-- cas d'une reaffectation du vehicule -->
</xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE MOTIF DUP</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="MotifDUP">
<xsd:restriction base="xsd:NMTOKEN">
    <xsd:enumeration value="VOL"/>  <!-- Vol -->
    <xsd:enumeration value="PERT"/>  <!-- Perte -->
    <xsd:enumeration value="DETE"/>  <!-- Détérioré -->
</xsd:restriction>
</xsd:simpleType>
        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE EXPEDITION</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="Expedition">
<xsd:sequence>
    <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
    <xsd:element name="SIRET"           type="tns:TypeSIRET"    maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE CARACTERISTIQUES RECEPTION NATIONALE</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="VehiculeCaracteristiquesNationale">
    <xsd:sequence>
        <xsd:element name="D3_Denomination"     maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:string">
                    <xsd:maxLength value="30"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="F3_MMaxAdmEns"       maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:int">
                    <xsd:totalDigits value="5"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="J_CategorieCE"       maxOccurs="1"   minOccurs="1" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:string">
                    <xsd:maxLength value="15"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="J2_CarrosserieCE"    maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:string">
                    <xsd:maxLength value="2"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="P1_Cyl"              maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:decimal">
                    <xsd:totalDigits value="6" />
                    <xsd:fractionDigits value="1" />
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="P2_PuissKW"          maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:decimal">
                    <xsd:totalDigits value="4" />
                    <xsd:fractionDigits value="1" />
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="P3_Energie"          maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:string">
                    <xsd:maxLength value="2"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="P6_PuissFiscale"     maxOccurs="1"   minOccurs="1" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:int">
                    <xsd:totalDigits value="3"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="Q_RapportPuissMasse" maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:decimal">
                    <xsd:totalDigits value="3" />
                    <xsd:fractionDigits value="2" />
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="S2_NbPlaceDebout"    maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:int">
                    <xsd:totalDigits value="3"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="U1_NiveauSonore"     maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:int">
                    <xsd:totalDigits value="3"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="U2_NbTours"          maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:int">
                    <xsd:totalDigits value="5"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="V7_Co2"              maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:int">
                    <xsd:totalDigits value="3"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="V9_ClasseEnvCE"      maxOccurs="1"   minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:string">
                    <xsd:maxLength value="25"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
    </xsd:sequence>
</xsd:complexType>



        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE VEHICULE NEUF</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeVN">
<xsd:sequence>
    <xsd:element name="WW_Motif"   type="xsd:string" maxOccurs="1" minOccurs="0" />
    <xsd:element name="WW_Justificatifs" type="xsd:boolean" maxOccurs="1" minOccurs="0" />
    <xsd:element name="VIN"         type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="D1_Marque"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="D2_Version"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="80"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:choice>
        <!-- En cas de reception Communautaire ... -->
        <xsd:element name="Communautaire"  maxOccurs="1"   minOccurs="1" >
            <xsd:complexType>
                <xsd:sequence>
                    <!-- ... seul le numero de reception communautaire est obligatoire -->
                    <xsd:element name="K_NumRecepCE"       maxOccurs="1"   minOccurs="1" >
                        <xsd:simpleType>
                            <xsd:restriction base="xsd:string">
                                <xsd:maxLength value="25"/>
                            </xsd:restriction>
                        </xsd:simpleType>
                    </xsd:element>
                    <xsd:element name="DateReception"   type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                    <xsd:element name="D21_CNIT"        maxOccurs="1"   minOccurs="0" >
                        <xsd:simpleType>
                            <xsd:restriction base="xsd:string">
                                <xsd:maxLength value="15"/>
                            </xsd:restriction>
                        </xsd:simpleType>
                    </xsd:element>
                    <xsd:element name="DerivVP" type="xsd:boolean" maxOccurs="1" minOccurs="0" />
                    <xsd:element name="BrideeDebridee" type="xsd:boolean" maxOccurs="1" minOccurs="0" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>

        <!-- En cas de reception Nationale ... -->
        <xsd:element name="Nationale" type="tns:VehiculeCaracteristiquesNationale"  maxOccurs="1"   minOccurs="1" />

    </xsd:choice>
    <!-- Champs Variables -->
    <xsd:element name="F1_MMaxTechAdm"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="F2_MMaxAdmServ"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="G_MMaxAvecAttelage"  maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <!-- Controle de cohérence entre G et G1 (historique COC) -->
    <xsd:element name="G1_PoidsVide"        maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="J1_Genre"            maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="4"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="J3_Carrosserie"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="15"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="S1_NbPlaceAssise"    maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <!-- Champs Variables -->
    <xsd:element name="Z1_Mention1"     maxOccurs="1"   minOccurs="0" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:enumeration value="DEM" /> <!-- Vehicule de demonstration -->
                <xsd:enumeration value="TT" /> <!-- Vehicule en transit temporaire -->
                <xsd:enumeration value="AGR" /> <!-- Vehicule agricole -->
                <xsd:enumeration value="ADM" /> <!-- Vehicule administration civile de l'Etat -->
                <xsd:enumeration value="MIL" /> <!-- Vehicule militaire -->
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Z1_Value"        type="xsd:string" maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NbMentions"      type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Mentions"    maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Mention" maxOccurs="unbounded" minOccurs="0" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Code" maxOccurs="1" minOccurs="1" >
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:string">
                                        <xsd:length value="4"/>
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                            <xsd:element name="Valeur1" type="xsd:string" maxOccurs="1" minOccurs="0" />
                            <xsd:element name="Valeur2" type="xsd:string" maxOccurs="1" minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->
        <!-- Pour les modification de caractéristiques techniques sur la carte grise                                              -->
        <!-- ******************************************************************************************************************** -->
<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE VEHICULE MODIFIE</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeVM">
<xsd:sequence>

    <xsd:element name="VIN"         type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
    <xsd:choice>
        <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
        <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
        <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
        <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
    </xsd:choice>
    <xsd:element name="D1_Marque"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="D2_Version"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="80"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Couleur" type="xsd:string" maxOccurs="1"   minOccurs="0" />
    <xsd:element name="BrideeDebridee" type="xsd:boolean" maxOccurs="1" minOccurs="0" />
    <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="0" />

    <xsd:choice>
        <!-- En cas de reception Communautaire ... -->
        <xsd:element name="Communautaire"  maxOccurs="1"   minOccurs="1" >
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="K_NumRecepCE"       maxOccurs="1"   minOccurs="0" >
                        <xsd:simpleType>
                            <xsd:restriction base="xsd:string">
                                <xsd:maxLength value="25"/>
                            </xsd:restriction>
                        </xsd:simpleType>
                    </xsd:element>
                    <xsd:element name="D21_CNIT"        maxOccurs="1"   minOccurs="0" >
                        <xsd:simpleType>
                            <xsd:restriction base="xsd:string">
                                <xsd:maxLength value="25"/>
                            </xsd:restriction>
                        </xsd:simpleType>
                    </xsd:element>
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>

        <!-- En cas de reception Nationale ... -->
        <xsd:element name="Nationale" type="tns:VehiculeCaracteristiquesNationale"  maxOccurs="1"   minOccurs="1" />

    </xsd:choice>

    <!-- Champs Variables -->
    <xsd:element name="F1_MMaxTechAdm"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="F2_MMaxAdmServ"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="G_MMaxAvecAttelage"  maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>

    <!-- Controle de cohérence entre G et G1 (historique COC) -->
    <xsd:element name="G1_PoidsVide"        maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="J1_Genre"            maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="4"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="J3_Carrosserie"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="15"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="S1_NbPlaceAssise"    maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>

    <!-- Champs Variables -->
    <xsd:element name="Z1_Mention1"     maxOccurs="1"   minOccurs="0" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:enumeration value="DEM" /> <!-- Vehicule de demonstration -->
                <xsd:enumeration value="TT" /> <!-- Vehicule en transit temporaire -->
                <xsd:enumeration value="AGR" /> <!-- Vehicule agricole -->
                <xsd:enumeration value="ADM" /> <!-- Vehicule administration civile de l'Etat -->
                <xsd:enumeration value="MIL" /> <!-- Vehicule militaire -->
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Z1_Value"        type="xsd:string" maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NbMentions"      type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Mentions"    maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Mention" maxOccurs="unbounded" minOccurs="0" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Code" maxOccurs="1" minOccurs="1" >
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:string">
                                        <xsd:length value="4"/>
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                            <xsd:element name="Valeur1" type="xsd:string" maxOccurs="1" minOccurs="0" />
                            <xsd:element name="Valeur2" type="xsd:string" maxOccurs="1" minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>



        <!-- ******************************************************************************************************************** -->
        <!-- Pour les modification de caractéristiques techniques sur la carte grise : uniquement bridage / débridage             -->
        <!-- ******************************************************************************************************************** -->
<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE VEHICULE BRIDE-DEBRIDE</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeVBD">
<xsd:sequence>

    <xsd:element name="VIN"         type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
    <xsd:choice>
        <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
        <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
        <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
        <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
    </xsd:choice>
    <xsd:element name="D1_Marque"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="D2_Version"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="80"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Couleur" type="xsd:string" maxOccurs="1"   minOccurs="0" />

    <xsd:choice>
        <!-- Reception Communautaire ... -->
        <xsd:element name="Communautaire"  maxOccurs="1"   minOccurs="1" >
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="K_NumRecepCE"       maxOccurs="1"   minOccurs="0" >
                        <xsd:simpleType>
                            <xsd:restriction base="xsd:string">
                                <xsd:maxLength value="25"/>
                            </xsd:restriction>
                        </xsd:simpleType>
                    </xsd:element>
                    <xsd:element name="D21_CNIT"        maxOccurs="1"   minOccurs="0" >
                        <xsd:simpleType>
                            <xsd:restriction base="xsd:string">
                                <xsd:maxLength value="25"/>
                            </xsd:restriction>
                        </xsd:simpleType>
                    </xsd:element>
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>

    </xsd:choice>

    <!-- Champs Variables -->
    <xsd:element name="F1_MMaxTechAdm"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="F2_MMaxAdmServ"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="S1_NbPlaceAssise"    maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE CARROSSIER</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeCarrossier">
<xsd:sequence>
    <xsd:element name="Agrement" type="xsd:string" maxOccurs="1" minOccurs="1" />
    <xsd:choice>
        <xsd:element name="RaisonSociale" type="xsd:string" maxOccurs="1" minOccurs="1" />
        <xsd:sequence>
            <xsd:element name="Nom" type="xsd:string" maxOccurs="1" minOccurs="1" />
            <xsd:element name="Prenom" type="xsd:string" maxOccurs="1" minOccurs="1" />
        </xsd:sequence>
    </xsd:choice>
    <xsd:element name="Justificatifs" type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE VEHICULE IMPORTE</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeVI">
<xsd:sequence>
    <xsd:element name="VIN"         type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="D1_Marque"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="D2_Version"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="80"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <!-- Pays d'origine - Doit correspondre au libellé d'un pays dans le référentiel des pays de l'UE -->
    <xsd:element name="PaysOrigine" maxOccurs="1" minOccurs="1">
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="80"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <!-- Numéro d'immatriculation à l'étranger -->
    <xsd:element name="NumImmatOrigine" maxOccurs="1" minOccurs="1">
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="20"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <!-- Date de première immatriculation -->
    <xsd:element name="DatePremiereImmat" type="tns:TypeDate" maxOccurs="1" minOccurs="1" />
    <!-- Certifie la présence des pièces justificatives -->
    <xsd:element name="CertifiePresencePJ" type="xsd:boolean" maxOccurs="1" minOccurs="1" />
    <!-- Certifie la validité du contrôle technique (uniquement si véhicule de plus de 4 ans) -->
    <xsd:element name="CertifieValiditeCT" type="xsd:boolean" maxOccurs="1" minOccurs="1" />
    <!-- Certifie l'absence de vol - Provisoire -->
    <xsd:element name="CertifieAbsenceVol" type="xsd:boolean" maxOccurs="1" minOccurs="1" />
    <!-- Date du dernier contrôle technique -->
    <xsd:element name="DateDernierCT" type="tns:TypeDate" maxOccurs="1" minOccurs="0" />
    <!-- Date du d'échéance du contrôle technique -->
    <xsd:element name="DateEcheanceCT" type="tns:TypeDate" maxOccurs="1" minOccurs="0" />
    <!-- Résultat du contrôle technique -->
    <xsd:element name="ResultatDernierCT"   maxOccurs="1"   minOccurs="0" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:NMTOKEN">
                <xsd:enumeration value="A" /> <!-- Autorisé (Contrôle technique favorable) -->
                <xsd:enumeration value="S" /> <!-- Sursis (Contrôle technique défavorable pour défaillances majeures - soumis à une contre-visite) -->
                <xsd:enumeration value="R" /> <!-- Refusé (Contrôle technique défavorable pour défaillances critiques - soumis à une contre-visite) -->
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Communautaire"  maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <!-- ... seul le numero de reception communautaire est obligatoire -->
                <xsd:element name="K_NumRecepCE"       maxOccurs="1"   minOccurs="1" >
                    <xsd:simpleType>
                        <xsd:restriction base="xsd:string">
                            <xsd:maxLength value="25"/>
                        </xsd:restriction>
                    </xsd:simpleType>
                </xsd:element>
                <xsd:element name="DateReception"   type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="D21_CNIT"        maxOccurs="1"   minOccurs="0" >
                    <xsd:simpleType>
                        <xsd:restriction base="xsd:string">
                            <xsd:maxLength value="15"/>
                        </xsd:restriction>
                    </xsd:simpleType>
                </xsd:element>
                <xsd:element name="DerivVP" type="xsd:boolean" maxOccurs="1" minOccurs="0" />
                <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
    <!-- Champs Variables -->
    <xsd:element name="F1_MMaxTechAdm"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="F2_MMaxAdmServ"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="G_MMaxAvecAttelage"  maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <!-- Controle de cohérence entre G et G1 (historique COC) -->
    <xsd:element name="G1_PoidsVide"        maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="J1_Genre"            maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="4"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="J3_Carrosserie"      maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="15"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="S1_NbPlaceAssise"    maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <!-- Champs Variables -->
    <xsd:element name="Z1_Mention1"     maxOccurs="1"   minOccurs="0" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:enumeration value="DEM" /> <!-- Véhicule de démonstration -->
                <xsd:enumeration value="TT" /> <!-- Véhicule en transit temporaire -->
                <xsd:enumeration value="AGR" /> <!-- Véhicule agricole -->
                <xsd:enumeration value="IT" /> <!-- Véhicule importe en transit -->
                <xsd:enumeration value="ADM" /> <!-- Véhicule Administration civile de l'état -->
                <xsd:enumeration value="MIL" /> <!-- Véhicule militaire -->
                <xsd:enumeration value="GEX" /> <!-- Véhicule ZF Pays de Gex -->
                <xsd:enumeration value="SAV" /> <!-- Véhicule ZF de Haute-Savoie -->
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Z1_Value"        type="xsd:string" maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NbMentions"      type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Mentions"    maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Mention" maxOccurs="unbounded" minOccurs="0" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Code" maxOccurs="1" minOccurs="1" >
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:string">
                                        <xsd:length value="4"/>
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                            <xsd:element name="Valeur1" type="xsd:string" maxOccurs="1" minOccurs="0" />
                            <xsd:element name="Valeur2" type="xsd:string" maxOccurs="1" minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE INFOVEHICULE</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeInfoVehicule">
<xsd:sequence>
    <xsd:element name="Immatriculation"         type="tns:TypeImmat"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="VIN"         type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Carrosserie"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>

    <xsd:element name="CarrosserieCG"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="CO2"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="80"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="ConsoExurb"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:decimal">
                <xsd:totalDigits value="6" />
                <xsd:fractionDigits value="1" />
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="ConsoMixte"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:decimal">
                <xsd:totalDigits value="6" />
                <xsd:fractionDigits value="1" />
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>

    <xsd:element name="ConsoUrb"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:decimal">
                <xsd:totalDigits value="6" />
                <xsd:fractionDigits value="1" />
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Cylindree"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:decimal">
                <xsd:totalDigits value="6" />
                <xsd:fractionDigits value="1" />
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Couleur" type="xsd:string" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="NuanceCouleur" type="xsd:string" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DateMec"  type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DateCG"  type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DateCGPR"  type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Depollution"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:decimal">
                <xsd:totalDigits value="6" />
                <xsd:fractionDigits value="1" />
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Empatement"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="4"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="EmpreinteSol"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="4"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Energie"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Genre"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="GenreCG"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>

    <xsd:element name="Hauteur"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="4"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Largeur"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="4"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Longueur"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="4"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Marque"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="MarqueCarrosserie"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="ModeInjection"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Modele"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="ModeleEtude"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="ModelePRF"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Mouvement"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NSerie"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="17"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NbCylind"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NbDecibels"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NbPlacesAss"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NbMains"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NbPortes"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NbSoupapes"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NbVitesses"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="NbVolumes"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="PoidsVide"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Propulsion"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="50"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>

    <xsd:element name="PTR"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="PuissCh"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="PuissFisc"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="RegmDecibels"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>

    <xsd:element name="StatutImmat"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="2"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="TPBoiteVit"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="10"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="TurboCompr"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="10"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Type"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="20"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="TypeVinCG"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="20"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="Version"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="15"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="VoieAr"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="VoieAv"   maxOccurs="1"   minOccurs="1" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="3"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
    <xsd:element name="CodeMoteur"   maxOccurs="1"   minOccurs="0" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="14"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
        <xsd:element name="PtrPrf"   maxOccurs="1"   minOccurs="0" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="5"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
        <xsd:element name="TypeVarVersPrf"   maxOccurs="1"   minOccurs="0" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:string">
                <xsd:maxLength value="80"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
        <xsd:element name="Prix"   maxOccurs="1"   minOccurs="0" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:decimal">
                <xsd:totalDigits value="11" />
                <xsd:fractionDigits value="2" />
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
        <xsd:element name="PuissanceKW"   maxOccurs="1"   minOccurs="0" >
        <xsd:simpleType>
            <xsd:restriction base="xsd:int">
                <xsd:totalDigits value="8"/>
            </xsd:restriction>
        </xsd:simpleType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->
        <!-- *                                      DEFINITION DE l INFO IMMAT  WEBSERVICE AAA                                           * -->
        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE INFOIMMAT</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="InfoImmat">
<xsd:sequence>

    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" type="tns:TypeInfoVehicule" />
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->
        <!-- *                                      DEFINITION DE l INFO VIN  WEBSERVICE AAA                                           * -->
        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE InfoVIN</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="InfoVIN">
<xsd:sequence>

    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" type="tns:TypeInfoVehicule" />
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->
        <!-- *                                      DEFINITION DES TYPES DEMARCHES VN                                           * -->
        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DIVN</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDIVN">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DIVN" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />

    <xsd:element name="Acquereur"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse" maxOccurs="1" minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="NbCotitulaires"  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Cotitulaires"    maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Cotitulaire" type="tns:TypeCotitulaire" maxOccurs="unbounded" minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    type="tns:TypeVN"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Carrossier"  type="tns:TypeCarrossier" maxOccurs="1" minOccurs="0" />

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic"          type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"   type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"      type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE VNWW</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeVNWW">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="VNWW" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />

    <xsd:element name="Acquereur"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse" maxOccurs="1" minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="NbCotitulaires"  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Cotitulaires"    maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Cotitulaire" type="tns:TypeCotitulaire" maxOccurs="unbounded" minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    type="tns:TypeVN"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Carrossier"  type="tns:TypeCarrossier" maxOccurs="1" minOccurs="0" />

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic"          type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"   type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"      type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE VOWW</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeVOWW">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="VOWW" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />

    <xsd:element name="Acquereur"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse" maxOccurs="1" minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="NbCotitulaires"  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Cotitulaires"    maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Cotitulaire" type="tns:TypeCotitulaire" maxOccurs="unbounded" minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    type="tns:TypeVN"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Carrossier"  type="tns:TypeCarrossier" maxOccurs="1" minOccurs="0" />

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic"          type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"   type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"      type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE PIVO</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypePIVO">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="PIVO" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Acquereur"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse" maxOccurs="1" minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="NbCotitulaires"  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Cotitulaires"    maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Cotitulaire" type="tns:TypeCotitulaire" maxOccurs="unbounded" minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    type="tns:TypeVI"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="0" />

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic"          type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"   type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"      type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE PIVOL</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypePIVOL">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1" fixed="PIVOL" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeLocation"        type="tns:TypeLoc"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ModeExpedition"      type="tns:ModeExp"  maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Acquereur"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
                <xsd:element name="Adresse"         type="tns:TypeAdresse" maxOccurs="1" minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    type="tns:TypeVI"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="0" />

    <xsd:element name="Locataire" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Loueur" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIREN"           maxOccurs="1"   minOccurs="1" >
                    <xsd:simpleType>
                        <xsd:restriction base="xsd:string">
                            <xsd:length value="14" />
                            <xsd:pattern value="[0-9]{14}" />
                        </xsd:restriction>
                    </xsd:simpleType>
                </xsd:element>
                <xsd:element name="Adresse" type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Expedition" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIRET"           type="tns:TypeSIRET"    maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic"          type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"   type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"      type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->
        <!-- *                          DEFINITION DU TYPE MODIFICATION DE CARACTERISTIQUE TECHNIQUE                            * -->
        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE MCT</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeMCT">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="MCT" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <!-- Email du client -->
    <xsd:element name="Email"               type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />

    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIRET est obligatoire si s'il s'agit d'une société commerciale -->
                                <xsd:element name="SIRET"               type="tns:TypeSIRET"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Expedition"      type="tns:Expedition"  maxOccurs="1"   minOccurs="0" />

    <xsd:element name="Vehicule"    type="tns:TypeVM"   maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Carrossier"  type="tns:TypeCarrossier" maxOccurs="1" minOccurs="0" />

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic"          type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"   type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"      type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->
        <!-- *                          DEFINITION DU TYPE BRIDAGE / DEBRIDAGE                                                  * -->
        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE MBD</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeMBD">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="MBD" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />

    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIRET est obligatoire si s'il s'agit d'une société commerciale -->
                                <xsd:element name="SIRET"               type="tns:TypeSIRET"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Expedition"      type="tns:Expedition"  maxOccurs="1"   minOccurs="0" />

    <xsd:element name="Vehicule"    type="tns:TypeVBD"   maxOccurs="1"   minOccurs="1" />

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic"          type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"   type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"      type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->
        <!-- *                                  DEFINITION DES TYPES DEMARCHES LOCATION                                         * -->
        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DIVLN</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDIVLN">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DIVLN" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
    <xsd:element name="TypeLocation"        type="tns:TypeLoc"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ModeExpedition"      type="tns:ModeExp"  maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Acquereur"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse" maxOccurs="1" minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Locataire" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Loueur" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIREN"           maxOccurs="1"   minOccurs="1" >
                    <xsd:simpleType>
                        <xsd:restriction base="xsd:string">
                            <xsd:length value="14" />
                            <xsd:pattern value="[0-9]{14}" />
                        </xsd:restriction>
                    </xsd:simpleType>
                </xsd:element>
                <xsd:element name="Adresse" type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Expedition" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIRET"           type="tns:TypeSIRET"    maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    type="tns:TypeVN"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Carrossier"  type="tns:TypeCarrossier" maxOccurs="1" minOccurs="0" />

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse" maxOccurs="1" minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>


                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic"          type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"   type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"      type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE CTVLO</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeCTVLO">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="CTVLO" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeLocation"        type="tns:TypeLoc"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ModeExpedition"      type="tns:ModeExp"  maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:choice>
                <!-- Soit une personne physique -->
                <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                <!-- Soit une personne morale -->
                <xsd:element name="RaisonSociale"   type="xsd:string" maxOccurs="1" minOccurs="1" />
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Acquereur" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
                            <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                            <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Locataire" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Loueur" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIREN"           maxOccurs="1"   minOccurs="1" >
                    <xsd:simpleType>
                        <xsd:restriction base="xsd:string">
                            <xsd:length value="14" />
                            <xsd:pattern value="[0-9]{14}" />
                        </xsd:restriction>
                    </xsd:simpleType>
                </xsd:element>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Expedition" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIRET"           type="tns:TypeSIRET"    maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />

                <!-- Pour taxe exoneration vehicule pick-up -->
                <xsd:element name="ExonerationPickUp" maxOccurs="1" minOccurs="0" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="1" />
                            <!-- Obligatoire si exoneration pick up -->
                            <xsd:element name="Marque"          type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TypeVariantVersion"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TypeReception" maxOccurs="1" minOccurs="1">
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:NMTOKEN" >
                                        <xsd:enumeration value="N" /> <!-- Reception Nationale -->
                                        <xsd:enumeration value="C" /> <!-- Reception Communautaire -->
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                            <xsd:element name="K_NumRecepCE" maxOccurs="1" minOccurs="1" >
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:string">
                                        <xsd:maxLength value="25"/>
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <!-- Si "CIPresent" est vrai -->
                <xsd:choice>
                    <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                    <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                    <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                    <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                </xsd:choice>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeCO2" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeTotale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE CTLLD</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeCTLLD">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="CTLLD" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeLocation"        type="tns:TypeLoc"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ModeExpedition"      type="tns:ModeExp"  maxOccurs="1"   minOccurs="1" />

    <!-- Titulaire -->
    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string" maxOccurs="1" minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- Nouveau locataire -->
    <xsd:element name="Locataire" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>

                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Loueur" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIREN"           maxOccurs="1"   minOccurs="1" >
                    <xsd:simpleType>
                        <xsd:restriction base="xsd:string">
                            <xsd:length value="14" />
                            <xsd:pattern value="[0-9]{14}" />
                        </xsd:restriction>
                    </xsd:simpleType>
                </xsd:element>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Expedition" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIRET"           type="tns:TypeSIRET"    maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                <!-- Si "CIPresent" est vrai -->
                <xsd:choice>
                    <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                    <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                    <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                    <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                </xsd:choice>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeCO2" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeTotale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->
        <!-- *                                     DEFINITION DES TYPES DEMARCHES DE NEGOCE                                     * -->
        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE CTVO</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeCTVO">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="CTVO" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:choice>
                <!-- Soit une personne physique -->
                <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                <!-- Soit une personne morale -->
                <xsd:element name="RaisonSociale"   type="xsd:string" maxOccurs="1" minOccurs="1" />
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Acquereur" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage"        type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="AdresseMail"     type="xsd:string"       maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Telephone"       type="xsd:string"       maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="NbCotitulaires"  type="xsd:int"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Cotitulaires"    maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Cotitulaire" type="tns:TypeCotitulaire" maxOccurs="unbounded" minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
               <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="ExoPickUp"    type="xsd:boolean"   maxOccurs="1"   minOccurs="0" />
                <!-- Obligatoire si modification technique ou exoneration Pick-Up-->
                <xsd:element name="Marque"          type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DenominationCommerciale"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <!-- Obligatoire si modification technique ou exoneration Pick-Up-->
                <xsd:element name="TypeVariantVersion"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Genre"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DateMEC"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DateAchat"    type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Couleur"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Nuance"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <!-- Si "CIPresent" est vrai -->
                <xsd:choice>
                    <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                    <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                    <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                    <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                </xsd:choice>
                <!-- Pour des modifications de caractéristiques techniques - IRS 7.11.1 -->
                <xsd:element name="ModifTechnique" maxOccurs="1" minOccurs="0" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="TypeReception" maxOccurs="1" minOccurs="1">
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:NMTOKEN" >
                                        <xsd:enumeration value="N" /> <!-- Reception Nationale -->
                                        <xsd:enumeration value="C" /> <!-- Reception Communautaire -->
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                            <!-- Obligatoire si TypeReception = 2 -->
                            <xsd:element name="K_NumRecepCE" maxOccurs="1" minOccurs="0" >
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:string">
                                        <xsd:maxLength value="25"/>
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                            <xsd:element name="BrideeDebridee" type="xsd:boolean" maxOccurs="1" minOccurs="0" />
                            <xsd:element name="D21_CNIT" maxOccurs="1" minOccurs="0" >
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:string">
                                        <xsd:maxLength value="15"/>
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                            <xsd:element name="F1_MMaxTechAdm" maxOccurs="1" minOccurs="0" >
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:int">
                                        <xsd:totalDigits value="5"/>
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                            <xsd:element name="F2_MMaxAdmServ" maxOccurs="1" minOccurs="0" >
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:int">
                                        <xsd:totalDigits value="5"/>
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                            <xsd:element name="S1_NbPlaceAssise" maxOccurs="1" minOccurs="0" >
                                <xsd:simpleType>
                                    <xsd:restriction base="xsd:int">
                                        <xsd:totalDigits value="3"/>
                                    </xsd:restriction>
                                </xsd:simpleType>
                            </xsd:element>
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeCO2" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeTotale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DA</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDA">
<xsd:sequence>
    <xsd:element name="ID"              type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"    type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DA" />
    <xsd:element name="DateAchat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DateDemarche"    type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Titulaire" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:choice>
                <!-- Soit une personne physique -->
                <xsd:element name="NomPrenom"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                <!-- Soit une personne morale -->
                <xsd:element name="RaisonSociale"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
    <xsd:element name="Acquereur" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale" maxOccurs="1" minOccurs="1">
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"   type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique" maxOccurs="1" minOccurs="1">
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage" type="xsd:string"  maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"     type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
                <xsd:element name="AdresseMail"     type="xsd:string"       maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Telephone"       type="xsd:string"       maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Marque"          type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DenominationCommerciale"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="TypeVariantVersion"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Genre"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DateMEC"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Couleur"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Nuance"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <!-- Si "CIPresent" est vrai -->
                <xsd:choice>
                    <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                    <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                    <!-- La date du Certificat d Immatriculation devient obligatoire en cas d immatriculation FNI -->
                    <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                </xsd:choice>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DC</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDC">
<xsd:sequence>
    <xsd:element name="ID"              type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"    type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DC" />
    <xsd:element name="DateCession"     type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DateDemarche"    type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Titulaire"       maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:choice>
                <!-- Soit une personne pysique -->
                <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1"   minOccurs="1" />

                <!-- Soit une personne morale -->
                <xsd:element name="RaisonSociale"   type="xsd:string" maxOccurs="1"   minOccurs="1" />
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
    <xsd:element name="Acquereur" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1" minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1" minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN" maxOccurs="1" minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage" type="xsd:string" maxOccurs="1" minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="AdresseMail"     type="xsd:string"       maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Telephone"       type="xsd:string"       maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Marque"          type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DenominationCommerciale"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="TypeVariantVersion"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Genre"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DateMEC"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DateAchat"    type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Couleur"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Nuance"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <!-- Si "CIPresent" est vrai -->
                <xsd:choice>
                    <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                    <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                    <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                    <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                </xsd:choice>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DSV</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDSV">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DSV" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:choice>
                <!-- Soit une personne physique -->
                <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />
                <!-- Soit une personne morale -->
                <xsd:element name="RaisonSociale"   type="xsd:string" maxOccurs="1" minOccurs="1" />
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                <xsd:element name="NumFormule"      type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                <xsd:element name="DateCI"          type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <!-- La date de Premiere Immatriculation ou de Mise en Circulation est necessaire a l obtention du certificat de non-gage -->
                <xsd:element name="DateMEC"         type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <!-- Une information simple (gage ou non) + le certificat de non gage -->
                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Gage" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE CSAD</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeCSAD">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="CSAD" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                <xsd:element name="NumFormule"      type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                <xsd:element name="DateCI"          type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <!-- Immatriculation + le nom du fichier -->
                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE FIV</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeFIV">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="FIV" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="MotifFIV"            type="tns:MotifFIV" maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                <xsd:element name="NumFormule"      type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                <xsd:element name="DateCI"          type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <!-- Immatriculation + le nom du fichier -->
                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->
        <!-- Demande de duplicata -->

<xsd:annotation>
    <xsd:documentation>DEFINITION DU TYPE DUP</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDUP">
    <xsd:sequence>
        <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
        <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DUP" />
        <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
        <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
        <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
        <!-- ModeExpedition : Obligatoire si usage Administration Civile de l’état ou Militaire ou si location longue durée (LLD ou LCB).
         Iniquement 0, 1 ou 2 pour cette démarche -->
        <xsd:element name="ModeExpedition"      type="tns:ModeExp"  maxOccurs="1"   minOccurs="0" />
        <xsd:element name="MotifDuplicata"      type="tns:MotifDUP"  maxOccurs="1"   minOccurs="1" />
        <!-- CTVOouDC : Dans le cadre d’un changement de titulaire ou d’une cession : obligatoire si le motif est VOL -->
        <xsd:element name="CTVOouDC"            type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
        <!-- DatePerte : si le motif est PERTE -->
        <xsd:element name="DatePerte"           type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />

        <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:choice>
                        <!-- Soit une personne physique -->
                        <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                        <!-- Soit une personne morale -->
                        <xsd:element name="RaisonSociale"   type="xsd:string" maxOccurs="1" minOccurs="1" />

                    </xsd:choice>
                    <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
                    <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                    <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                    <!--<xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />-->
                    <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>

        <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Couleur"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                    <xsd:element name="Nuance"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                    <xsd:choice>
                        <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                        <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                        <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                        <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                    </xsd:choice>
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>

        <xsd:element name="Expedition" maxOccurs="1" minOccurs="0" >
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="SIRET"           type="tns:TypeSIRET"    maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>

        <!-- La reponse Ministere concernant cette demarche -->
        <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
            <xsd:complexType>
                <xsd:choice>
                    <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <!-- Une erreur motivant le refus -->
                                <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:choice>
                                    <!-- sans agrement, un numero de BO -->
                                    <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                    <!-- avec agrement, immatriculation et date d immatriculation -->
                                    <xsd:sequence>
                                        <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                        <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                    </xsd:sequence>
                                </xsd:choice>
                                <!-- Nom du fichier reçu : recepisse -->
                                <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                                <!-- Montants des differentes taxes -->
                                <xsd:element name="TaxeRegionale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="TaxeParafiscale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="TaxeCO2" type="xsd:float" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="TaxeSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="TaxeRedevanceSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="TaxeTotale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
            </xsd:complexType>
        </xsd:element>
    </xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->
        <!-- Demande de duplicata -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DUPVL</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDUPVL">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DUPVL" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <!-- ModeExpedition : Obligatoire si usage Administration Civile de l’état ou Militaire ou si location longue durée (LLD ou LCB).
     Iniquement 0, 1 ou 2 pour cette démarche -->
    <xsd:element name="ModeExpedition"      type="tns:ModeExp"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="MotifDuplicata"      type="tns:MotifDUP"  maxOccurs="1"   minOccurs="1" />
    <!-- CTVOouDC : Dans le cadre d’un changement de titulaire ou d’une cession : obligatoire si le motif est VOL -->
    <xsd:element name="CTVOouDC"            type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <!-- DatePerte : si le motif est PERTE -->
    <xsd:element name="DatePerte"           type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />

    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                    <!-- Soit une personne morale -->
                    <xsd:element name="RaisonSociale"   type="xsd:string" maxOccurs="1" minOccurs="1" />

                </xsd:choice>
                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                <!--<xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />-->
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Couleur"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Nuance"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <xsd:choice>
                    <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                    <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                    <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                    <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                </xsd:choice>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Expedition" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIRET"           type="tns:TypeSIRET"    maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse -->
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeCO2" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeTotale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->
        <!-- *                                 DEFINITION DES TYPES DEMARCHES DE DESTRUCTION                                    * -->
        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DAD</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDAD">
<xsd:sequence>
    <xsd:element name="ID"              type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"    type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DAD" />
    <xsd:element name="DateAchat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DateDemarche"    type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="CertifDest"      type="xsd:boolean" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Titulaire" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:choice>
                <!-- Soit une personne physique -->
                <xsd:element name="NomPrenom"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                <!-- Soit une personne morale -->
                <xsd:element name="RaisonSociale"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
    <xsd:element name="Acquereur" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <xsd:element name="AgrementVHU"     type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />

                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"   type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="1" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage" type="xsd:string"  maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                <!-- Si "CIPresent" est vrai -->
                <xsd:choice>
                    <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                    <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                    <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                    <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                </xsd:choice>
                <xsd:element name="RemiseJustifPropriete"       type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
                <xsd:element name="RemiseDocPreuve"       type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DCD</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDCD">
<xsd:sequence>
    <xsd:element name="ID"              type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"    type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DCD" />
    <xsd:element name="DateCession"     type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DateDemarche"    type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Titulaire"       maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:choice>
                <!-- Soit une personne pysique -->
                <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1"   minOccurs="1" />

                <!-- Soit une personne morale -->
                <xsd:element name="RaisonSociale"   type="xsd:string" maxOccurs="1"   minOccurs="1" />
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
    <xsd:element name="Acquereur" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1" minOccurs="1" />

                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN" maxOccurs="1" minOccurs="1" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="Nom"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Prenom"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <!-- le nom d usage ne sert qu a precise le nom de femme mariee -->
                                <xsd:element name="NomUsage" type="xsd:string" maxOccurs="1" minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DID</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDID">
<xsd:sequence>
    <xsd:element name="ID"              type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"    type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DID" />
    <xsd:element name="DateDemarche"    type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="CertifDest"      type="xsd:boolean" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Titulaire" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="NomPrenom"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                    <!-- Soit une personne morale -->
                    <xsd:element name="RaisonSociale"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                </xsd:choice>
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="AgrementVHU" type="xsd:string"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE ECG</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeECG">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="ECG" />

    <xsd:choice>

        <xsd:element name="TypeECG" type="tns:TypeDemarcheECG"    maxOccurs="1" minOccurs="0" />

        <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="0" >
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="VIN"             type="tns:TypeVIN"      maxOccurs="1"   minOccurs="0" />
                    <xsd:element name="Immatriculation" type="tns:TypeImmat"    maxOccurs="1"   minOccurs="0" />

                    <xsd:element name="TypeVehicule"    type="tns:TypeECGVehicule" maxOccurs="1"   minOccurs="1" />

                    <xsd:element name="CO2"             type="xsd:int"          maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Puissance"       type="xsd:int"          maxOccurs="1"   minOccurs="1" />

                    <xsd:element name="Genre"           type="tns:TypeECGGenre" maxOccurs="1"   minOccurs="1" />

                    <xsd:element name="PTAC"            type="tns:TypeECGPTAC"  maxOccurs="1"   minOccurs="1" />

                    <xsd:element name="Energie"         type="tns:TypeECGEnergie" maxOccurs="1"   minOccurs="1" />

                    <xsd:element name="DateMEC"         type="tns:TypeDate"     maxOccurs="1"   minOccurs="0" />
                    <xsd:element name="Collection"      type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Departement"     type="tns:TypeECGDepartement" maxOccurs="1"   minOccurs="1" />

                    <xsd:element name="TypeAchat"       type="tns:TypeECGAchat" maxOccurs="1"   minOccurs="1" />

                    <xsd:element name="PremiereImmat"   type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />

<!--                    <xsd:element name="ModifCTenergiePropre"   type="xsd:boolean"      maxOccurs="1"   minOccurs="0" />-->

                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>

    </xsd:choice>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"    type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Taxe35cv"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale"  type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"          type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeMalus"        type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"          type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"       type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE ECG AUTO</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeECGAUTO">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="ECGAUTO" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Immatriculation" type="tns:TypeImmat"    maxOccurs="1"   minOccurs="1" />
                <xsd:element name="TypeVehicule"    type="tns:TypeECGVehicule" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Departement"     type="tns:TypeECGDepartement" maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Collection"      type="xsd:boolean"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="TypeAchat"       type="tns:TypeECGAchat" maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <!-- Une erreur motivant le refus -->
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"      type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="Code"        type="xsd:int"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="VIN"         type="tns:TypeVIN"      maxOccurs="1"   minOccurs="0" />
                            <xsd:element name="CO2"         type="xsd:int"          maxOccurs="1"   minOccurs="0" />
                            <xsd:element name="Puissance"   type="xsd:int"          maxOccurs="1"   minOccurs="0" />
                            <xsd:element name="Genre"       type="tns:TypeECGGenre" maxOccurs="1"   minOccurs="0" />
                            <xsd:element name="PTAC"        type="tns:TypeECGPTAC"  maxOccurs="1"   minOccurs="0" />
                            <xsd:element name="Energie"     type="tns:TypeECGEnergie" maxOccurs="1"   minOccurs="0" />
                            <xsd:element name="DateMEC"     type="tns:TypeDate"     maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale"    type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Taxe35cv"         type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeParafiscale"  type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeCO2"          type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeMalus"        type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeSIV"          type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="TaxeTotale"       type="xsd:float"    maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="VIN"              type="tns:TypeVIN"      maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="CO2"              type="xsd:int"          maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Puissance"        type="xsd:int"          maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Genre"            type="tns:TypeECGGenre" maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="PTAC"             type="tns:TypeECGPTAC"  maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Energie"          type="tns:TypeECGEnergie" maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="DateMEC"          type="tns:TypeDate"     maxOccurs="1"   minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>




        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE FUD</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeFUD">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="FUD" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Motif"               type="tns:MotifFUD" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="CertifReglement"     type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                    <!-- Soit une personne morale -->
                    <xsd:element name="RaisonSociale"   type="xsd:string" maxOccurs="1" minOccurs="1" />
                </xsd:choice>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
    <!-- La reponse Ministere concernant cette demarche -->

    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeCO2" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeTotale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>


</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->


<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DCAL</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDCAL">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DCAL" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="NumPortable"         type="xsd:string"   maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="TypeLocation"        type="tns:TypeLoc"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ModeExpedition"      type="tns:ModeExp"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:choice>
                <!-- Soit une personne physique -->
                <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                <!-- Soit une personne morale -->
                <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Locataire" maxOccurs="1" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />

                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <!-- Le SIREN devient obligatoire si "SocieteCommerciale" est vrai -->
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>


    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:choice>
                    <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                    <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                    <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                    <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                </xsd:choice>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse ou CPI -->
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeCO2" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeTotale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->


<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DCA</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDCA">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="DCA" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="NomNaissance"    type="xsd:string" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="Prenom"          type="xsd:string" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <xsd:element name="NomUsage"    type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SocieteCommerciale"  type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SIREN"               type="tns:TypeSIREN"   maxOccurs="1"   minOccurs="0" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="AdresseMail"             type="xsd:string"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Telephone"               type="xsd:string"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="TelephonePortable"       type="xsd:string"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="AncienneAdresse"         type="tns:TypeAdresse" maxOccurs="1" minOccurs="1" />
                <xsd:element name="NouvelleAdresse"         type="tns:TypeAdresse" maxOccurs="1" minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Marque"          type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DenominationCommerciale"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="TypeVariantVersion"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Genre"     type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DateMEC"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="DateAchat"    type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Couleur"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Nuance"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                <xsd:choice>
                    <!-- Le numero de formule devient obligatoire en cas d immatriculation SIV -->
                    <xsd:element name="NumFormule"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                    <!-- La date du Certificat d Immatricualtion devient obligatoire en cas d immatriculation FNI -->
                    <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                </xsd:choice>
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse -->
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeCO2" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeTotale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>




        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE CONVERSION FNI</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeFNI">
<xsd:sequence>
    <xsd:element name="ID"                  type="xsd:int"      maxOccurs="1"   minOccurs="0" />
    <xsd:element name="TypeDemarche"        type="xsd:string"   maxOccurs="1"   minOccurs="1"   fixed="FNI" />
    <xsd:element name="PaiementCBClient"    type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="EmissionBO"          type="xsd:boolean"  maxOccurs="1"   minOccurs="0" />
    <xsd:element name="DateDemarche"        type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Titulaire"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:choice>
                    <!-- Soit une personne physique -->
                    <xsd:element name="PersonnePhysique"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="NomPrenom"       type="xsd:string" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="NomNaissance"    type="xsd:string" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="Prenom"          type="xsd:string" maxOccurs="1" minOccurs="1" />
                                <xsd:element name="Sexe"    maxOccurs="1"   minOccurs="1" >
                                    <xsd:simpleType>
                                        <xsd:restriction base="xsd:NMTOKEN">
                                            <xsd:enumeration value="M" /> <!-- Masculin -->
                                            <xsd:enumeration value="F" /> <!-- Feminin -->
                                        </xsd:restriction>
                                    </xsd:simpleType>
                                </xsd:element>
                                <xsd:element name="NomUsage"    type="xsd:string"   maxOccurs="1"   minOccurs="0" />
                                <xsd:element name="DateNaissance"   type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="LieuNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:choice>
                                    <!-- En cas de naissance en france, le departement de naissance -->
                                    <xsd:element name="DepNaissance"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                    <!-- En cas de naissance a l etranger, le pays de naissance -->
                                    <xsd:element name="PaysNaissance"   type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                </xsd:choice>
                                <xsd:element name="DroitOpposition" type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                    <!-- Soit une personne morale -->
                    <xsd:element name="PersonneMorale"  maxOccurs="1"   minOccurs="1" >
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="RaisonSociale"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                                <xsd:element name="SIRET"               type="tns:TypeSIRET"   maxOccurs="1"   minOccurs="1" />
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>
                </xsd:choice>
                <xsd:element name="Telephone"               type="xsd:string"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Adresse"         type="tns:TypeAdresse" maxOccurs="1" minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!--<xsd:element name="NbCotitulaires"  type="xsd:int"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Cotitulaires"    maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Cotitulaire" type="tns:TypeCotitulaire" maxOccurs="unbounded" minOccurs="0" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>-->

    <xsd:element name="Expedition" maxOccurs="1" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="RaisonSociale"   type="xsd:string"       maxOccurs="1"   minOccurs="1" />
                <xsd:element name="SIRET"           type="tns:TypeSIRET"    maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Adresse"         type="tns:TypeAdresse"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="DroitOpposition" type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <xsd:element name="Vehicule"    maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"  maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"   maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Couleur"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                 <xsd:element name="DateCI"      type="tns:TypeDate" maxOccurs="1"   minOccurs="0" />
                <xsd:element name="CIPresent"       type="xsd:boolean"  maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>

    <!-- La reponse Ministere concernant cette demarche -->
    <xsd:element name="Reponse"     maxOccurs="1"   minOccurs="0">
        <xsd:complexType>
            <xsd:choice>
                <xsd:element name="Negative"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <!-- Une erreur motivant le refus -->
                            <xsd:element name="Erreur"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
                            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>

                <xsd:element name="Positive"  maxOccurs="1"   minOccurs="1" >
                    <xsd:complexType>
                        <xsd:sequence>
                            <xsd:choice>
                                <!-- sans agrement, un numero de BO -->
                                <xsd:element name="NumBO" type="xsd:string" maxOccurs="1" minOccurs="1" />

                                <!-- avec agrement, immatriculation et date d immatriculation -->
                                <xsd:sequence>
                                    <xsd:element name="Immatriculation" type="tns:TypeImmat" nillable="true"  maxOccurs="1"   minOccurs="1" />
                                    <xsd:element name="DateImmat"       type="tns:TypeDate" maxOccurs="1"   minOccurs="1" />
                                </xsd:sequence>
                            </xsd:choice>
                            <!-- Nom du fichier reçu : recepisse -->
                            <xsd:element name="NomFic" type="xsd:string" maxOccurs="1" minOccurs="1" />
                            <!-- Montants des differentes taxes -->
                            <xsd:element name="TaxeRegionale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeParafiscale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeCO2" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeRedevanceSIV" type="xsd:float" maxOccurs="1" minOccurs="1" />
                            <xsd:element name="TaxeTotale" type="xsd:float" maxOccurs="1" minOccurs="1" />
                        </xsd:sequence>
                    </xsd:complexType>
                </xsd:element>
            </xsd:choice>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->


<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DEMARCHE</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDemarche">
<xsd:choice>
    <xsd:element name="DIVN"    type="tns:TypeDIVN"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="VNWW"    type="tns:TypeVNWW"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="VOWW"    type="tns:TypeVOWW"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="PIVO"    type="tns:TypePIVO"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="PIVOL"   type="tns:TypePIVOL"     maxOccurs="1"   minOccurs="1" />

    <xsd:element name="CTVO"    type="tns:TypeCTVO"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DA"      type="tns:TypeDA"       maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DC"      type="tns:TypeDC"       maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DSV"     type="tns:TypeDSV"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ECG"     type="tns:TypeECG"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="ECGAUTO" type="tns:TypeECGAUTO"  maxOccurs="1"   minOccurs="1" />
    <xsd:element name="FUD"     type="tns:TypeFUD"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DCAL"    type="tns:TypeDCAL"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DCA"     type="tns:TypeDCA"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DIVLN"   type="tns:TypeDIVLN"    maxOccurs="1"   minOccurs="1" />
    <xsd:element name="CTVLO"   type="tns:TypeCTVLO"    maxOccurs="1"   minOccurs="1" />
    <xsd:element name="CTLLD"   type="tns:TypeCTLLD"    maxOccurs="1"   minOccurs="1" />

    <xsd:element name="DAD"      type="tns:TypeDAD"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DCD"      type="tns:TypeDCD"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DID"      type="tns:TypeDID"     maxOccurs="1"   minOccurs="1" />

    <xsd:element name="FIV"     type="tns:TypeFIV"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="CSAD"    type="tns:TypeCSAD"     maxOccurs="1"   minOccurs="1" />

    <xsd:element name="DUP"     type="tns:TypeDUP"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DUPVL"   type="tns:TypeDUPVL"    maxOccurs="1"   minOccurs="1" />

    <xsd:element name="FNI"   type="tns:TypeFNI"    maxOccurs="1"   minOccurs="1" />

    <xsd:element name="MCT"     type="tns:TypeMCT"    maxOccurs="1"   minOccurs="1" />
    <xsd:element name="MBD"     type="tns:TypeMBD"    maxOccurs="1"   minOccurs="1" />

    </xsd:choice>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->


<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DEMARCHE POUR LES EDITIONS</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDemarcheEdition">
<xsd:choice>
    <xsd:element name="CTVO"    type="tns:TypeCTVO"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="CTVLO"   type="tns:TypeCTVLO"    maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DA"      type="tns:TypeDA"       maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DC"      type="tns:TypeDC"       maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DCA"     type="tns:TypeDCA"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DCAL"    type="tns:TypeDCAL"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DIVN"    type="tns:TypeDIVN"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DIVLN"   type="tns:TypeDIVLN"    maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DUP"     type="tns:TypeDUP"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="DUPVL"   type="tns:TypeDUPVL"    maxOccurs="1"   minOccurs="1" />
    <xsd:element name="PIVO"    type="tns:TypePIVO"     maxOccurs="1"   minOccurs="1" />
    <xsd:element name="PIVOL"   type="tns:TypePIVOL"    maxOccurs="1"   minOccurs="1" />
    <xsd:element name="MCT"     type="tns:TypeMCT"      maxOccurs="1"   minOccurs="1" />
    <xsd:element name="MBD"     type="tns:TypeMBD"      maxOccurs="1"   minOccurs="1" />
</xsd:choice>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->


<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DEMARCHE POUR LES ECG</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeDemarcheECG">
    <xsd:sequence>
        <xsd:choice>
            <xsd:element name="VOF"         type="tns:TypeEcgVOF"           maxOccurs="1"   minOccurs="1" /> <!-- Vehicule d Occasion Francais -->
            <xsd:element name="VOI"         type="tns:TypeEcgVOI"           maxOccurs="1"   minOccurs="1" /> <!-- Vehicule d Occasion Etranger -->
            <xsd:element name="VN"          type="tns:TypeEcgVN"            maxOccurs="1"   minOccurs="1" /> <!-- Vehicule Neuf -->
            <xsd:element name="DUP"         type="tns:TypeEcgDuplicata"     maxOccurs="1"   minOccurs="1" /> <!-- Duplicata -->
            <xsd:element name="MCT"         type="tns:TypeEcgMCT"           maxOccurs="1"   minOccurs="1" /> <!-- Modification de Caractéristique Techique -->
        </xsd:choice>
    </xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE TypeEcgVOI</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeEcgVOI">
<xsd:sequence>
    <xsd:element name="Vehicule"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"    maxOccurs="1"   minOccurs="0" />

                <xsd:element name="TypeVehicule"    type="tns:TypeECGVehicule" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="CO2"             type="xsd:int"          maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Puissance"       type="xsd:int"          maxOccurs="1"   minOccurs="1" />

                <xsd:element name="Genre"           type="tns:TypeECGGenre" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="PTAC"            type="tns:TypeECGPTAC"  maxOccurs="1"   minOccurs="1" />

                <xsd:element name="Energie"         type="tns:TypeECGEnergie" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="DateMEC"         type="tns:TypeDate"     maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Collection"      type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Departement"     type="tns:TypeECGDepartement" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="PremiereImmat"   type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />

</xsd:sequence>
        </xsd:complexType>
        </xsd:element>
        </xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE TypeEcgVOF</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeEcgVOF">
<xsd:sequence>
    <xsd:element name="Vehicule"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"    maxOccurs="1"   minOccurs="0" />

                <xsd:element name="TypeVehicule"    type="tns:TypeECGVehicule" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="CO2"             type="xsd:int"          maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Puissance"       type="xsd:int"          maxOccurs="1"   minOccurs="1" />

                <xsd:element name="Genre"           type="tns:TypeECGGenre" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="PTAC"            type="tns:TypeECGPTAC"  maxOccurs="1"   minOccurs="1" />

                <xsd:element name="Energie"         type="tns:TypeECGEnergie" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="DateMEC"         type="tns:TypeDate"     maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Collection"      type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Departement"     type="tns:TypeECGDepartement" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="PremiereImmat"   type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />

            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>


        <!-- ******************************************************************************************************************** -->
<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE TypeEcgVN</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeEcgVN">
<xsd:sequence>
    <xsd:element name="Vehicule"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"    maxOccurs="1"   minOccurs="0" />

                <xsd:element name="TypeVehicule"    type="tns:TypeECGVehicule" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="CO2"             type="xsd:int"          maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Puissance"       type="xsd:int"          maxOccurs="1"   minOccurs="1" />

                <xsd:element name="Genre"           type="tns:TypeECGGenre" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="PTAC"            type="tns:TypeECGPTAC"  maxOccurs="1"   minOccurs="1" />

                <xsd:element name="Energie"         type="tns:TypeECGEnergie" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="DateMEC"         type="tns:TypeDate"     maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Collection"      type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Departement"     type="tns:TypeECGDepartement" maxOccurs="1"   minOccurs="1" />

                <xsd:element name="PremiereImmat"   type="xsd:boolean"      maxOccurs="1"   minOccurs="1" />

            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE TypeEcgDuplicata</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeEcgDuplicata">
    <xsd:sequence>
        <xsd:element name="Vehicule"   maxOccurs="1"   minOccurs="1" >
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="VIN"             type="tns:TypeVIN"      maxOccurs="1"   minOccurs="0" />
                    <xsd:element name="Immatriculation" type="tns:TypeImmat"    maxOccurs="1"   minOccurs="0" />
                    <xsd:element name="Puissance"       type="xsd:int"          maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Genre"           type="tns:TypeECGGenre" maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Energie"         type="tns:TypeECGEnergie" maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="DateMEC"         type="tns:TypeDate"     maxOccurs="1"   minOccurs="1" />
                    <xsd:element name="Departement"     type="tns:TypeECGDepartement" maxOccurs="1"   minOccurs="1" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>
    </xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE TypeEcgMCT</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeEcgMCT">
<xsd:sequence>
    <xsd:element name="Vehicule"   maxOccurs="1"   minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="VIN"             type="tns:TypeVIN"      maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Immatriculation" type="tns:TypeImmat"    maxOccurs="1"   minOccurs="0" />
                <xsd:element name="Genre"           type="tns:TypeECGGenre" maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Energie"         type="tns:TypeECGEnergie" maxOccurs="1"   minOccurs="1" />
                <xsd:element name="Departement"     type="tns:TypeECGDepartement" maxOccurs="1"   minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DE DOCUMENT</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeDocument">
<xsd:restriction base="xsd:NMTOKEN">
    <xsd:enumeration value="Mandat"/>
    <xsd:enumeration value="Cerfa"/>
    <xsd:enumeration value="DeclarationPerteVol"/>
</xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE FICHIERS UPLOAD</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeFichiersUpload">
<xsd:sequence>
    <xsd:element name="Fichier" maxOccurs="unbounded" minOccurs="1" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Nom" type="xsd:string" maxOccurs="1" minOccurs="1" />
                <xsd:element name="Contenu" type="xsd:string" maxOccurs="1" minOccurs="1" />
                <xsd:element name="TypePiece" type="tns:TypePiece" maxOccurs="1" minOccurs="1" />
                <xsd:element name="TypePieceDetail" type="tns:TypePieceDetail" maxOccurs="unbounded" minOccurs="0" />
                <xsd:element name="Archivage" type="tns:TypeArchivage" maxOccurs="1" minOccurs="1" default="CFN" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE FICHIERS LIST</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeFichiersList">
<xsd:sequence>
    <xsd:element name="Fichier" maxOccurs="unbounded" minOccurs="0" >
        <xsd:complexType>
            <xsd:sequence>
                <xsd:element name="Nom" type="xsd:string" maxOccurs="1" minOccurs="1" />
                <xsd:element name="Date" type="tns:TypeDate" maxOccurs="1" minOccurs="1" />
                <xsd:element name="TypePiece" type="tns:TypePiece" maxOccurs="1" minOccurs="1" />
                <xsd:element name="TypePieceDetail" type="tns:TypePieceDetail" maxOccurs="unbounded" minOccurs="0" />
                <xsd:element name="Archivage" type="tns:TypeArchivage" maxOccurs="1" minOccurs="1" />
            </xsd:sequence>
        </xsd:complexType>
    </xsd:element>
</xsd:sequence>
</xsd:complexType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DE PIECES</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypePiece">
    <xsd:restriction base="xsd:NMTOKEN">
        <xsd:enumeration value="MULTI"/>
        <xsd:enumeration value="DQ"/>
        <xsd:enumeration value="AA"/>
        <xsd:enumeration value="AE"/>
        <xsd:enumeration value="AN"/>
        <xsd:enumeration value="AR"/>
        <xsd:enumeration value="AU"/>
        <xsd:enumeration value="CA"/>
        <xsd:enumeration value="CC"/>
        <xsd:enumeration value="CG"/>
        <xsd:enumeration value="CI"/>
        <xsd:enumeration value="CP"/>
        <xsd:enumeration value="CS"/>
        <xsd:enumeration value="CT"/>
        <xsd:enumeration value="DA"/>
        <xsd:enumeration value="DC"/>
        <xsd:enumeration value="DI"/>
        <xsd:enumeration value="DV"/>
        <xsd:enumeration value="FA"/>
        <xsd:enumeration value="FI"/>
        <xsd:enumeration value="JD"/>
        <xsd:enumeration value="JF"/>
        <xsd:enumeration value="KB"/>
        <xsd:enumeration value="MA"/>
        <xsd:enumeration value="OD"/>
        <xsd:enumeration value="PC"/>
        <xsd:enumeration value="PI"/>
        <xsd:enumeration value="PV"/>
        <xsd:enumeration value="RC"/>
        <xsd:enumeration value="RT"/>
    </xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE DE PIECES DETAIL</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypePieceDetail">
    <xsd:restriction base="xsd:NMTOKEN">
        <xsd:enumeration value="AA"/>
        <xsd:enumeration value="AE"/>
        <xsd:enumeration value="AN"/>
        <xsd:enumeration value="AR"/>
        <xsd:enumeration value="AU"/>
        <xsd:enumeration value="CA"/>
        <xsd:enumeration value="CC"/>
        <xsd:enumeration value="CG"/>
        <xsd:enumeration value="CI"/>
        <xsd:enumeration value="CP"/>
        <xsd:enumeration value="CS"/>
        <xsd:enumeration value="CT"/>
        <xsd:enumeration value="DA"/>
        <xsd:enumeration value="DC"/>
        <xsd:enumeration value="DI"/>
        <xsd:enumeration value="DV"/>
        <xsd:enumeration value="FA"/>
        <xsd:enumeration value="FI"/>
        <xsd:enumeration value="JD"/>
        <xsd:enumeration value="JF"/>
        <xsd:enumeration value="KB"/>
        <xsd:enumeration value="MA"/>
        <xsd:enumeration value="OD"/>
        <xsd:enumeration value="PC"/>
        <xsd:enumeration value="PI"/>
        <xsd:enumeration value="PV"/>
        <xsd:enumeration value="RC"/>
        <xsd:enumeration value="RT"/>
    </xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:annotation>
<xsd:documentation>DEFINITION DU TYPE D ARCHIVAGE</xsd:documentation>
</xsd:annotation>
<xsd:simpleType name="TypeArchivage">
<xsd:restriction base="xsd:NMTOKEN">
    <!-- Coffre Fort Numérique -->
    <xsd:enumeration value="CFN"/>
    <!-- Autres à venir -->
</xsd:restriction>
</xsd:simpleType>

        <!-- ******************************************************************************************************************** -->

<xsd:element name="InfoImmat_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification"  type="tns:TypeIdentification"   maxOccurs="1"   minOccurs="1" />
        <xsd:element name="Immatriculation" type="tns:TypeImmat"            maxOccurs="1"   minOccurs="1" />
        <xsd:element name="ModeString" type="xsd:boolean"      maxOccurs="1"   minOccurs="0" />
        <xsd:element name="Origine" type="xsd:string" maxOccurs="1" minOccurs="0" />
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="InfoImmat_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:element name="InfoVehicule" type="tns:InfoImmat"    maxOccurs="1" minOccurs="1" />
        <xsd:sequence>
            <xsd:element name="Erreur"    type="xsd:string" maxOccurs="1"   minOccurs="1" />
            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>

        <!-- ******************************************************************************************************************** -->

<xsd:element name="InfoVIN_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification"  type="tns:TypeIdentification"   maxOccurs="1"   minOccurs="1" />
        <xsd:element name="VIN" type="tns:TypeVIN"            maxOccurs="1"   minOccurs="1" />
        <xsd:element name="ModeString" type="xsd:boolean"      maxOccurs="1"   minOccurs="0" />
        <xsd:element name="Origine" type="xsd:string" maxOccurs="1" minOccurs="0" />
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="InfoVIN_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:element name="InfoVehicule" type="tns:InfoVIN"    maxOccurs="1" minOccurs="1" />
        <xsd:sequence>
            <xsd:element name="Erreur"    type="xsd:string" maxOccurs="1"   minOccurs="1" />
            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>

        <!-- ******************************************************************************************************************** -->

<xsd:element name="Editer_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification"  type="tns:TypeIdentification"   maxOccurs="1"   minOccurs="1" />
        <xsd:element name="Type" type="tns:TypeDocument" maxOccurs="1" minOccurs="1" />
        <xsd:element name="Demarche" type="tns:TypeDemarcheEdition" maxOccurs="1" minOccurs="1" />
        <xsd:element name="Origine" type="xsd:string" maxOccurs="1" minOccurs="0" />
        <xsd:element name="Canal" type="tns:TypeCanal" maxOccurs="1" minOccurs="0" />
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="Editer_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:element name="Document" type="xsd:string"    maxOccurs="1" minOccurs="0" />
        <xsd:sequence>
            <xsd:element name="Erreur"    type="xsd:string" maxOccurs="1"   minOccurs="1" />
            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>

        <!-- ******************************************************************************************************************** -->

<xsd:element name="Chercher_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification"  type="tns:TypeIdentification"   maxOccurs="1"   minOccurs="1" />
        <xsd:element name="Immatriculation" type="tns:TypeImmat"            maxOccurs="1"   minOccurs="0" />
        <xsd:element name="TypeDemarche"    type="xsd:string"               maxOccurs="1"   minOccurs="1" />
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="Chercher_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:element name="Lot" maxOccurs="1"   minOccurs="0">
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="Demarche" type="tns:TypeDemarche"    maxOccurs="unbounded" minOccurs="1" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>
        <xsd:sequence>
            <xsd:element name="Erreur"    type="xsd:string" maxOccurs="1"   minOccurs="1" />
            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>
        <!-- ******************************************************************************************************************** -->

<xsd:element name="Ouvrir_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification"  type="tns:TypeIdentification"   maxOccurs="1"   minOccurs="1" />
        <xsd:element name="IDDemarche"      type="xsd:int"                  maxOccurs="1"   minOccurs="1" />
        <xsd:element name="TypeDemarche"    type="xsd:string"               maxOccurs="1"   minOccurs="1" />
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="Ouvrir_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:element name="Demarche"  type="tns:TypeDemarche"   maxOccurs="1"   minOccurs="1" />
        <xsd:sequence>
            <xsd:element name="Erreur"    type="xsd:string" maxOccurs="1"   minOccurs="1" />
            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>

        <!-- ******************************************************************************************************************** -->

<xsd:element name="Sauver_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification"  type="tns:TypeIdentification"   maxOccurs="1"   minOccurs="1" />
        <xsd:element name="Lot" maxOccurs="1"   minOccurs="0">
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="Demarche" type="tns:TypeDemarche"    maxOccurs="unbounded" minOccurs="1" />
                    <xsd:element name="Origine" type="xsd:string" maxOccurs="1" minOccurs="0" />
                    <xsd:element name="Canal" type="tns:TypeCanal" maxOccurs="1" minOccurs="0" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="Sauver_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:element name="Lot" maxOccurs="1"   minOccurs="0">
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="Demarche" type="tns:TypeDemarche"    maxOccurs="unbounded" minOccurs="1" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>
        <xsd:sequence>
            <xsd:element name="Erreur"    type="xsd:string" maxOccurs="1"   minOccurs="1" />
            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>

        <!-- ******************************************************************************************************************** -->

<xsd:element name="Envoyer_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification" type="tns:TypeIdentification"    maxOccurs="1"   minOccurs="1" />
        <xsd:element name="Lot" maxOccurs="1"   minOccurs="0">
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="Demarche" type="tns:TypeDemarche"    maxOccurs="unbounded" minOccurs="1" />
                    <xsd:element name="Origine" type="xsd:string" maxOccurs="1" minOccurs="0" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="Envoyer_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:element name="Lot" maxOccurs="1" minOccurs="0">
            <xsd:complexType>
                <xsd:sequence>
                    <xsd:element name="Demarche" type="tns:TypeDemarche" maxOccurs="unbounded" minOccurs="1" />
                </xsd:sequence>
            </xsd:complexType>
        </xsd:element>
        <xsd:sequence>
            <xsd:element name="Erreur"    type="xsd:string" maxOccurs="1"   minOccurs="1" />
            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="0" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>

        <!-- ******************************************************************************************************************** -->

<xsd:element name="AssistantImport_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification"  type="tns:TypeIdentification"   maxOccurs="1"   minOccurs="1" />
        <xsd:element name="TypeDemarche" maxOccurs="1" minOccurs="0" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:NMTOKEN">
                    <xsd:enumeration value="DIVN"/>
                    <xsd:enumeration value="DIVLN"/>
                    <xsd:enumeration value="VNWW"/>
                    <xsd:enumeration value="VOWW"/>
                    <xsd:enumeration value="PIVO"/>
                    <xsd:enumeration value="PIVOL"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="VIN" type="tns:TypeVIN" maxOccurs="1" minOccurs="1" />
        <xsd:element name="D2_Version"   maxOccurs="1"   minOccurs="1" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:string">
                    <xsd:maxLength value="80"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
        <xsd:element name="K_NumRecepCE" maxOccurs="1" minOccurs="1" >
            <xsd:simpleType>
                <xsd:restriction base="xsd:string">
                    <xsd:maxLength value="25"/>
                </xsd:restriction>
            </xsd:simpleType>
        </xsd:element>
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="AssistantImport_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:sequence>
            <xsd:element name="D1_Marque"   maxOccurs="1"   minOccurs="1" nillable="true">
                <xsd:simpleType>
                    <xsd:restriction base="xsd:string">
                        <xsd:maxLength value="50"/>
                    </xsd:restriction>
                </xsd:simpleType>
            </xsd:element>
            <xsd:element name="F1_MMaxTechAdm"      maxOccurs="1"   minOccurs="1" nillable="true">
                <xsd:simpleType>
                    <xsd:restriction base="xsd:int">
                        <xsd:totalDigits value="10"/>
                    </xsd:restriction>
                </xsd:simpleType>
            </xsd:element>
            <xsd:element name="F2_MMaxAdmServ"      maxOccurs="1"   minOccurs="1" nillable="true">
                <xsd:simpleType>
                    <xsd:restriction base="xsd:int">
                        <xsd:totalDigits value="10"/>
                    </xsd:restriction>
                </xsd:simpleType>
            </xsd:element>
            <xsd:element name="G_MMaxAvecAttelage"  maxOccurs="1"   minOccurs="1" nillable="true">
                <xsd:simpleType>
                    <xsd:restriction base="xsd:int">
                        <xsd:totalDigits value="10"/>
                    </xsd:restriction>
                </xsd:simpleType>
            </xsd:element>
            <xsd:element name="G1_PoidsVide"        maxOccurs="1"   minOccurs="1" nillable="true">
                <xsd:simpleType>
                    <xsd:restriction base="xsd:int">
                        <xsd:totalDigits value="10"/>
                    </xsd:restriction>
                </xsd:simpleType>
            </xsd:element>
            <xsd:element name="J1_Genre"            maxOccurs="1"   minOccurs="1" nillable="true">
                <xsd:simpleType>
                    <xsd:restriction base="xsd:string">
                        <xsd:maxLength value="4"/>
                    </xsd:restriction>
                </xsd:simpleType>
            </xsd:element>
            <xsd:element name="J3_Carrosserie"      maxOccurs="1"   minOccurs="1" nillable="true">
                <xsd:simpleType>
                    <xsd:restriction base="xsd:string">
                        <xsd:maxLength value="15"/>
                    </xsd:restriction>
                </xsd:simpleType>
            </xsd:element>
            <xsd:element name="S1_NbPlaceAssise"    maxOccurs="1"   minOccurs="1" nillable="true">
                <xsd:simpleType>
                    <xsd:restriction base="xsd:int">
                        <xsd:totalDigits value="3"/>
                    </xsd:restriction>
                </xsd:simpleType>
            </xsd:element>
        </xsd:sequence>
        <xsd:sequence>
            <xsd:element name="Erreur"    type="xsd:string" maxOccurs="1"   minOccurs="1" />
            <xsd:element name="Code"    type="xsd:int"   maxOccurs="1"   minOccurs="1" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>

        <!-- ******************************************************************************************************************** -->

<xsd:element name="Archiver_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification" type="tns:TypeIdentification" maxOccurs="1" minOccurs="1" />
        <xsd:element name="IDDemarche" type="xsd:int" maxOccurs="1" minOccurs="1" />
        <xsd:element name="TypeDemarche" type="xsd:string" maxOccurs="1" minOccurs="1" />
        <xsd:element name="Fichiers" type="tns:TypeFichiersUpload" maxOccurs="1" minOccurs="1" />
        <xsd:element name="AutoInclusion" type="xsd:boolean" maxOccurs="1" minOccurs="0" />
        <xsd:element name="Origine" type="xsd:string" maxOccurs="1" minOccurs="0" />
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="Archiver_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:element name="Fichiers" type="tns:TypeFichiersList" maxOccurs="1" minOccurs="1" />
        <xsd:sequence>
            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
            <xsd:element name="Code" type="xsd:int" maxOccurs="1" minOccurs="0" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>

        <!-- ******************************************************************************************************************** -->

<xsd:element name="ControleSIV_Req">
<xsd:complexType>
    <xsd:sequence>
        <xsd:element name="Identification" type="tns:TypeIdentification" maxOccurs="1" minOccurs="1" />
        <xsd:element name="IDDemarche" type="xsd:int" maxOccurs="1" minOccurs="1" />
        <xsd:element name="TypeDemarche" type="xsd:string" maxOccurs="1" minOccurs="1" />
        <!-- 01, 02, ..., 19, 2A, 2B, 21, ..., 95, 971, 972, ..., 976, 98 -->
        <xsd:element name="PrefectureDepartement" type="xsd:string" maxOccurs="1" minOccurs="1" />
        <xsd:element name="ControleurMail" type="xsd:string" maxOccurs="10" minOccurs="1" />
        <xsd:element name="Commentaire" type="xsd:string" maxOccurs="1" minOccurs="0" />
        <xsd:element name="CopieMail" type="xsd:string" maxOccurs="10" minOccurs="0" />
        <xsd:element name="Origine" type="xsd:string" maxOccurs="1" minOccurs="0" />
    </xsd:sequence>
</xsd:complexType>
</xsd:element>

<xsd:element name="ControleSIV_Rep">
<xsd:complexType>
    <xsd:choice>
        <xsd:sequence>
            <xsd:element name="Statut" type="xsd:string" maxOccurs="1" minOccurs="1" default="OK" />
            <xsd:element name="Code" type="xsd:int" maxOccurs="1" minOccurs="0" default="0" />
        </xsd:sequence>
        <xsd:sequence>
            <xsd:element name="Erreur" type="xsd:string" maxOccurs="1" minOccurs="1" />
            <xsd:element name="Code" type="xsd:int" maxOccurs="1" minOccurs="0" />
        </xsd:sequence>
    </xsd:choice>
</xsd:complexType>
</xsd:element>
            <!-- ******************************************************************************************************************** -->

<xsd:annotation>
    <xsd:documentation>DEFINITION DU TYPE IDENTIFICATION</xsd:documentation>
</xsd:annotation>
<xsd:complexType name="TypeIdentification">
<xsd:sequence>
    <xsd:element name="CodeTMS"     type="xsd:string"   maxOccurs="1"   minOccurs="1" />
    <xsd:element name="Login"       type="xsd:string"   maxOccurs="1"   minOccurs="1" />
    <xsd:choice>
        <xsd:element name="Password"  type="xsd:string"   maxOccurs="1"   minOccurs="1" />
        <xsd:element name="ApiKey"    type="xsd:string"   maxOccurs="1"   minOccurs="1" />
    </xsd:choice>
    <xsd:element name="Succursale"  type="xsd:string"   maxOccurs="1"   minOccurs="0" />
</xsd:sequence>
</xsd:complexType>        </xsd:schema>
    </wsdl:types>

    <wsdl:message name="InfoImmat_Req">
        <wsdl:part name="InfoImmatRepMsg" element="tns:InfoImmat_Req" />
    </wsdl:message>
    <wsdl:message name="InfoImmat_Rep">
        <wsdl:part name="InfoImmatReqMsg" element="tns:InfoImmat_Rep" />
    </wsdl:message>

    <wsdl:message name="InfoVIN_Req">
        <wsdl:part name="InfoVINRepMsg" element="tns:InfoVIN_Req" />
    </wsdl:message>
    <wsdl:message name="InfoVIN_Rep">
        <wsdl:part name="InfoVINReqMsg" element="tns:InfoVIN_Rep" />
    </wsdl:message>

    <wsdl:message name="Editer_Req">
        <wsdl:part name="EditerRepMsg" element="tns:Editer_Req" />
    </wsdl:message>
    <wsdl:message name="Editer_Rep">
        <wsdl:part name="EditerReqMsg" element="tns:Editer_Rep" />
    </wsdl:message>

    <wsdl:message name="Ouvrir_Req">
        <wsdl:part name="OuvrirRepMsg" element="tns:Ouvrir_Req" />
    </wsdl:message>
    <wsdl:message name="Ouvrir_Rep">
        <wsdl:part name="OuvrirReqMsg" element="tns:Ouvrir_Rep" />
    </wsdl:message>

    <wsdl:message name="Chercher_Req">
        <wsdl:part name="ChercherRepMsg" element="tns:Chercher_Req" />
    </wsdl:message>
    <wsdl:message name="Chercher_Rep">
        <wsdl:part name="ChercherReqMsg" element="tns:Chercher_Rep" />
    </wsdl:message>

    <wsdl:message name="Sauver_Req">
        <wsdl:part name="SauverRepMsg" element="tns:Sauver_Req" />
    </wsdl:message>
    <wsdl:message name="Sauver_Rep">
        <wsdl:part name="SauverReqMsg" element="tns:Sauver_Rep" />
    </wsdl:message>

    <wsdl:message name="Envoyer_Req">
        <wsdl:part name="EnvoyerRepMsg" element="tns:Envoyer_Req" />
    </wsdl:message>
    <wsdl:message name="Envoyer_Rep">
        <wsdl:part name="EnvoyerReqMsg" element="tns:Envoyer_Rep" />
    </wsdl:message>

    <wsdl:message name="AssistantImport_Req">
        <wsdl:part name="AssistantImportRepMsg" element="tns:AssistantImport_Req" />
    </wsdl:message>
    <wsdl:message name="AssistantImport_Rep">
        <wsdl:part name="AssistantImportReqMsg" element="tns:AssistantImport_Rep" />
    </wsdl:message>

    <wsdl:message name="Archiver_Req">
        <wsdl:part name="ArchiverRepMsg" element="tns:Archiver_Req" />
    </wsdl:message>
    <wsdl:message name="Archiver_Rep">
        <wsdl:part name="ArchiverReqMsg" element="tns:Archiver_Rep" />
    </wsdl:message>

    <wsdl:message name="ControleSIV_Req">
        <wsdl:part name="ControleSIVRepMsg" element="tns:ControleSIV_Req" />
    </wsdl:message>
    <wsdl:message name="ControleSIV_Rep">
        <wsdl:part name="ControleSIVReqMsg" element="tns:ControleSIV_Rep" />
    </wsdl:message>

    <wsdl:portType name="TMS_interface_MISIV">
        <wsdl:operation name="InfoImmat">
            <wsdl:input message="tns:InfoImmat_Req" />
            <wsdl:output message="tns:InfoImmat_Rep" />
        </wsdl:operation>
        <wsdl:operation name="InfoVIN">
            <wsdl:input message="tns:InfoVIN_Req" />
            <wsdl:output message="tns:InfoVIN_Rep" />
        </wsdl:operation>
        <wsdl:operation name="Editer">
            <wsdl:input message="tns:Editer_Req" />
            <wsdl:output message="tns:Editer_Rep" />
        </wsdl:operation>
        <wsdl:operation name="Chercher">
            <wsdl:input message="tns:Chercher_Req" />
            <wsdl:output message="tns:Chercher_Rep" />
        </wsdl:operation>
        <wsdl:operation name="Ouvrir">
            <wsdl:input message="tns:Ouvrir_Req" />
            <wsdl:output message="tns:Ouvrir_Rep" />
        </wsdl:operation>
        <wsdl:operation name="Sauver">
            <wsdl:input message="tns:Sauver_Req" />
            <wsdl:output message="tns:Sauver_Rep" />
        </wsdl:operation>
        <wsdl:operation name="Envoyer">
            <wsdl:input message="tns:Envoyer_Req" />
            <wsdl:output message="tns:Envoyer_Rep" />
        </wsdl:operation>
        <wsdl:operation name="AssistantImport">
            <wsdl:input message="tns:AssistantImport_Req" />
            <wsdl:output message="tns:AssistantImport_Rep" />
        </wsdl:operation>
        <wsdl:operation name="Archiver">
            <wsdl:input message="tns:Archiver_Req" />
            <wsdl:output message="tns:Archiver_Rep" />
        </wsdl:operation>
        <wsdl:operation name="ControleSIV">
            <wsdl:input message="tns:ControleSIV_Req" />
            <wsdl:output message="tns:ControleSIV_Rep" />
        </wsdl:operation>
    </wsdl:portType>

    <wsdl:binding name="TMS_interface_MISIV" type="tns:TMS_interface_MISIV">
        <soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http" />
        <wsdl:operation name="InfoImmat">
            <soap:operation soapAction="MiSIV:Interface:InfoImmat" />
            <wsdl:input>
                <soap:body parts="InfoImmatRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="InfoImmatReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
        <wsdl:operation name="InfoVIN">
            <soap:operation soapAction="MiSIV:Interface:InfoVIN" />
            <wsdl:input>
                <soap:body parts="InfoVINRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="InfoVINReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
        <wsdl:operation name="Editer">
            <soap:operation soapAction="MiSIV:Interface:Editer" />
            <wsdl:input>
                <soap:body parts="EditerRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="EditerReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
        <wsdl:operation name="Chercher">
            <soap:operation soapAction="MiSIV:Interface:Chercher" />
            <wsdl:input>
                <soap:body parts="ChercherRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="ChercherReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
        <wsdl:operation name="Ouvrir">
            <soap:operation soapAction="MiSIV:Interface:Ouvrir" />
            <wsdl:input>
                <soap:body parts="OuvrirRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="OuvrirReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
        <wsdl:operation name="Sauver">
            <soap:operation soapAction="MiSIV:Interface:Sauver" />
            <wsdl:input>
                <soap:body parts="SauverRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="SauverReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
        <wsdl:operation name="Envoyer">
            <soap:operation soapAction="MiSIV:Interface:Envoyer" />
            <wsdl:input>
                <soap:body parts="EnvoyerRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="EnvoyerReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
        <wsdl:operation name="AssistantImport">
            <soap:operation soapAction="MiSIV:Interface:AssistantImport" />
            <wsdl:input>
                <soap:body parts="AssistantImportRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="AssistantImportReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
        <wsdl:operation name="Archiver">
            <soap:operation soapAction="MiSIV:Interface:Archiver" />
            <wsdl:input>
                <soap:body parts="ArchiverRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="ArchiverReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
        <wsdl:operation name="ControleSIV">
            <soap:operation soapAction="MiSIV:Interface:ControleSIV" />
            <wsdl:input>
                <soap:body parts="ControleSIVRepMsg" use="literal" />
            </wsdl:input>
            <wsdl:output>
                <soap:body parts="ControleSIVReqMsg" use="literal" />
            </wsdl:output>
        </wsdl:operation>
    </wsdl:binding>

    <wsdl:service name="TMS_interface_MISIV">
        <wsdl:port name="TMS_interface_MISIV" binding="tns:TMS_interface_MISIV">
            <soap:address location="http://test.misiv.intra.misiv.fr/interface.php?v=2" />
        </wsdl:port>
    </wsdl:service>
</wsdl:definitions>
