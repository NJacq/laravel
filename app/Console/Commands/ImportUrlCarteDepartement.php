<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;

use App\Models\UrlCarteDepartement;
use App\Models\Departement;


class ImportUrlCarteDepartement extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:urlcartedepartements';

    /**
     * Description de la commande : imporer donnees depuis ftthregions.
     *
     * @var string
     */
    protected $description = 'Importer url carte departements';

    /**
     * Créer une nouvelle instance de commande.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Exécuter la commande
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Début du script');
       
        $urlCarte= [
            '01' => 'https://cartefibre.arcep.fr/index.html?location=5.2830472264245145,46.19074180491384&zoom=8.547771866248253&mode=Dpt',
            '02' => 'https://cartefibre.arcep.fr/index.html?location=3.6887155998942944,49.36726874975423&zoom=8.165907684770252&mode=Dpt',
            '03' => 'https://cartefibre.arcep.fr/index.html?location=3.5354666354642177,46.33517039169428&zoom=8.782802623409872&mode=Dpt',
            '04' => 'https://cartefibre.arcep.fr/index.html?location=6.4451287341518935,44.33791814958826&zoom=8.3512877082322&mode=Dpt',
            '05' => 'https://cartefibre.arcep.fr/index.html?location=6.750245367689757,44.775992789687734&zoom=8.3512877082322&mode=Dpt',
            '06' => 'https://cartefibre.arcep.fr/index.html?location=7.046236230958442,44.01873704457944&zoom=7.8764166855553&mode=Dpt',
            '07' => 'https://cartefibre.arcep.fr/index.html?location=4.65501528641289,44.77655515324591&zoom=8.722443346463562&mode=Dpt',
            '08' => 'https://cartefibre.arcep.fr/index.html?location=4.843295989562989,49.476485076969226&zoom=8.165907684770252&mode=Dpt',
            '09' => 'https://cartefibre.arcep.fr/index.html?location=1.9664553847534592,42.98935626465041&zoom=8.546582323424488&mode=Dpt',
            '10' => 'https://cartefibre.arcep.fr/index.html?location=4.4739219928661385,48.167435774375576&zoom=8.242193768084698&mode=Dpt',
            '11' => 'https://cartefibre.arcep.fr/index.html?location=2.7107544233808767,43.147317229730305&zoom=8.546582323424488&mode=Dpt',
            '12' => 'https://cartefibre.arcep.fr/index.html?location=2.7383479728106295,44.279237749540215&zoom=7.974355154090052&mode=Dpt',
            '13' => 'https://cartefibre.arcep.fr/index.html?location=5.513362651927736,43.430573615451095&zoom=8.546582323424488&mode=Dpt',
            '14' => 'https://cartefibre.arcep.fr/index.html?location=-0.28325652597033013,49.09400481209886&zoom=7.8410562870339255&mode=Dpt',
            '15' => 'https://cartefibre.arcep.fr/index.html?location=2.7239938036918545,45.037084832236786&zoom=7.356270672626679&mode=Dpt',
            '16' => 'https://cartefibre.arcep.fr/index.html?location=0.39787139872325383,45.74070327484503&zoom=7.598663479830302&mode=Dpt',
            '17' => 'https://cartefibre.arcep.fr/index.html?location=-0.8562025496422621,45.795512444564395&zoom=7.598663479830302&mode=Dpt',
            '18' => 'https://cartefibre.arcep.fr/index.html?location=2.663710385824544,47.028887021745504&zoom=7.6532458408658295&mode=Dpt',
            '19' => 'https://cartefibre.arcep.fr/index.html?location=2.0369540887599555,45.35074484615893&zoom=7.356270672626679&mode=Dpt',
            '21' => 'https://cartefibre.arcep.fr/index.html?location=4.824715539110912,47.51745258420905&zoom=8.242193768084698&mode=Dpt',
            '22' => 'https://cartefibre.arcep.fr/index.html?location=-2.480327550591113,48.34495424421169&zoom=7.8410562870339255&mode=Dpt',
            '23' => 'https://cartefibre.arcep.fr/index.html?location=2.0742972717957002,45.93037580935402&zoom=7.356270672626679&mode=Dpt',
            '24' => 'https://cartefibre.arcep.fr/index.html?location=0.47555820974525886,45.10274928335181&zoom=7.974355154090052&mode=Dpt',
            '25' => 'https://cartefibre.arcep.fr/index.html?location=5.963484260977111,47.050996655918595&zoom=8.733151889710198&mode=Dpt',
            '26' => 'https://cartefibre.arcep.fr/index.html?location=5.213883820167695,44.968462602741624&zoom=7.974355154090052&mode=Dpt',
            '27' => 'https://cartefibre.arcep.fr/index.html?location=0.7614516073716686,49.273805452650834&zoom=7.8410562870339255&mode=Dpt',
            '28' => 'https://cartefibre.arcep.fr/index.html?location=1.4101981554389909,48.25189171546822&zoom=7.488328659800422&mode=Dpt',
            '29' => 'https://cartefibre.arcep.fr/index.html?location=-3.968038825418148,48.202984657881615&zoom=7.8410562870339255&mode=Dpt',
            '2A' => 'https://cartefibre.arcep.fr/index.html?location=9.217212738674561,42.3418372258198&zoom=6.994830840150627&mode=Dpt',
            '2B' => 'https://cartefibre.arcep.fr/index.html?location=9.195709942707367,41.74669654986701&zoom=6.994830840150627&mode=Dpt',
            '30' => 'https://cartefibre.arcep.fr/index.html?location=4.4767609933306005,43.977046560799636&zoom=8.546582323424488&mode=Dpt',
            '31' => 'https://cartefibre.arcep.fr/index.html?location=1.1314932696663789,43.270226576877576&zoom=8.546582323424488&mode=Dpt',
            '32' => 'https://cartefibre.arcep.fr/index.html?location=0.4655812148173766,43.79488812522837&zoom=7.488328659800422&mode=Dpt',
            '33' => 'https://cartefibre.arcep.fr/index.html?location=-0.36408843604633034,44.663998929512445&zoom=8.139272335155459&mode=Dpt',
            '34' => 'https://cartefibre.arcep.fr/index.html?location=3.7612979426179436,43.64719226827515&zoom=8.546582323424488&mode=Dpt',
            '35' => 'https://cartefibre.arcep.fr/index.html?location=-1.732205936490999,48.44321075034432&zoom=7.8410562870339255&mode=Dpt',
            '36' => 'https://cartefibre.arcep.fr/index.html?location=1.648457646846822,46.563800869082314&zoom=7.356270672626679&mode=Dpt',
            '37' => 'https://cartefibre.arcep.fr/index.html?location=0.8196045216841128,47.18089170226702&zoom=7.488328659800422&mode=Dpt',
            '38' => 'https://cartefibre.arcep.fr/index.html?location=5.700399800087808,45.28115875452724&zoom=8.3512877082322&mode=Dpt',
            '39' => 'https://cartefibre.arcep.fr/index.html?location=5.6859932988036235,46.705523118478936&zoom=8.650693299177496&mode=Dpt',
            '40' => 'https://cartefibre.arcep.fr/index.html?location=-0.8761182678371995,43.77786435580896&zoom=8.546582323424488&mode=Dpt',
            '41' => 'https://cartefibre.arcep.fr/index.html?location=1.5326026602369325,47.5492213224463&zoom=7.488328659800422&mode=Dpt',
            '42' => 'https://cartefibre.arcep.fr/index.html?location=4.225103992567085,45.8568776286142&zoom=7.356270672626679&mode=Dpt',
            '43' => 'https://cartefibre.arcep.fr/index.html?location=3.925573476050772,45.14334869200124&zoom=7.356270672626679&mode=Dpt',
            '44' => 'https://cartefibre.arcep.fr/index.html?location=-1.5551106901726257,47.548343461613655&zoom=7.8410562870339255&mode=Dpt',
            '45' => 'https://cartefibre.arcep.fr/index.html?location=2.0031454892401825,48.11349472251098&zoom=7.488328659800422&mode=Dpt',
            '46' => 'https://cartefibre.arcep.fr/index.html?location=1.7895939973114423,44.59500483256517&zoom=7.488328659800422&mode=Dpt',
            '47' => 'https://cartefibre.arcep.fr/index.html?location=0.5124069360747683,44.30786318067851&zoom=7.488328659800422&mode=Dpt',
            '48' => 'https://cartefibre.arcep.fr/index.html?location=3.6175404620211395,44.5241550891229&zoom=7.974355154090052&mode=Dpt',
            '49' => 'https://cartefibre.arcep.fr/index.html?location=-0.3934633696440244,47.459522610711105&zoom=7.488328659800422&mode=Dpt',
            '50' => 'https://cartefibre.arcep.fr/index.html?location=-1.093035206538616,49.06389347869941&zoom=7.8410562870339255&mode=Dpt',
            '51' => 'https://cartefibre.arcep.fr/index.html?location=4.197269744978939,49.07922016865538&zoom=8.242193768084698&mode=Dpt',
            '52' => 'https://cartefibre.arcep.fr/index.html?location=5.213987616758686,48.13312203703467&zoom=7.9985600809986925&mode=Dpt',
            '53' => 'https://cartefibre.arcep.fr/index.html?location=-0.945080905255395,48.20843125216848&zoom=7.567373053419714&mode=Dpt',
            '54' => 'https://cartefibre.arcep.fr/index.html?location=6.0566617215065435,48.942025277623145&zoom=8.08344909423755&mode=Dpt',
            '55' => 'https://cartefibre.arcep.fr/index.html?location=5.387758374105545,49.00109083093707&zoom=8.221730925688162&mode=Dpt',
            '56' => 'https://cartefibre.arcep.fr/index.html?location=-3.0951580235514484,47.982363294428495&zoom=7.8410562870339255&mode=Dpt',
            '57' => 'https://cartefibre.arcep.fr/index.html?location=6.713160508822057,48.986269723488476&zoom=8.08344909423755&mode=Dpt',
            '58' => 'https://cartefibre.arcep.fr/index.html?location=3.8360089920621476,47.31390747719399&zoom=7.347804258565255&mode=Dpt',
            '59' => 'https://cartefibre.arcep.fr/index.html?location=3.421901273887528,50.25601065557754&zoom=7.8410562870339255&mode=Dpt',
            '60' => 'https://cartefibre.arcep.fr/index.html?location=2.6673370441832276,49.42362840419261&zoom=8.242193768084698&mode=Dpt',
            '61' => 'https://cartefibre.arcep.fr/index.html?location=-0.10051052040569175,48.5994843480718&zoom=8.796120757026054&mode=Dpt',
            '62' => 'https://cartefibre.arcep.fr/index.html?location=2.624291939769165,50.30490732187664&zoom=7.8410562870339255&mode=Dpt',
            '63' => 'https://cartefibre.arcep.fr/index.html?location=3.3565422095608994,45.707692232182154&zoom=7.356270672626679&mode=Dpt',
            '64' => 'https://cartefibre.arcep.fr/index.html?location=-0.6990608780776313,43.12168152893918&zoom=8.546582323424488&mode=Dpt',
            '65' => 'https://cartefibre.arcep.fr/index.html?location=0.13270604586205081,43.023800652647765&zoom=8.546582323424488&mode=Dpt',
            '66' => 'https://cartefibre.arcep.fr/index.html?location=2.5735407063495472,42.628249780705374&zoom=8.546582323424488&mode=Dpt',
            '67' => 'https://cartefibre.arcep.fr/index.html?location=7.655571418804016,48.549376926964584&zoom=7.918531913172142&mode=Dpt',
            '68' => 'https://cartefibre.arcep.fr/index.html?location=7.499852087904969,47.977007893661266&zoom=7.918531913172142&mode=Dpt',
            '69' => 'https://cartefibre.arcep.fr/index.html?location=4.675017677177493,45.68687238132631&zoom=8.165907684770255&mode=Dpt',
            '70' => 'https://cartefibre.arcep.fr/index.html?location=6.413761867981037,47.61247481523256&zoom=8.650693299177496&mode=Dpt',
            '71' => 'https://cartefibre.arcep.fr/index.html?location=5.080667063824848,46.66110610865965&zoom=8.165907684770255&mode=Dpt',
            '72' => 'https://cartefibre.arcep.fr/index.html?location=0.6769724916831592,47.8248977839136&zoom=8.12271769496862&mode=Dpt',
            '73' => 'https://cartefibre.arcep.fr/index.html?location=6.149227712733477,45.62813332413208&zoom=8.3512877082322&mode=Dpt',
            '74' => 'https://cartefibre.arcep.fr/index.html?location=6.600611446982498,46.09265568469735&zoom=8.68112207036301&mode=Dpt',
            '75' => 'https://cartefibre.arcep.fr/index.html?location=2.361009949108194,48.83104275347998&zoom=9.469106697286282&mode=Dpt',
            '76' => 'https://cartefibre.arcep.fr/index.html?location=1.036487768119514,49.5642831972896&zoom=8.644177506027685&mode=Dpt',
            '77' => 'https://cartefibre.arcep.fr/index.html?location=1.0951883329089753,49.70282770609319&zoom=7.8410562870339255&mode=Dpt',
            '78' => 'https://cartefibre.arcep.fr/index.html?location=1.8182785166050337,48.868040877614675&zoom=8.242193768084698&mode=Dpt',
            '79' => 'https://cartefibre.arcep.fr/index.html?location=-0.009346879100320393,46.60043041919474&zoom=7.598663479830302&mode=Dpt',
            '80' => 'https://cartefibre.arcep.fr/index.html?location=1.9974397320281128,49.999972126695525&zoom=7.8410562870339255&mode=Dpt',
            '81' => 'https://cartefibre.arcep.fr/index.html?location=2.1346385045196143,43.94803379174087&zoom=7.974355154090052&mode=Dpt',
            '82' => 'https://cartefibre.arcep.fr/index.html?location=1.2283632907511617,44.08585847215042&zoom=7.974355154090052&mode=Dpt',
            '83' => 'https://cartefibre.arcep.fr/index.html?location=6.285662097764487,43.51306537464919&zoom=8.546582323424488&mode=Dpt',
            '84' => 'https://cartefibre.arcep.fr/index.html?location=5.245936580123413,43.91773713327538&zoom=8.546582323424488&mode=Dpt',
            '85' => 'https://cartefibre.arcep.fr/index.html?location=-1.2547225047191546,46.84126064860993&zoom=7.8410562870339255&mode=Dpt',
            '86' => 'https://cartefibre.arcep.fr/index.html?location=0.3904217339316176,46.66756915478342&zoom=8.324652358617413&mode=Dpt',
            '87' => 'https://cartefibre.arcep.fr/index.html?location=1.2419938153169028,46.044820832455116&zoom=7.598663479830302&mode=Dpt',
            '88' => 'https://cartefibre.arcep.fr/index.html?location=6.883592401539403,48.18420613511134&zoom=7.918531913172142&mode=Dpt',
            '89' => 'https://cartefibre.arcep.fr/index.html?location=3.3829868152365634,47.815975112988525&zoom=8.324652358617413&mode=Dpt',
            '90' => 'https://cartefibre.arcep.fr/index.html?location=6.896289250518834,47.566979228907286&zoom=8.650693299177496&mode=Dpt',
            '91' => 'https://cartefibre.arcep.fr/index.html?location=2.2972482163794723,48.50413748074271&zoom=8.242193768084698&mode=Dpt',
            '92' => 'https://cartefibre.arcep.fr/index.html?location=2.2790222559586653,48.936764610414286&zoom=9.469106697286282&mode=Dpt',
            '93' => 'https://cartefibre.arcep.fr/index.html?location=2.483562044347309,48.8822170831867&zoom=9.304189516220873&mode=Dpt',
            '94' => 'https://cartefibre.arcep.fr/index.html?location=2.4237769291248696,48.73798675561383&zoom=9.304189516220873&mode=Dpt',
            '95' => 'https://cartefibre.arcep.fr/index.html?location=2.188774156880271,49.05652831087954&zoom=8.242193768084698&mode=Dpt',
            '971' => 'https://cartefibre.arcep.fr/index.html?location=-61.5,16.242765426800005&zoom=9.398743691938199&mode=Dpt',
            '972' => 'https://cartefibre.arcep.fr/index.html?location=-61.07300000000001,14.608000000000004&zoom=9.398743691938199&mode=Dpt',
            '973' => 'https://cartefibre.arcep.fr/index.html?location=-53.166499999999985,3.969003478145808&zoom=8.283377455328413&mode=Dpt',
            '974' => 'https://cartefibre.arcep.fr/index.html?location=55.5,-21.15&zoom=10&mode=Dpt',
            '975' => 'https://cartefibre.arcep.fr/index.html?location=-56.17700000000001,46.778999999999996&zoom=9.398743691938185&mode=Dpt',
            '976' => 'https://cartefibre.arcep.fr/index.html?location=45.25800000000001,-12.781999999999982&zoom=8.37726396452775&mode=Dpt',
            '977' => 'https://cartefibre.arcep.fr/index.html?location=-62.79858395395439,17.899403396007997&zoom=11.710493164909561&mode=Dpt',
            '978' => 'https://cartefibre.arcep.fr/index.html?location=-63.150000000000006,18.05017774406612&zoom=10.913316864767973&mode=Dpt'
        ];
        // print_r($urlCarte);
      
        foreach($urlCarte as $code=>$url)
        {
            $dataToInsert = [ // Creation d'un tableau avec la même structure que la base de données
                'code_departement' => $code,
                'url' => $url
            ];
            print_r($dataToInsert);

            $departement = Departement::where('code_departement', $dataToInsert['code_departement'])->first();                          
            
            if(empty($departement->id)) {
                $this->error('Impossible de trouver le département '.$dataToInsert['code_departement'].' pour le département '.$dataToInsert['code_departement']);
            }
            else {
                $dataToInsert['departement_id'] = $departement->id; 
            }  
    
            $newUrlCarteDepartement = UrlCarteDepartement::updateOrCreate([ // fonction qui permet d'ajouter ou de modifier des éléments à la base de données
                'code_departement' => $dataToInsert['code_departement'] // On se base sur la clé 'region_id" pour véfifier les modifications des autres clés. 
            ], $dataToInsert);    
        };  

        $this->info('Fin du script');
    }
}
