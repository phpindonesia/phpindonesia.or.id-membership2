<?php

use Phinx\Seed\AbstractSeed;

class RegionalsSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'regional_name' => 'ACEH',
                'parent_id' => '',
                'province_code' => '11',
                'city_code' => '00'
            ],
            [
                'id' => '2',
                'regional_name' => 'KAB. ACEH SELATAN',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '03'
            ],
            [
                'id' => '3',
                'regional_name' => 'KAB. ACEH TENGGARA',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '04'
            ],
            [
                'id' => '4',
                'regional_name' => 'KAB. ACEH TIMUR',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '05'
            ],
            [
                'id' => '5',
                'regional_name' => 'KAB. ACEH TENGAH',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '06'
            ],
            [
                'id' => '6',
                'regional_name' => 'KAB. ACEH BARAT',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '07'
            ],
            [
                'id' => '7',
                'regional_name' => 'KAB. ACEH BESAR',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '08'
            ],
            [
                'id' => '8',
                'regional_name' => 'KAB. PIDIE',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '09'
            ],
            [
                'id' => '9',
                'regional_name' => 'KAB. ACEH UTARA',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '11'
            ],
            [
                'id' => '10',
                'regional_name' => 'KAB. SIMEULUE',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '01'
            ],
            [
                'id' => '11',
                'regional_name' => 'KAB. ACEH SINGKIL',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '02'
            ],
            [
                'id' => '12',
                'regional_name' => 'KAB. BIREUEN',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '10'
            ],
            [
                'id' => '13',
                'regional_name' => 'KAB. ACEH BARAT DAYA',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '12'
            ],
            [
                'id' => '14',
                'regional_name' => 'KAB. GAYO LUES',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '13'
            ],
            [
                'id' => '15',
                'regional_name' => 'KAB. ACEH JAYA',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '16'
            ],
            [
                'id' => '16',
                'regional_name' => 'KAB. NAGAN RAYA',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '15'
            ],
            [
                'id' => '17',
                'regional_name' => 'KAB. ACEH TAMIANG',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '14'
            ],
            [
                'id' => '18',
                'regional_name' => 'KAB. BENER MERIAH',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '17'
            ],
            [
                'id' => '19',
                'regional_name' => 'KAB. PIDIE JAYA',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '18'
            ],
            [
                'id' => '20',
                'regional_name' => 'KOTA BANDA ACEH',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '71'
            ],
            [
                'id' => '21',
                'regional_name' => 'KOTA SABANG',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '72'
            ],
            [
                'id' => '22',
                'regional_name' => 'KOTA LHOKSEUMAWE',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '74'
            ],
            [
                'id' => '23',
                'regional_name' => 'KOTA LANGSA',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '73'
            ],
            [
                'id' => '24',
                'regional_name' => 'KOTA SUBULUSSALAM',
                'parent_id' => '1',
                'province_code' => '11',
                'city_code' => '75'
            ],
            [
                'id' => '25',
                'regional_name' => 'SUMATERA UTARA',
                'parent_id' => '',
                'province_code' => '12',
                'city_code' => '00'
            ],
            [
                'id' => '26',
                'regional_name' => 'KAB. TAPANULI TENGAH',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '01'
            ],
            [
                'id' => '27',
                'regional_name' => 'KAB. TAPANULI UTARA',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '05'
            ],
            [
                'id' => '28',
                'regional_name' => 'KAB. TAPANULI SELATAN',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '03'
            ],
            [
                'id' => '29',
                'regional_name' => 'KAB. NIAS',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '01'
            ],
            [
                'id' => '30',
                'regional_name' => 'KAB. LANGKAT',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '13'
            ],
            [
                'id' => '31',
                'regional_name' => 'KAB. KARO',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '11'
            ],
            [
                'id' => '32',
                'regional_name' => 'KAB. DELI SERDANG',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '12'
            ],
            [
                'id' => '33',
                'regional_name' => 'KAB. SIMALUNGUN',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '09'
            ],
            [
                'id' => '34',
                'regional_name' => 'KAB. ASAHAN',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '08'
            ],
            [
                'id' => '35',
                'regional_name' => 'KAB. LABUHAN BATU',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '07'
            ],
            [
                'id' => '36',
                'regional_name' => 'KAB. DAIRI',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '10'
            ],
            [
                'id' => '37',
                'regional_name' => 'KAB. TOBA SAMOSIR',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '06'
            ],
            [
                'id' => '38',
                'regional_name' => 'KAB. MANDAILING NATAL',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '02'
            ],
            [
                'id' => '39',
                'regional_name' => 'KAB. NIAS SELATAN',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '14'
            ],
            [
                'id' => '40',
                'regional_name' => 'KAB. PAKPAK BHARAT',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '16'
            ],
            [
                'id' => '41',
                'regional_name' => 'KAB. HUMBANG HASUNDUTAN',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '15'
            ],
            [
                'id' => '42',
                'regional_name' => 'KAB. SAMOSIR',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '17'
            ],
            [
                'id' => '43',
                'regional_name' => 'KAB. SERDANG BEDAGAI',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '18'
            ],
            [
                'id' => '44',
                'regional_name' => 'KAB. BATU BARA',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '19'
            ],
            [
                'id' => '45',
                'regional_name' => 'KAB. PADANG LAWAS UTARA',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '20'
            ],
            [
                'id' => '46',
                'regional_name' => 'KAB. PADANG LAWAS',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '21'
            ],
            [
                'id' => '47',
                'regional_name' => 'KOTA MEDAN',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '75'
            ],
            [
                'id' => '48',
                'regional_name' => 'KOTA PEMATANG SIANTAR',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '73'
            ],
            [
                'id' => '49',
                'regional_name' => 'KOTA SIBOLGA',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '71'
            ],
            [
                'id' => '50',
                'regional_name' => 'KOTA TANJUNG BALAI',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '72'
            ],
            [
                'id' => '51',
                'regional_name' => 'KOTA BINJAI',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '76'
            ],
            [
                'id' => '52',
                'regional_name' => 'KOTA TEBING TINGGI',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '74'
            ],
            [
                'id' => '53',
                'regional_name' => 'KOTA PADANGSIDIMPUAN',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '77'
            ],
            [
                'id' => '54',
                'regional_name' => 'SUMATERA BARAT',
                'parent_id' => '',
                'province_code' => '13',
                'city_code' => '00'
            ],
            [
                'id' => '55',
                'regional_name' => 'KAB. PESISIR SELATAN',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '02'
            ],
            [
                'id' => '56',
                'regional_name' => 'KAB. SOLOK',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '03'
            ],
            [
                'id' => '57',
                'regional_name' => 'KAB. SIJUNJUNG',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '04'
            ],
            [
                'id' => '58',
                'regional_name' => 'KAB. TANAH DATAR',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '05'
            ],
            [
                'id' => '59',
                'regional_name' => 'KAB. PADANG PARIAMAN',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '06'
            ],
            [
                'id' => '60',
                'regional_name' => 'KAB. AGAM',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '07'
            ],
            [
                'id' => '61',
                'regional_name' => 'KAB. LIMA PULUH KOTA',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '08'
            ],
            [
                'id' => '62',
                'regional_name' => 'KAB. PASAMAN',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '09'
            ],
            [
                'id' => '63',
                'regional_name' => 'KAB. KEPULAUAN MENTAWAI',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '01'
            ],
            [
                'id' => '64',
                'regional_name' => 'KAB. DHARMASRAYA',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '11'
            ],
            [
                'id' => '65',
                'regional_name' => 'KAB. SOLOK SELATAN',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '10'
            ],
            [
                'id' => '66',
                'regional_name' => 'KAB. PASAMAN BARAT',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '12'
            ],
            [
                'id' => '67',
                'regional_name' => 'KOTA PADANG',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '71'
            ],
            [
                'id' => '68',
                'regional_name' => 'KOTA SOLOK',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '72'
            ],
            [
                'id' => '69',
                'regional_name' => 'KOTA SAWAHLUNTO',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '73'
            ],
            [
                'id' => '70',
                'regional_name' => 'KOTA PADANG PANJANG',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '74'
            ],
            [
                'id' => '71',
                'regional_name' => 'KOTA BUKITTINGGI',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '75'
            ],
            [
                'id' => '72',
                'regional_name' => 'KOTA PAYAKUMBUH',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '76'
            ],
            [
                'id' => '73',
                'regional_name' => 'KOTA PARIAMAN',
                'parent_id' => '54',
                'province_code' => '13',
                'city_code' => '77'
            ],
            [
                'id' => '74',
                'regional_name' => 'RIAU',
                'parent_id' => '',
                'province_code' => '14',
                'city_code' => '00'
            ],
            [
                'id' => '75',
                'regional_name' => 'KAB. KAMPAR',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '06'
            ],
            [
                'id' => '76',
                'regional_name' => 'KAB. INDRAGIRI HULU',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '02'
            ],
            [
                'id' => '77',
                'regional_name' => 'KAB. BENGKALIS',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '08'
            ],
            [
                'id' => '78',
                'regional_name' => 'KAB. INDRAGIRI HILIR',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '03'
            ],
            [
                'id' => '79',
                'regional_name' => 'KAB. PELALAWAN',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '04'
            ],
            [
                'id' => '80',
                'regional_name' => 'KAB. ROKAN HULU',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '07'
            ],
            [
                'id' => '81',
                'regional_name' => 'KAB. ROKAN HILIR',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '09'
            ],
            [
                'id' => '82',
                'regional_name' => 'KAB. SIAK',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '05'
            ],
            [
                'id' => '83',
                'regional_name' => 'KAB. KUANTAN SINGINGI',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '01'
            ],
            [
                'id' => '84',
                'regional_name' => 'KOTA PEKANBARU',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '71'
            ],
            [
                'id' => '85',
                'regional_name' => 'KOTA DUMAI',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '73'
            ],
            [
                'id' => '86',
                'regional_name' => 'JAMBI',
                'parent_id' => '',
                'province_code' => '15',
                'city_code' => '00'
            ],
            [
                'id' => '87',
                'regional_name' => 'KAB. KERINCI',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '01'
            ],
            [
                'id' => '88',
                'regional_name' => 'KAB. MERANGIN',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '02'
            ],
            [
                'id' => '89',
                'regional_name' => 'KAB. SAROLANGUN',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '03'
            ],
            [
                'id' => '90',
                'regional_name' => 'KAB. BATANGHARI',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '04'
            ],
            [
                'id' => '91',
                'regional_name' => 'KAB. MUARO JAMBI',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '05'
            ],
            [
                'id' => '92',
                'regional_name' => 'KAB TANJUNG JABUNG BARAT',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '07'
            ],
            [
                'id' => '93',
                'regional_name' => 'KAB TANJUNG JABUNG TIMUR',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '06'
            ],
            [
                'id' => '94',
                'regional_name' => 'KAB. BUNGO',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '09'
            ],
            [
                'id' => '95',
                'regional_name' => 'KAB. TEBO',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '08'
            ],
            [
                'id' => '96',
                'regional_name' => 'KOTA JAMBI',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '71'
            ],
            [
                'id' => '97',
                'regional_name' => 'SUMATERA SELATAN',
                'parent_id' => '',
                'province_code' => '16',
                'city_code' => '00'
            ],
            [
                'id' => '98',
                'regional_name' => 'KAB. OGAN KOMERING ULU',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '01'
            ],
            [
                'id' => '99',
                'regional_name' => 'KAB. OGAN KOMERING ILIR',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '02'
            ],
            [
                'id' => '100',
                'regional_name' => 'KAB. MUARA ENIM',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '03'
            ],
            [
                'id' => '101',
                'regional_name' => 'KAB. LAHAT',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '04'
            ],
            [
                'id' => '102',
                'regional_name' => 'KAB. MUSI RAWAS',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '05'
            ],
            [
                'id' => '103',
                'regional_name' => 'KAB. MUSI BANYUASIN',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '06'
            ],
            [
                'id' => '104',
                'regional_name' => 'KAB. BANYU ASIN',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '07'
            ],
            [
                'id' => '107',
                'regional_name' => 'KAB. OGAN ILIR',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '10'
            ],
            [
                'id' => '108',
                'regional_name' => 'KAB. EMPAT LAWANG',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '11'
            ],
            [
                'id' => '109',
                'regional_name' => 'KOTA PALEMBANG',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '71'
            ],
            [
                'id' => '110',
                'regional_name' => 'KOTA PAGAR ALAM',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '73'
            ],
            [
                'id' => '111',
                'regional_name' => 'KOTA LUBUKLINGGAU',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '74'
            ],
            [
                'id' => '112',
                'regional_name' => 'KOTA PRABUMULIH',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '72'
            ],
            [
                'id' => '113',
                'regional_name' => 'BENGKULU',
                'parent_id' => '',
                'province_code' => '17',
                'city_code' => '00'
            ],
            [
                'id' => '114',
                'regional_name' => 'KAB. BENGKULU SELATAN',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '01'
            ],
            [
                'id' => '115',
                'regional_name' => 'KAB. REJANG LEBONG',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '02'
            ],
            [
                'id' => '116',
                'regional_name' => 'KAB. BENGKULU UTARA',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '03'
            ],
            [
                'id' => '117',
                'regional_name' => 'KAB. KAUR',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '04'
            ],
            [
                'id' => '118',
                'regional_name' => 'KAB. SELUMA',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '05'
            ],
            [
                'id' => '119',
                'regional_name' => 'KAB. MUKOMUKO',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '06'
            ],
            [
                'id' => '120',
                'regional_name' => 'KAB. LEBONG',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '07'
            ],
            [
                'id' => '121',
                'regional_name' => 'KAB. KEPAHIANG',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '08'
            ],
            [
                'id' => '122',
                'regional_name' => 'KOTA BENGKULU',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '71'
            ],
            [
                'id' => '123',
                'regional_name' => 'LAMPUNG',
                'parent_id' => '',
                'province_code' => '18',
                'city_code' => '00'
            ],
            [
                'id' => '124',
                'regional_name' => 'KAB. LAMPUNG SELATAN',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '03'
            ],
            [
                'id' => '125',
                'regional_name' => 'KAB. LAMPUNG TENGAH',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '05'
            ],
            [
                'id' => '126',
                'regional_name' => 'KAB. LAMPUNG UTARA',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '06'
            ],
            [
                'id' => '127',
                'regional_name' => 'KAB. LAMPUNG BARAT',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '01'
            ],
            [
                'id' => '128',
                'regional_name' => 'KAB. TULANGBAWANG',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '08'
            ],
            [
                'id' => '129',
                'regional_name' => 'KAB. TANGGAMUS',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '02'
            ],
            [
                'id' => '130',
                'regional_name' => 'KAB. LAMPUNG TIMUR',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '04'
            ],
            [
                'id' => '131',
                'regional_name' => 'KAB. WAY KANAN',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '07'
            ],
            [
                'id' => '132',
                'regional_name' => 'KAB. PESAWARAN',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '09'
            ],
            [
                'id' => '133',
                'regional_name' => 'KOTA BANDAR LAMPUNG',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '71'
            ],
            [
                'id' => '134',
                'regional_name' => 'KOTA METRO',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '72'
            ],
            [
                'id' => '135',
                'regional_name' => 'KEP. BANGKA BELITUNG',
                'parent_id' => '',
                'province_code' => '19',
                'city_code' => '00'
            ],
            [
                'id' => '136',
                'regional_name' => 'KAB. BANGKA',
                'parent_id' => '135',
                'province_code' => '19',
                'city_code' => '01'
            ],
            [
                'id' => '137',
                'regional_name' => 'KAB. BELITUNG',
                'parent_id' => '135',
                'province_code' => '19',
                'city_code' => '02'
            ],
            [
                'id' => '138',
                'regional_name' => 'KAB. BANGKA SELATAN',
                'parent_id' => '135',
                'province_code' => '19',
                'city_code' => '05'
            ],
            [
                'id' => '139',
                'regional_name' => 'KAB. BANGKA TENGAH',
                'parent_id' => '135',
                'province_code' => '19',
                'city_code' => '04'
            ],
            [
                'id' => '140',
                'regional_name' => 'KAB. BANGKA BARAT',
                'parent_id' => '135',
                'province_code' => '19',
                'city_code' => '03'
            ],
            [
                'id' => '141',
                'regional_name' => 'KAB. BELITUNG TIMUR',
                'parent_id' => '135',
                'province_code' => '19',
                'city_code' => '06'
            ],
            [
                'id' => '142',
                'regional_name' => 'KOTA PANGKAL PINANG',
                'parent_id' => '135',
                'province_code' => '19',
                'city_code' => '71'
            ],
            [
                'id' => '143',
                'regional_name' => 'KEP. RIAU',
                'parent_id' => '',
                'province_code' => '21',
                'city_code' => '00'
            ],
            [
                'id' => '144',
                'regional_name' => 'KAB. BINTAN',
                'parent_id' => '143',
                'province_code' => '21',
                'city_code' => '02'
            ],
            [
                'id' => '145',
                'regional_name' => 'KAB. KARIMUN',
                'parent_id' => '143',
                'province_code' => '21',
                'city_code' => '01'
            ],
            [
                'id' => '146',
                'regional_name' => 'KAB. NATUNA',
                'parent_id' => '143',
                'province_code' => '21',
                'city_code' => '03'
            ],
            [
                'id' => '147',
                'regional_name' => 'KAB. LINGGA',
                'parent_id' => '143',
                'province_code' => '21',
                'city_code' => '04'
            ],
            [
                'id' => '148',
                'regional_name' => 'KOTA BATAM',
                'parent_id' => '143',
                'province_code' => '21',
                'city_code' => '71'
            ],
            [
                'id' => '149',
                'regional_name' => 'KOTA TANJUNG PINANG',
                'parent_id' => '143',
                'province_code' => '21',
                'city_code' => '72'
            ],
            [
                'id' => '150',
                'regional_name' => 'DKI JAKARTA',
                'parent_id' => '',
                'province_code' => '31',
                'city_code' => '00'
            ],
            [
                'id' => '151',
                'regional_name' => 'KAB. KEPULAUAN SERIBU',
                'parent_id' => '150',
                'province_code' => '31',
                'city_code' => '01'
            ],
            [
                'id' => '152',
                'regional_name' => 'KOTA JAKARTA PUSAT',
                'parent_id' => '150',
                'province_code' => '31',
                'city_code' => '73'
            ],
            [
                'id' => '153',
                'regional_name' => 'KOTA JAKARTA UTARA',
                'parent_id' => '150',
                'province_code' => '31',
                'city_code' => '75'
            ],
            [
                'id' => '154',
                'regional_name' => 'KOTA JAKARTA BARAT',
                'parent_id' => '150',
                'province_code' => '31',
                'city_code' => '74'
            ],
            [
                'id' => '155',
                'regional_name' => 'KOTA JAKARTA SELATAN',
                'parent_id' => '150',
                'province_code' => '31',
                'city_code' => '71'
            ],
            [
                'id' => '156',
                'regional_name' => 'KOTA JAKARTA TIMUR',
                'parent_id' => '150',
                'province_code' => '31',
                'city_code' => '72'
            ],
            [
                'id' => '157',
                'regional_name' => 'JAWA BARAT',
                'parent_id' => '',
                'province_code' => '32',
                'city_code' => '00'
            ],
            [
                'id' => '158',
                'regional_name' => 'KAB. BOGOR',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '01'
            ],
            [
                'id' => '159',
                'regional_name' => 'KAB. SUKABUMI',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '02'
            ],
            [
                'id' => '160',
                'regional_name' => 'KAB. CIANJUR',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '03'
            ],
            [
                'id' => '161',
                'regional_name' => 'KAB. BANDUNG',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '04'
            ],
            [
                'id' => '162',
                'regional_name' => 'KAB. GARUT',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '05'
            ],
            [
                'id' => '163',
                'regional_name' => 'KAB. TASIKMALAYA',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '06'
            ],
            [
                'id' => '164',
                'regional_name' => 'KAB. CIAMIS',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '07'
            ],
            [
                'id' => '165',
                'regional_name' => 'KAB. KUNINGAN',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '08'
            ],
            [
                'id' => '166',
                'regional_name' => 'KAB. CIREBON',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '09'
            ],
            [
                'id' => '167',
                'regional_name' => 'KAB. MAJALENGKA',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '10'
            ],
            [
                'id' => '168',
                'regional_name' => 'KAB. SUMEDANG',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '11'
            ],
            [
                'id' => '169',
                'regional_name' => 'KAB. INDRAMAYU',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '12'
            ],
            [
                'id' => '170',
                'regional_name' => 'KAB. SUBANG',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '13'
            ],
            [
                'id' => '171',
                'regional_name' => 'KAB. PURWAKARTA',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '14'
            ],
            [
                'id' => '172',
                'regional_name' => 'KAB. KARAWANG',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '15'
            ],
            [
                'id' => '173',
                'regional_name' => 'KAB. BEKASI',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '16'
            ],
            [
                'id' => '174',
                'regional_name' => 'KAB. BANDUNG BARAT',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '17'
            ],
            [
                'id' => '175',
                'regional_name' => 'KOTA BOGOR',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '71'
            ],
            [
                'id' => '176',
                'regional_name' => 'KOTA SUKABUMI',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '72'
            ],
            [
                'id' => '177',
                'regional_name' => 'KOTA BANDUNG',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '73'
            ],
            [
                'id' => '178',
                'regional_name' => 'KOTA CIREBON',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '74'
            ],
            [
                'id' => '179',
                'regional_name' => 'KOTA BEKASI',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '75'
            ],
            [
                'id' => '180',
                'regional_name' => 'KOTA DEPOK',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '76'
            ],
            [
                'id' => '181',
                'regional_name' => 'KOTA CIMAHI',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '77'
            ],
            [
                'id' => '182',
                'regional_name' => 'KOTA TASIKMALAYA',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '78'
            ],
            [
                'id' => '183',
                'regional_name' => 'KOTA BANJAR',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '79'
            ],
            [
                'id' => '184',
                'regional_name' => 'JAWA TENGAH',
                'parent_id' => '',
                'province_code' => '33',
                'city_code' => '00'
            ],
            [
                'id' => '185',
                'regional_name' => 'KAB. CILACAP',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '01'
            ],
            [
                'id' => '186',
                'regional_name' => 'KAB. BANYUMAS',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '02'
            ],
            [
                'id' => '187',
                'regional_name' => 'KAB. PURBALINGGA',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '03'
            ],
            [
                'id' => '188',
                'regional_name' => 'KAB. BANJARNEGARA',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '04'
            ],
            [
                'id' => '189',
                'regional_name' => 'KAB. KEBUMEN',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '05'
            ],
            [
                'id' => '190',
                'regional_name' => 'KAB. PURWOREJO',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '06'
            ],
            [
                'id' => '191',
                'regional_name' => 'KAB. WONOSOBO',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '07'
            ],
            [
                'id' => '192',
                'regional_name' => 'KAB. MAGELANG',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '08'
            ],
            [
                'id' => '193',
                'regional_name' => 'KAB. BOYOLALI',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '09'
            ],
            [
                'id' => '194',
                'regional_name' => 'KAB. KLATEN',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '10'
            ],
            [
                'id' => '195',
                'regional_name' => 'KAB. SUKOHARJO',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '11'
            ],
            [
                'id' => '196',
                'regional_name' => 'KAB. WONOGIRI',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '12'
            ],
            [
                'id' => '197',
                'regional_name' => 'KAB. KARANGANYAR',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '13'
            ],
            [
                'id' => '198',
                'regional_name' => 'KAB. SRAGEN',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '14'
            ],
            [
                'id' => '199',
                'regional_name' => 'KAB. GROBOGAN',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '15'
            ],
            [
                'id' => '200',
                'regional_name' => 'KAB. BLORA',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '16'
            ],
            [
                'id' => '201',
                'regional_name' => 'KAB. REMBANG',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '17'
            ],
            [
                'id' => '202',
                'regional_name' => 'KAB. PATI',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '18'
            ],
            [
                'id' => '203',
                'regional_name' => 'KAB. KUDUS',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '19'
            ],
            [
                'id' => '204',
                'regional_name' => 'KAB. JEPARA',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '20'
            ],
            [
                'id' => '205',
                'regional_name' => 'KAB. DEMAK',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '21'
            ],
            [
                'id' => '206',
                'regional_name' => 'KAB. SEMARANG',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '22'
            ],
            [
                'id' => '207',
                'regional_name' => 'KAB. TEMANGGUNG',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '23'
            ],
            [
                'id' => '208',
                'regional_name' => 'KAB. KENDAL',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '24'
            ],
            [
                'id' => '209',
                'regional_name' => 'KAB. BATANG',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '25'
            ],
            [
                'id' => '210',
                'regional_name' => 'KAB. PEKALONGAN',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '26'
            ],
            [
                'id' => '211',
                'regional_name' => 'KAB. PEMALANG',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '27'
            ],
            [
                'id' => '212',
                'regional_name' => 'KAB. TEGAL',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '28'
            ],
            [
                'id' => '213',
                'regional_name' => 'KAB. BREBES',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '29'
            ],
            [
                'id' => '214',
                'regional_name' => 'KOTA MAGELANG',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '71'
            ],
            [
                'id' => '215',
                'regional_name' => 'KOTA SURAKARTA',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '72'
            ],
            [
                'id' => '216',
                'regional_name' => 'KOTA SALATIGA',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '73'
            ],
            [
                'id' => '217',
                'regional_name' => 'KOTA SEMARANG',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '74'
            ],
            [
                'id' => '218',
                'regional_name' => 'KOTA PEKALONGAN',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '75'
            ],
            [
                'id' => '219',
                'regional_name' => 'KOTA TEGAL',
                'parent_id' => '184',
                'province_code' => '33',
                'city_code' => '76'
            ],
            [
                'id' => '220',
                'regional_name' => 'DAERAH ISTIMEWA YOGYAKARTA',
                'parent_id' => '',
                'province_code' => '34',
                'city_code' => '00'
            ],
            [
                'id' => '221',
                'regional_name' => 'KAB. KULON PROGO',
                'parent_id' => '220',
                'province_code' => '34',
                'city_code' => '01'
            ],
            [
                'id' => '222',
                'regional_name' => 'KAB. BANTUL',
                'parent_id' => '220',
                'province_code' => '34',
                'city_code' => '02'
            ],
            [
                'id' => '223',
                'regional_name' => 'KAB. GUNUNG KIDUL',
                'parent_id' => '220',
                'province_code' => '34',
                'city_code' => '03'
            ],
            [
                'id' => '224',
                'regional_name' => 'KAB. SLEMAN',
                'parent_id' => '220',
                'province_code' => '34',
                'city_code' => '04'
            ],
            [
                'id' => '225',
                'regional_name' => 'KOTA YOGYAKARTA',
                'parent_id' => '220',
                'province_code' => '34',
                'city_code' => '71'
            ],
            [
                'id' => '226',
                'regional_name' => 'JAWA TIMUR',
                'parent_id' => '',
                'province_code' => '35',
                'city_code' => '00'
            ],
            [
                'id' => '227',
                'regional_name' => 'KAB. PACITAN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '01'
            ],
            [
                'id' => '228',
                'regional_name' => 'KAB. PONOROGO',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '02'
            ],
            [
                'id' => '229',
                'regional_name' => 'KAB. TRENGGALEK',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '03'
            ],
            [
                'id' => '230',
                'regional_name' => 'KAB. TULUNGAGUNG',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '04'
            ],
            [
                'id' => '231',
                'regional_name' => 'KAB. BLITAR',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '05'
            ],
            [
                'id' => '232',
                'regional_name' => 'KAB. KEDIRI',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '06'
            ],
            [
                'id' => '233',
                'regional_name' => 'KAB. MALANG',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '07'
            ],
            [
                'id' => '234',
                'regional_name' => 'KAB. LUMAJANG',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '08'
            ],
            [
                'id' => '235',
                'regional_name' => 'KAB. JEMBER',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '09'
            ],
            [
                'id' => '236',
                'regional_name' => 'KAB. BANYUWANGI',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '10'
            ],
            [
                'id' => '237',
                'regional_name' => 'KAB. BONDOWOSO',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '11'
            ],
            [
                'id' => '238',
                'regional_name' => 'KAB. SITUBONDO',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '12'
            ],
            [
                'id' => '239',
                'regional_name' => 'KAB. PROBOLINGGO',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '13'
            ],
            [
                'id' => '240',
                'regional_name' => 'KAB. PASURUAN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '14'
            ],
            [
                'id' => '241',
                'regional_name' => 'KAB. SIDOARJO',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '15'
            ],
            [
                'id' => '242',
                'regional_name' => 'KAB. MOJOKERTO',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '16'
            ],
            [
                'id' => '243',
                'regional_name' => 'KAB. JOMBANG',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '17'
            ],
            [
                'id' => '244',
                'regional_name' => 'KAB. NGANJUK',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '18'
            ],
            [
                'id' => '245',
                'regional_name' => 'KAB. MADIUN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '19'
            ],
            [
                'id' => '246',
                'regional_name' => 'KAB. MAGETAN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '20'
            ],
            [
                'id' => '247',
                'regional_name' => 'KAB. NGAWI',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '21'
            ],
            [
                'id' => '248',
                'regional_name' => 'KAB. BOJONEGORO',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '22'
            ],
            [
                'id' => '249',
                'regional_name' => 'KAB. TUBAN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '23'
            ],
            [
                'id' => '250',
                'regional_name' => 'KAB. LAMONGAN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '24'
            ],
            [
                'id' => '251',
                'regional_name' => 'KAB. GRESIK',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '25'
            ],
            [
                'id' => '252',
                'regional_name' => 'KAB. BANGKALAN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '26'
            ],
            [
                'id' => '253',
                'regional_name' => 'KAB. SAMPANG',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '27'
            ],
            [
                'id' => '254',
                'regional_name' => 'KAB. PAMEKASAN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '28'
            ],
            [
                'id' => '255',
                'regional_name' => 'KAB. SUMENEP',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '29'
            ],
            [
                'id' => '256',
                'regional_name' => 'KOTA KEDIRI',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '71'
            ],
            [
                'id' => '257',
                'regional_name' => 'KOTA BLITAR',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '72'
            ],
            [
                'id' => '258',
                'regional_name' => 'KOTA MALANG',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '73'
            ],
            [
                'id' => '259',
                'regional_name' => 'KOTA PROBOLINGGO',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '74'
            ],
            [
                'id' => '260',
                'regional_name' => 'KOTA PASURUAN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '75'
            ],
            [
                'id' => '261',
                'regional_name' => 'KOTA MOJOKERTO',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '76'
            ],
            [
                'id' => '262',
                'regional_name' => 'KOTA MADIUN',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '77'
            ],
            [
                'id' => '263',
                'regional_name' => 'KOTA SURABAYA',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '78'
            ],
            [
                'id' => '264',
                'regional_name' => 'KOTA BATU',
                'parent_id' => '226',
                'province_code' => '35',
                'city_code' => '79'
            ],
            [
                'id' => '265',
                'regional_name' => 'BANTEN',
                'parent_id' => '',
                'province_code' => '36',
                'city_code' => '00'
            ],
            [
                'id' => '266',
                'regional_name' => 'KAB. PANDEGLANG',
                'parent_id' => '265',
                'province_code' => '36',
                'city_code' => '01'
            ],
            [
                'id' => '267',
                'regional_name' => 'KAB. LEBAK',
                'parent_id' => '265',
                'province_code' => '36',
                'city_code' => '02'
            ],
            [
                'id' => '268',
                'regional_name' => 'KAB. TANGERANG',
                'parent_id' => '265',
                'province_code' => '36',
                'city_code' => '03'
            ],
            [
                'id' => '269',
                'regional_name' => 'KAB. SERANG',
                'parent_id' => '265',
                'province_code' => '36',
                'city_code' => '04'
            ],
            [
                'id' => '270',
                'regional_name' => 'KOTA TANGERANG',
                'parent_id' => '265',
                'province_code' => '36',
                'city_code' => '71'
            ],
            [
                'id' => '271',
                'regional_name' => 'KOTA CILEGON',
                'parent_id' => '265',
                'province_code' => '36',
                'city_code' => '72'
            ],
            [
                'id' => '272',
                'regional_name' => 'KOTA SERANG',
                'parent_id' => '265',
                'province_code' => '36',
                'city_code' => '73'
            ],
            [
                'id' => '273',
                'regional_name' => 'BALI',
                'parent_id' => '',
                'province_code' => '51',
                'city_code' => '00'
            ],
            [
                'id' => '274',
                'regional_name' => 'KAB. JEMBRANA',
                'parent_id' => '273',
                'province_code' => '51',
                'city_code' => '01'
            ],
            [
                'id' => '275',
                'regional_name' => 'KAB. TABANAN',
                'parent_id' => '273',
                'province_code' => '51',
                'city_code' => '02'
            ],
            [
                'id' => '276',
                'regional_name' => 'KAB. BADUNG',
                'parent_id' => '273',
                'province_code' => '51',
                'city_code' => '03'
            ],
            [
                'id' => '277',
                'regional_name' => 'KAB. GIANYAR',
                'parent_id' => '273',
                'province_code' => '51',
                'city_code' => '04'
            ],
            [
                'id' => '278',
                'regional_name' => 'KAB. KLUNGKUNG',
                'parent_id' => '273',
                'province_code' => '51',
                'city_code' => '05'
            ],
            [
                'id' => '279',
                'regional_name' => 'KAB. BANGLI',
                'parent_id' => '273',
                'province_code' => '51',
                'city_code' => '06'
            ],
            [
                'id' => '280',
                'regional_name' => 'KAB. KARANG ASEM',
                'parent_id' => '273',
                'province_code' => '51',
                'city_code' => '07'
            ],
            [
                'id' => '281',
                'regional_name' => 'KAB. BULELENG',
                'parent_id' => '273',
                'province_code' => '51',
                'city_code' => '08'
            ],
            [
                'id' => '282',
                'regional_name' => 'KOTA DENPASAR',
                'parent_id' => '273',
                'province_code' => '51',
                'city_code' => '71'
            ],
            [
                'id' => '283',
                'regional_name' => 'NUSA TENGGARA BARAT',
                'parent_id' => '',
                'province_code' => '52',
                'city_code' => '00'
            ],
            [
                'id' => '284',
                'regional_name' => 'KAB. LOMBOK BARAT',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '01'
            ],
            [
                'id' => '285',
                'regional_name' => 'KAB. LOMBOK TENGAH',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '02'
            ],
            [
                'id' => '286',
                'regional_name' => 'KAB. LOMBOK TIMUR',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '03'
            ],
            [
                'id' => '287',
                'regional_name' => 'KAB. SUMBAWA',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '04'
            ],
            [
                'id' => '288',
                'regional_name' => 'KAB. DOMPU',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '05'
            ],
            [
                'id' => '289',
                'regional_name' => 'KAB. BIMA',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '06'
            ],
            [
                'id' => '290',
                'regional_name' => 'KAB. SUMBAWA BARAT',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '07'
            ],
            [
                'id' => '291',
                'regional_name' => 'KOTA MATARAM',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '71'
            ],
            [
                'id' => '292',
                'regional_name' => 'KOTA BIMA',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '72'
            ],
            [
                'id' => '293',
                'regional_name' => 'NUSA TENGGARA TIMUR',
                'parent_id' => '',
                'province_code' => '53',
                'city_code' => '00'
            ],
            [
                'id' => '294',
                'regional_name' => 'KAB. KUPANG',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '03'
            ],
            [
                'id' => '295',
                'regional_name' => 'KAB TIMOR TENGAH SELATAN',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '04'
            ],
            [
                'id' => '296',
                'regional_name' => 'KAB. TIMOR TENGAH UTARA',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '05'
            ],
            [
                'id' => '297',
                'regional_name' => 'KAB. BELU',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '06'
            ],
            [
                'id' => '298',
                'regional_name' => 'KAB. ALOR',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '07'
            ],
            [
                'id' => '299',
                'regional_name' => 'KAB. FLORES TIMUR',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '09'
            ],
            [
                'id' => '300',
                'regional_name' => 'KAB. SIKKA',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '10'
            ],
            [
                'id' => '301',
                'regional_name' => 'KAB. ENDE',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '11'
            ],
            [
                'id' => '302',
                'regional_name' => 'KAB. NGADA',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '12'
            ],
            [
                'id' => '303',
                'regional_name' => 'KAB. MANGGARAI',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '13'
            ],
            [
                'id' => '304',
                'regional_name' => 'KAB. SUMBA TIMUR',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '02'
            ],
            [
                'id' => '305',
                'regional_name' => 'KAB. SUMBA BARAT',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '01'
            ],
            [
                'id' => '306',
                'regional_name' => 'KAB. LEMBATA',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '08'
            ],
            [
                'id' => '307',
                'regional_name' => 'KAB. ROTE NDAO',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '14'
            ],
            [
                'id' => '308',
                'regional_name' => 'KAB. MANGGARAI BARAT',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '15'
            ],
            [
                'id' => '309',
                'regional_name' => 'KAB. NAGEKEO',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '18'
            ],
            [
                'id' => '310',
                'regional_name' => 'KAB. SUMBA TENGAH',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '16'
            ],
            [
                'id' => '311',
                'regional_name' => 'KAB. SUMBA BARAT DAYA',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '17'
            ],
            [
                'id' => '312',
                'regional_name' => 'KAB. MANGGARAI TIMUR',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '19'
            ],
            [
                'id' => '313',
                'regional_name' => 'KOTA KUPANG',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '71'
            ],
            [
                'id' => '314',
                'regional_name' => 'KALIMANTAN BARAT',
                'parent_id' => '',
                'province_code' => '61',
                'city_code' => '00'
            ],
            [
                'id' => '315',
                'regional_name' => 'KAB. SAMBAS',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '01'
            ],
            [
                'id' => '317',
                'regional_name' => 'KAB. SANGGAU',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '05'
            ],
            [
                'id' => '318',
                'regional_name' => 'KAB. KETAPANG',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '06'
            ],
            [
                'id' => '319',
                'regional_name' => 'KAB. SINTANG',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '07'
            ],
            [
                'id' => '320',
                'regional_name' => 'KAB. KAPUAS HULU',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '08'
            ],
            [
                'id' => '321',
                'regional_name' => 'KAB. BENGKAYANG',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '02'
            ],
            [
                'id' => '322',
                'regional_name' => 'KAB. LANDAK',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '03'
            ],
            [
                'id' => '323',
                'regional_name' => 'KAB. SEKADAU',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '09'
            ],
            [
                'id' => '324',
                'regional_name' => 'KAB. MELAWI',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '10'
            ],
            [
                'id' => '325',
                'regional_name' => 'KAB. KAYONG UTARA',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '11'
            ],
            [
                'id' => '326',
                'regional_name' => 'KAB. KUBU RAYA',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '12'
            ],
            [
                'id' => '327',
                'regional_name' => 'KOTA PONTIANAK',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '71'
            ],
            [
                'id' => '328',
                'regional_name' => 'KOTA SINGKAWANG',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '72'
            ],
            [
                'id' => '329',
                'regional_name' => 'KALIMANTAN TENGAH',
                'parent_id' => '',
                'province_code' => '62',
                'city_code' => '00'
            ],
            [
                'id' => '330',
                'regional_name' => 'KAB. KOTAWARINGIN BARAT',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '01'
            ],
            [
                'id' => '331',
                'regional_name' => 'KAB. KOTAWARINGIN TIMUR',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '02'
            ],
            [
                'id' => '332',
                'regional_name' => 'KAB. KAPUAS',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '03'
            ],
            [
                'id' => '333',
                'regional_name' => 'KAB. BARITO SELATAN',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '04'
            ],
            [
                'id' => '334',
                'regional_name' => 'KAB. BARITO UTARA',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '05'
            ],
            [
                'id' => '335',
                'regional_name' => 'KAB. KATINGAN',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '09'
            ],
            [
                'id' => '336',
                'regional_name' => 'KAB. SERUYAN',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '08'
            ],
            [
                'id' => '337',
                'regional_name' => 'KAB. SUKAMARA',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '06'
            ],
            [
                'id' => '338',
                'regional_name' => 'KAB. LAMANDAU',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '07'
            ],
            [
                'id' => '339',
                'regional_name' => 'KAB. GUNUNG MAS',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '11'
            ],
            [
                'id' => '340',
                'regional_name' => 'KAB. PULANG PISAU',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '10'
            ],
            [
                'id' => '341',
                'regional_name' => 'KAB. MURUNG RAYA',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '13'
            ],
            [
                'id' => '342',
                'regional_name' => 'KAB. BARITO TIMUR',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '12'
            ],
            [
                'id' => '343',
                'regional_name' => 'KOTA PALANGKA RAYA',
                'parent_id' => '329',
                'province_code' => '62',
                'city_code' => '71'
            ],
            [
                'id' => '344',
                'regional_name' => 'KALIMANTAN SELATAN',
                'parent_id' => '',
                'province_code' => '63',
                'city_code' => '00'
            ],
            [
                'id' => '345',
                'regional_name' => 'KAB. TANAH LAUT',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '01'
            ],
            [
                'id' => '346',
                'regional_name' => 'KAB. KOTABARU',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '02'
            ],
            [
                'id' => '347',
                'regional_name' => 'KAB. BANJAR',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '03'
            ],
            [
                'id' => '348',
                'regional_name' => 'KAB. BARITO KUALA',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '04'
            ],
            [
                'id' => '349',
                'regional_name' => 'KAB. TAPIN',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '05'
            ],
            [
                'id' => '350',
                'regional_name' => 'KAB. HULU SUNGAI SELATAN',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '06'
            ],
            [
                'id' => '351',
                'regional_name' => 'KAB. HULU SUNGAI TENGAH',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '07'
            ],
            [
                'id' => '352',
                'regional_name' => 'KAB. HULU SUNGAI UTARA',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '08'
            ],
            [
                'id' => '353',
                'regional_name' => 'KAB. TABALONG',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '09'
            ],
            [
                'id' => '354',
                'regional_name' => 'KAB. TANAH BUMBU',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '10'
            ],
            [
                'id' => '355',
                'regional_name' => 'KAB. BALANGAN',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '11'
            ],
            [
                'id' => '356',
                'regional_name' => 'KOTA BANJARMASIN',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '71'
            ],
            [
                'id' => '357',
                'regional_name' => 'KOTA BANJAR BARU',
                'parent_id' => '344',
                'province_code' => '63',
                'city_code' => '72'
            ],
            [
                'id' => '358',
                'regional_name' => 'KALIMANTAN TIMUR',
                'parent_id' => '',
                'province_code' => '64',
                'city_code' => '00'
            ],
            [
                'id' => '359',
                'regional_name' => 'KAB. PASER',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '01'
            ],
            [
                'id' => '360',
                'regional_name' => 'KAB. KUTAI KARTANEGARA',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '03'
            ],
            [
                'id' => '361',
                'regional_name' => 'KAB. BERAU',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '05'
            ],
            [
                'id' => '362',
                'regional_name' => 'KAB. BULUNGAN',
                'parent_id' => '523',
                'province_code' => '65',
                'city_code' => '02'
            ],
            [
                'id' => '363',
                'regional_name' => 'KAB. NUNUKAN',
                'parent_id' => '523',
                'province_code' => '65',
                'city_code' => '04'
            ],
            [
                'id' => '364',
                'regional_name' => 'KAB. MALINAU',
                'parent_id' => '523',
                'province_code' => '65',
                'city_code' => '01'
            ],
            [
                'id' => '365',
                'regional_name' => 'KAB. KUTAI BARAT',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '02'
            ],
            [
                'id' => '366',
                'regional_name' => 'KAB. KUTAI TIMUR',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '04'
            ],
            [
                'id' => '367',
                'regional_name' => 'KAB. PENAJAM PASER UTARA',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '09'
            ],
            [
                'id' => '368',
                'regional_name' => 'KAB. TANA TIDUNG',
                'parent_id' => '523',
                'province_code' => '65',
                'city_code' => '03'
            ],
            [
                'id' => '369',
                'regional_name' => 'KOTA BALIKPAPAN',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '71'
            ],
            [
                'id' => '370',
                'regional_name' => 'KOTA SAMARINDA',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '72'
            ],
            [
                'id' => '371',
                'regional_name' => 'KOTA TARAKAN',
                'parent_id' => '523',
                'province_code' => '65',
                'city_code' => '71'
            ],
            [
                'id' => '372',
                'regional_name' => 'KOTA BONTANG',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '74'
            ],
            [
                'id' => '373',
                'regional_name' => 'SULAWESI UTARA',
                'parent_id' => '',
                'province_code' => '71',
                'city_code' => '00'
            ],
            [
                'id' => '374',
                'regional_name' => 'KAB BOLAANG MONGONDOW',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '01'
            ],
            [
                'id' => '375',
                'regional_name' => 'KAB. MINAHASA',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '02'
            ],
            [
                'id' => '376',
                'regional_name' => 'KAB. KEPULAUAN SANGIHE',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '03'
            ],
            [
                'id' => '377',
                'regional_name' => 'KAB. KEPULAUAN TALAUD',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '04'
            ],
            [
                'id' => '378',
                'regional_name' => 'KAB. MINAHASA SELATAN',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '05'
            ],
            [
                'id' => '379',
                'regional_name' => 'KAB. MINAHASA UTARA',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '06'
            ],
            [
                'id' => '380',
                'regional_name' => 'KAB. MINAHASA TENGGARA',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '09'
            ],
            [
                'id' => '381',
                'regional_name' => 'KAB. BOLAANG MONGONDOW UTARA',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '07'
            ],
            [
                'id' => '383',
                'regional_name' => 'KOTA MANADO',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '71'
            ],
            [
                'id' => '384',
                'regional_name' => 'KOTA BITUNG',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '72'
            ],
            [
                'id' => '385',
                'regional_name' => 'KOTA TOMOHON',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '73'
            ],
            [
                'id' => '386',
                'regional_name' => 'KOTA KOTAMOBAGU',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '74'
            ],
            [
                'id' => '387',
                'regional_name' => 'SULAWESI TENGAH',
                'parent_id' => '',
                'province_code' => '72',
                'city_code' => '00'
            ],
            [
                'id' => '388',
                'regional_name' => 'KAB. BANGGAI',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '02'
            ],
            [
                'id' => '389',
                'regional_name' => 'KAB. POSO',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '04'
            ],
            [
                'id' => '390',
                'regional_name' => 'KAB. DONGGALA',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '05'
            ],
            [
                'id' => '391',
                'regional_name' => 'KAB. TOLI-TOLI',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '06'
            ],
            [
                'id' => '392',
                'regional_name' => 'KAB. BUOL',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '07'
            ],
            [
                'id' => '393',
                'regional_name' => 'KAB. MOROWALI',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '03'
            ],
            [
                'id' => '394',
                'regional_name' => 'KAB BANGGAI KEPULAUAN',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '01'
            ],
            [
                'id' => '395',
                'regional_name' => 'KAB. PARIGI MOUTONG',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '08'
            ],
            [
                'id' => '396',
                'regional_name' => 'KAB. TOJO UNA-UNA',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '09'
            ],
            [
                'id' => '397',
                'regional_name' => 'KOTA PALU',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '71'
            ],
            [
                'id' => '398',
                'regional_name' => 'SULAWESI SELATAN',
                'parent_id' => '',
                'province_code' => '73',
                'city_code' => '00'
            ],
            [
                'id' => '399',
                'regional_name' => 'KAB. KEPULAUAN SELAYAR',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '01'
            ],
            [
                'id' => '400',
                'regional_name' => 'KAB. BULUKUMBA',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '02'
            ],
            [
                'id' => '401',
                'regional_name' => 'KAB. BANTAENG',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '03'
            ],
            [
                'id' => '402',
                'regional_name' => 'KAB. JENEPONTO',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '04'
            ],
            [
                'id' => '403',
                'regional_name' => 'KAB. TAKALAR',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '05'
            ],
            [
                'id' => '404',
                'regional_name' => 'KAB. GOWA',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '06'
            ],
            [
                'id' => '405',
                'regional_name' => 'KAB. SINJAI',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '07'
            ],
            [
                'id' => '406',
                'regional_name' => 'KAB. BONE',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '11'
            ],
            [
                'id' => '407',
                'regional_name' => 'KAB. MAROS',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '08'
            ],
            [
                'id' => '408',
                'regional_name' => 'KAB. PANGKAJENE DAN KEPULAUAN',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '09'
            ],
            [
                'id' => '409',
                'regional_name' => 'KAB. BARRU',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '10'
            ],
            [
                'id' => '410',
                'regional_name' => 'KAB. SOPPENG',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '12'
            ],
            [
                'id' => '411',
                'regional_name' => 'KAB. WAJO',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '13'
            ],
            [
                'id' => '412',
                'regional_name' => 'KAB. SIDENRENG RAPPANG',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '14'
            ],
            [
                'id' => '413',
                'regional_name' => 'KAB. PINRANG',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '15'
            ],
            [
                'id' => '414',
                'regional_name' => 'KAB. ENREKANG',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '16'
            ],
            [
                'id' => '415',
                'regional_name' => 'KAB. LUWU',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '17'
            ],
            [
                'id' => '416',
                'regional_name' => 'KAB. TANA TORAJA',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '18'
            ],
            [
                'id' => '417',
                'regional_name' => 'KAB. LUWU UTARA',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '22'
            ],
            [
                'id' => '418',
                'regional_name' => 'KAB. LUWU TIMUR',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '25'
            ],
            [
                'id' => '419',
                'regional_name' => 'KOTA MAKASSAR',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '71'
            ],
            [
                'id' => '420',
                'regional_name' => 'KOTA PAREPARE',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '72'
            ],
            [
                'id' => '421',
                'regional_name' => 'KOTA PALOPO',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '73'
            ],
            [
                'id' => '422',
                'regional_name' => 'SULAWESI TENGGARA',
                'parent_id' => '',
                'province_code' => '74',
                'city_code' => '00'
            ],
            [
                'id' => '423',
                'regional_name' => 'KAB. KOLAKA',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '04'
            ],
            [
                'id' => '424',
                'regional_name' => 'KAB. KONAWE',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '03'
            ],
            [
                'id' => '425',
                'regional_name' => 'KAB. MUNA',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '02'
            ],
            [
                'id' => '426',
                'regional_name' => 'KAB. BUTON',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '01'
            ],
            [
                'id' => '427',
                'regional_name' => 'KAB. KONAWE SELATAN',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '05'
            ],
            [
                'id' => '428',
                'regional_name' => 'KAB. BOMBANA',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '06'
            ],
            [
                'id' => '429',
                'regional_name' => 'KAB. WAKATOBI',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '07'
            ],
            [
                'id' => '430',
                'regional_name' => 'KAB. KOLAKA UTARA',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '08'
            ],
            [
                'id' => '431',
                'regional_name' => 'KAB. KONAWE UTARA',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '10'
            ],
            [
                'id' => '432',
                'regional_name' => 'KAB. BUTON UTARA',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '09'
            ],
            [
                'id' => '433',
                'regional_name' => 'KOTA KENDARI',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '71'
            ],
            [
                'id' => '434',
                'regional_name' => 'KOTA BAUBAU',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '72'
            ],
            [
                'id' => '435',
                'regional_name' => 'GORONTALO',
                'parent_id' => '',
                'province_code' => '75',
                'city_code' => '00'
            ],
            [
                'id' => '436',
                'regional_name' => 'KAB. GORONTALO',
                'parent_id' => '435',
                'province_code' => '75',
                'city_code' => '02'
            ],
            [
                'id' => '437',
                'regional_name' => 'KAB. BOALEMO',
                'parent_id' => '435',
                'province_code' => '75',
                'city_code' => '01'
            ],
            [
                'id' => '438',
                'regional_name' => 'KAB. BONE BOLANGO',
                'parent_id' => '435',
                'province_code' => '75',
                'city_code' => '04'
            ],
            [
                'id' => '439',
                'regional_name' => 'KAB. PAHUWATO',
                'parent_id' => '435',
                'province_code' => '75',
                'city_code' => '03'
            ],
            [
                'id' => '440',
                'regional_name' => 'KAB. GORONTALO UTARA',
                'parent_id' => '435',
                'province_code' => '75',
                'city_code' => '05'
            ],
            [
                'id' => '441',
                'regional_name' => 'KOTA GORONTALO',
                'parent_id' => '435',
                'province_code' => '75',
                'city_code' => '71'
            ],
            [
                'id' => '442',
                'regional_name' => 'SULAWESI BARAT',
                'parent_id' => '',
                'province_code' => '76',
                'city_code' => '00'
            ],
            [
                'id' => '443',
                'regional_name' => 'KAB. MAMUJU UTARA',
                'parent_id' => '442',
                'province_code' => '76',
                'city_code' => '05'
            ],
            [
                'id' => '444',
                'regional_name' => 'KAB. MAMUJU',
                'parent_id' => '442',
                'province_code' => '76',
                'city_code' => '04'
            ],
            [
                'id' => '445',
                'regional_name' => 'KAB. MAMASA',
                'parent_id' => '442',
                'province_code' => '76',
                'city_code' => '03'
            ],
            [
                'id' => '446',
                'regional_name' => 'KAB. POLEWALI MANDAR',
                'parent_id' => '442',
                'province_code' => '76',
                'city_code' => '02'
            ],
            [
                'id' => '447',
                'regional_name' => 'KAB. MAJENE',
                'parent_id' => '442',
                'province_code' => '76',
                'city_code' => '01'
            ],
            [
                'id' => '448',
                'regional_name' => 'MALUKU',
                'parent_id' => '',
                'province_code' => '81',
                'city_code' => '00'
            ],
            [
                'id' => '449',
                'regional_name' => 'KAB. MALUKU TENGAH',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '03'
            ],
            [
                'id' => '450',
                'regional_name' => 'KAB. MALUKU TENGGARA',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '02'
            ],
            [
                'id' => '451',
                'regional_name' => 'KAB. MALUKU TENGGARA BARAT',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '01'
            ],
            [
                'id' => '452',
                'regional_name' => 'KAB. BURU',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '04'
            ],
            [
                'id' => '453',
                'regional_name' => 'KAB. SERAM BAGIAN TIMUR',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '07'
            ],
            [
                'id' => '454',
                'regional_name' => 'KAB. SERAM BAGIAN BARAT',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '06'
            ],
            [
                'id' => '455',
                'regional_name' => 'KAB. KEPULAUAN ARU',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '05'
            ],
            [
                'id' => '456',
                'regional_name' => 'KOTA AMBON',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '71'
            ],
            [
                'id' => '457',
                'regional_name' => 'KOTA TUAL',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '71'
            ],
            [
                'id' => '458',
                'regional_name' => 'MALUKU UTARA',
                'parent_id' => '',
                'province_code' => '82',
                'city_code' => '00'
            ],
            [
                'id' => '459',
                'regional_name' => 'KAB. HALMAHERA BARAT',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '01'
            ],
            [
                'id' => '460',
                'regional_name' => 'KAB. HALMAHERA TENGAH',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '02'
            ],
            [
                'id' => '461',
                'regional_name' => 'KAB. HALMAHERA UTARA',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '05'
            ],
            [
                'id' => '462',
                'regional_name' => 'KAB. HALMAHERA SELATAN',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '04'
            ],
            [
                'id' => '463',
                'regional_name' => 'KAB. KEPULAUAN SULA',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '03'
            ],
            [
                'id' => '464',
                'regional_name' => 'KAB. HALMAHERA TIMUR',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '06'
            ],
            [
                'id' => '465',
                'regional_name' => 'KOTA TERNATE',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '71'
            ],
            [
                'id' => '466',
                'regional_name' => 'KOTA TIDORE KEPULAUAN',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '72'
            ],
            [
                'id' => '467',
                'regional_name' => 'PAPUA',
                'parent_id' => '',
                'province_code' => '94',
                'city_code' => '00'
            ],
            [
                'id' => '468',
                'regional_name' => 'KAB. MERAUKE',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '01'
            ],
            [
                'id' => '469',
                'regional_name' => 'KAB. JAYAWIJAYA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '02'
            ],
            [
                'id' => '470',
                'regional_name' => 'KAB. JAYAPURA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '03'
            ],
            [
                'id' => '471',
                'regional_name' => 'KAB. NABIRE',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '04'
            ],
            [
                'id' => '473',
                'regional_name' => 'KAB. BIAK NUMFOR',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '09'
            ],
            [
                'id' => '474',
                'regional_name' => 'KAB. PUNCAK JAYA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '11'
            ],
            [
                'id' => '475',
                'regional_name' => 'KAB. PANIAI',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '10'
            ],
            [
                'id' => '476',
                'regional_name' => 'KAB. MIMIKA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '12'
            ],
            [
                'id' => '477',
                'regional_name' => 'KAB. SARMI',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '19'
            ],
            [
                'id' => '478',
                'regional_name' => 'KAB. KEEROM',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '20'
            ],
            [
                'id' => '479',
                'regional_name' => 'KAB. PEGUNUNGAN BINTANG',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '17'
            ],
            [
                'id' => '480',
                'regional_name' => 'KAB. YAHUKIMO',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '16'
            ],
            [
                'id' => '481',
                'regional_name' => 'KAB. TOLIKARA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '18'
            ],
            [
                'id' => '482',
                'regional_name' => 'KAB. WAROPEN',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '26'
            ],
            [
                'id' => '483',
                'regional_name' => 'KAB. BOVEN DIGOEL',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '13'
            ],
            [
                'id' => '484',
                'regional_name' => 'KAB. MAPPI',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '14'
            ],
            [
                'id' => '485',
                'regional_name' => 'KAB. ASMAT',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '15'
            ],
            [
                'id' => '486',
                'regional_name' => 'KAB. SUPIORI',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '27'
            ],
            [
                'id' => '487',
                'regional_name' => 'KAB. MAMBERAMO RAYA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '28'
            ],
            [
                'id' => '488',
                'regional_name' => 'KOTA JAYAPURA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '71'
            ],
            [
                'id' => '489',
                'regional_name' => 'PAPUA BARAT',
                'parent_id' => '',
                'province_code' => '91',
                'city_code' => '00'
            ],
            [
                'id' => '490',
                'regional_name' => 'KAB. SORONG',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '07'
            ],
            [
                'id' => '491',
                'regional_name' => 'KAB. MANOKWARI',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '05'
            ],
            [
                'id' => '492',
                'regional_name' => 'KAB. FAKFAK',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '01'
            ],
            [
                'id' => '493',
                'regional_name' => 'KAB. SORONG SELATAN',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '06'
            ],
            [
                'id' => '494',
                'regional_name' => 'KAB. RAJA AMPAT',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '08'
            ],
            [
                'id' => '495',
                'regional_name' => 'KAB. TELUK BENTUNI',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '04'
            ],
            [
                'id' => '496',
                'regional_name' => 'KAB. TELUK WONDAMA',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '03'
            ],
            [
                'id' => '497',
                'regional_name' => 'KAB. KAIMANA',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '02'
            ],
            [
                'id' => '498',
                'regional_name' => 'KOTA SORONG',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '71'
            ],
            [
                'id' => '499',
                'regional_name' => 'KAB. LABUHAN BATU SELATAN',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '22'
            ],
            [
                'id' => '500',
                'regional_name' => 'KAB. LABUHAN BATU UTARA',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '23'
            ],
            [
                'id' => '501',
                'regional_name' => 'KAB. NIAS UTARA',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '24'
            ],
            [
                'id' => '502',
                'regional_name' => 'KAB. NIAS BARAT',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '25'
            ],
            [
                'id' => '503',
                'regional_name' => 'KOTA GUNUNGSITOLI',
                'parent_id' => '25',
                'province_code' => '12',
                'city_code' => '78'
            ],
            [
                'id' => '504',
                'regional_name' => 'KAB. KEPULAUAN MERANTI',
                'parent_id' => '74',
                'province_code' => '14',
                'city_code' => '10'
            ],
            [
                'id' => '505',
                'regional_name' => 'KOTA SUNGAI PENUH',
                'parent_id' => '86',
                'province_code' => '15',
                'city_code' => '72'
            ],
            [
                'id' => '506',
                'regional_name' => 'KAB. OGAN KOMERING ULU SELATAN',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '08'
            ],
            [
                'id' => '507',
                'regional_name' => 'KAB. OGAN KOMERING ULU TIMUR',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '09'
            ],
            [
                'id' => '508',
                'regional_name' => 'KAB. PENUKAL ABAB LEMATANG ILIR',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '12'
            ],
            [
                'id' => '509',
                'regional_name' => 'KAB. MUSI RAWAS UTARA',
                'parent_id' => '97',
                'province_code' => '16',
                'city_code' => '13'
            ],
            [
                'id' => '510',
                'regional_name' => 'KAB. BENGKULU TENGAH',
                'parent_id' => '113',
                'province_code' => '17',
                'city_code' => '09'
            ],
            [
                'id' => '511',
                'regional_name' => 'KAB. PRINGSEWU',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '10'
            ],
            [
                'id' => '512',
                'regional_name' => 'KAB. MESUJI',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '11'
            ],
            [
                'id' => '513',
                'regional_name' => 'KAB. TULANG BAWANG BARAT',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '12'
            ],
            [
                'id' => '514',
                'regional_name' => 'KAB. PESISIR BARAT',
                'parent_id' => '123',
                'province_code' => '18',
                'city_code' => '13'
            ],
            [
                'id' => '515',
                'regional_name' => 'KAB. KEPULAUAN ANAMBAS',
                'parent_id' => '143',
                'province_code' => '21',
                'city_code' => '05'
            ],
            [
                'id' => '516',
                'regional_name' => 'KAB. PANGANDARAN',
                'parent_id' => '157',
                'province_code' => '32',
                'city_code' => '18'
            ],
            [
                'id' => '517',
                'regional_name' => 'KOTA TANGERANG SELATAN',
                'parent_id' => '265',
                'province_code' => '36',
                'city_code' => '74'
            ],
            [
                'id' => '518',
                'regional_name' => 'KAB. LOMBOK UTARA',
                'parent_id' => '283',
                'province_code' => '52',
                'city_code' => '08'
            ],
            [
                'id' => '519',
                'regional_name' => 'KAB. SABU RAIJUA',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '20'
            ],
            [
                'id' => '520',
                'regional_name' => 'KAB. MALAKA',
                'parent_id' => '293',
                'province_code' => '53',
                'city_code' => '21'
            ],
            [
                'id' => '521',
                'regional_name' => 'KAB. MEMPAWAH',
                'parent_id' => '314',
                'province_code' => '61',
                'city_code' => '04'
            ],
            [
                'id' => '522',
                'regional_name' => 'KAB. MAHAKAM HULU',
                'parent_id' => '358',
                'province_code' => '64',
                'city_code' => '11'
            ],
            [
                'id' => '523',
                'regional_name' => 'KALIMANTAN UTARA',
                'parent_id' => '',
                'province_code' => '65',
                'city_code' => '00'
            ],
            [
                'id' => '524',
                'regional_name' => 'KAB. SIAU TAGULANDANG BIARO',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '08'
            ],
            [
                'id' => '525',
                'regional_name' => 'KAB. BOLAANG MONGONDOW SELATAN',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '10'
            ],
            [
                'id' => '526',
                'regional_name' => 'KAB. BOLAANG MONGONDOW TIMUR',
                'parent_id' => '373',
                'province_code' => '71',
                'city_code' => '11'
            ],
            [
                'id' => '527',
                'regional_name' => 'KAB. SIGI',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '10'
            ],
            [
                'id' => '528',
                'regional_name' => 'KAB. BANGGAI LAUT',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '11'
            ],
            [
                'id' => '529',
                'regional_name' => 'KAB. MOROWALI UTARA',
                'parent_id' => '387',
                'province_code' => '72',
                'city_code' => '12'
            ],
            [
                'id' => '530',
                'regional_name' => 'KAB. TORAJA UTARA',
                'parent_id' => '398',
                'province_code' => '73',
                'city_code' => '26'
            ],
            [
                'id' => '531',
                'regional_name' => 'KAB. KOLAKA TIMUR',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '11'
            ],
            [
                'id' => '532',
                'regional_name' => 'KAB. KONAWE KEPULAUAN',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '12'
            ],
            [
                'id' => '533',
                'regional_name' => 'KAB. MUNA BARAT',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '13'
            ],
            [
                'id' => '534',
                'regional_name' => 'KAB. BUTON TENGAH',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '14'
            ],
            [
                'id' => '535',
                'regional_name' => 'KAB. BUTON SELATAN',
                'parent_id' => '422',
                'province_code' => '74',
                'city_code' => '15'
            ],
            [
                'id' => '536',
                'regional_name' => 'KAB. MAMUJU TENGAH',
                'parent_id' => '442',
                'province_code' => '76',
                'city_code' => '06'
            ],
            [
                'id' => '537',
                'regional_name' => 'KAB. MALUKU BARAT DAYA',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '08'
            ],
            [
                'id' => '538',
                'regional_name' => 'KAB. BURU SELATAN',
                'parent_id' => '448',
                'province_code' => '81',
                'city_code' => '09'
            ],
            [
                'id' => '539',
                'regional_name' => 'KAB. PULAU MOROTAI',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '07'
            ],
            [
                'id' => '540',
                'regional_name' => 'KAB. PULAU TALIABU',
                'parent_id' => '458',
                'province_code' => '82',
                'city_code' => '08'
            ],
            [
                'id' => '541',
                'regional_name' => 'KAB. TAMBRAUW',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '09'
            ],
            [
                'id' => '542',
                'regional_name' => 'KAB. MAYBRAT',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '10'
            ],
            [
                'id' => '543',
                'regional_name' => 'KAB. MANOKWARI SELATAN',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '11'
            ],
            [
                'id' => '544',
                'regional_name' => 'KAB. PEGUNUNGAN ARFAK',
                'parent_id' => '489',
                'province_code' => '91',
                'city_code' => '12'
            ],
            [
                'id' => '545',
                'regional_name' => 'KAB. KEPULAUAN YAPEN',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '08'
            ],
            [
                'id' => '546',
                'regional_name' => 'KAB. NDUGA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '29'
            ],
            [
                'id' => '547',
                'regional_name' => 'KAB. LANNY JAYA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '30'
            ],
            [
                'id' => '548',
                'regional_name' => 'KAB. MAMBERAMO TENGAH',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '31'
            ],
            [
                'id' => '549',
                'regional_name' => 'KAB. YALIMO',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '32'
            ],
            [
                'id' => '550',
                'regional_name' => 'KAB. PUNCAK',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '33'
            ],
            [
                'id' => '551',
                'regional_name' => 'KAB. DOGIYAI',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '34'
            ],
            [
                'id' => '552',
                'regional_name' => 'KAB. INTAN JAYA',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '35'
            ],
            [
                'id' => '553',
                'regional_name' => 'KAB. DEIYAI',
                'parent_id' => '467',
                'province_code' => '94',
                'city_code' => '36'
            ],
        ];

        $datas = $this->table('regionals');
        $datas->insert($data)
              ->save();
    }
}
