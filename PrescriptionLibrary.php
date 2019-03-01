<?php

include 'database.php';

///////////////////////////////////////////////////////

$remedy_array = "SELECT * FROM PrescriptionRemedyMaster";

$remedy_query = $con->query($remedy_array);

while($remedy_data = mysqli_fetch_assoc($remedy_query))
{
	$remedy_id_array[] = $remedy_data['RemedyID'];
	$remedy_data_new[] = $remedy_data['RemedyName'];
}	
	$final_remedy_data = array_combine($remedy_id_array,$remedy_data_new);
	$final_remedy_data = array_map("strtolower",$final_remedy_data);

/////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////

$potency_array = "SELECT * FROM PrescriptionPotencyMaster";

$potency_query = $con->query($potency_array);

while($potency_data = mysqli_fetch_assoc($potency_query))
{
	$id_data_new[] = $potency_data['PotencyID'];
	$potency_data_new[] = $potency_data['PotencyName'];
}
	$final_potency_data = array_combine($id_data_new,$potency_data_new);
	$final_potency_data = array_map("strtolower",$final_potency_data);

//////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////

$repetition_array = "SELECT * FROM PrescriptionRepetitionMaster";

$repetition_query = $con->query($repetition_array);

while($repetition_data = mysqli_fetch_assoc($repetition_query))
{
	$repitition_id_array[] = $repetition_data['RepetitionID'];
	$repetition_data_new[] = $repetition_data['RepetitionName'];
}

$final_repetition_data = array_combine($repitition_id_array,$repetition_data_new);
$final_repetition_data = array_map("strtolower",$final_repetition_data);

//////////////////////////////////////////////////////////////

$dosage_array = "SELECT * FROM PrescriptionDosageMaster";

$dosage_query = $con->query($dosage_array);

while($dosage_data = mysqli_fetch_assoc($dosage_query))
{
	$dosage_id_array[] = $dosage_data['DosageID'];
	$dosage_data_new[] = $dosage_data['DosageName'];
}	
	$final_dosage_data = array_combine($dosage_id_array,$dosage_data_new);
	$final_dosage_data = array_map("strtolower",$final_dosage_data);

///////////////////////////////////////////////////////////

$days_array = "SELECT * FROM PrescriptionDaysMaster";

$days_query = $con->query($days_array);

while($days_data = mysqli_fetch_assoc($days_query))
{
	$days_id_array[] = $days_data['DaysID'];
	$days_data_new[] = $days_data['Days'];
}	
	$final_days_data = array_combine($days_id_array,$days_data_new);
	$final_days_data = array_map("strtolower",$final_days_data);

//////////////////////////////////////////////////////////////////////////

function get_remedy_id($remedy)
{
	$remedy = strtolower($remedy);

	if($remedy == 'ts220' || $remedy == 'ts 220' || $remedy == 'ts-220')
	{
		return 64;
		exit;
	}
	if($remedy == 'ts221' || $remedy == 'ts 221' || $remedy == 'ts-221')
	{
		return 65;
		exit;
	}
	if($remedy == 'ts121' || $remedy == 'ts 121' || $remedy == 'ts-121')
	{
		return 71;
		exit;
	}

	$remedy = preg_replace("/[^A-Za-z' -.=]/","",$remedy);
	$remedy = trim($remedy);

	if($remedy == '')
	{
		return 111;
	}
	else
	{
		// echo "<pre>";
		// print_r($remedy);
		// echo "</pre>";

		global $final_remedy_data;

		$remedy = strtolower($remedy);

		if(strlen($remedy) > 4 && substr_count($remedy,'sos') > 0)
		{
			$remedy = str_replace('sos',"",$remedy);
			$remedy = str_replace('-',"",$remedy);
		}
		
		//$remedy = str_replace(array(" ","  ",".","*",",",";","?"),"",$remedy);
		if($remedy == 'b' || $remedy == 'a' || $remedy == 'c' || $remedy == 'n')
		{
			return 0;
			exit;
		}
		if($remedy == 'u' || $remedy == '-u-')
		{
			$remedy = 'ars';
		}
		if($remedy == 'bell')
		{
			$remedy = '69';
			return $remedy;
			exit;
		}
		if($remedy == 'nat.s' || $remedy == 'nat-s' || $remedy == 'nat.')
		{
			$remedy = '44';
			return $remedy;
			exit;
		}
		if($remedy == 'ant-c' || $remedy == 'antim crud' || $remedy == 'ant.crud' || $remedy == 'antim-crud' || $remedy == 'antim-c' || strpos($remedy,'ant-c') !== false || $remedy == 'abt-c' || $remedy == 'antm-crud' || $remedy == 'abt-crud' || $remedy == 'at-c' || $remedy == 'an-crud' || $remedy == 'anct-crud' || $remedy == 'anti-crud' || $remedy == 'ant crud' || $remedy == 'ant.c' || $remedy == 'ant.cr' || $remedy == 'antim.c') 
		{
			$remedy = '1';
			return $remedy;
			exit;
		}
		if($remedy == 'sl' || $remedy == 's.l.' || $remedy == 's.l' || $remedy == 'sca-lac' || $remedy == 'sac lac' || $remedy == 'sac' || $remedy == 'saclrum' || $remedy == 's l ' || $remedy == 'sa-lac' || $remedy == '-sac-lact' || $remedy == 'saclac' || $remedy == 'phytum' || $remedy == 'sac lav' || $remedy =='sac-lactum' || $remedy == 'sac-lsc' || $remedy == 'sac-lax' || $remedy == 'sac-alc' || $remedy == 'sac-lacrtis' || $remedy == 'sac-lacv' || $remedy == 'saclac.....' || $remedy == 'sac-lac0'|| $remedy == 'sc-lac' || $remedy == 'sac-alb' || $remedy == 'sax-lax' || $remedy == 'sacr' || $remedy == 's-l-' || $remedy == 'sca-lact' || $remedy == 'xac-lac' || $remedy == 'saxc-lac' || $remedy == 'adsl' || strpos($remedy, 'sac') !== false || $remedy == 'sca-lav' || $remedy == 'sctes-lac' || $remedy == 'saqc-lac' || $remedy == 'swac-lac' || $remedy == 'sax-lac' || $remedy == 'sca--lac' || $remedy == 'sca=lac' || $remedy == 'sav-lac' || $remedy == 'scsa-lac' || $remedy == 'sl sabal' || $remedy == 'sc-lax' || $remedy == 'abel' || $remedy == 'abc' || $remedy == 'absin' || strpos($remedy, 'adsl') !== false || $remedy == 'no pudis' || $remedy == 'straia' || $remedy == 'insm' || $remedy == 'in sm' || $remedy == 'ddd' || $remedy == 'fgcffg' || $remedy == 'fh' || $remedy == 'ghh' || $remedy == 'gkj' || $remedy == 'hm' || $remedy == 'phytum' || $remedy == 'ps' || strpos($remedy, 'pseuts') !== false || $remedy == 'saal' || $remedy == 'hydrocotyle' || $remedy == 'hydrcotl' || $remedy == 'hydroc' || $remedy == 'phyttum' || $remedy == 'scalacv' || $remedy == 'sal' || $remedy == 'hshs' || $remedy == 'hydr' || $remedy == 'hy' || $remedy == 'sl bds' || $remedy == 'sdac-lac' || $remedy == 'hydrocot' || $remedy == 'saac-lac' || $remedy == 'hydroct' || $remedy == 'sasc-lac' || $remedy == 'phytumm' || $remedy == 'dac-lac' || $remedy == 'hydrocityle' || $remedy == 'hydro' || $remedy == 'hydrcot' || $remedy == 'bggg' || $remedy == 'savc-lac' || $remedy == 'ad' || $remedy == 'ad ps' || $remedy == 'adps' || $remedy == 'ps' || $remedy == 'rs' || $remedy == 'hydro-c' || $remedy == 'hydrc' || $remedy == 'hydrocotyle++' || $remedy == 'phytum++' || $remedy == 'sc-laca' || $remedy == 'hhh' || $remedy == 'ad-ps' || $remedy == 'asl' || $remedy == 'aad ps' || $remedy == 'ps  ad' || $remedy == 'pd' || $remedy == 'ps ad' || $remedy == 'ad ps -' || $remedy == 'saac-lsc' || $remedy == 'sac-cla') 
		{
			$remedy = 'sac-lac';
		}

		if($remedy == 'hep.s' || $remedy == 'hep-s' || $remedy == 'hep-sulph' || $remedy == 'heps' || $remedy == 'hep+s')
		{
			$remedy = 'hep-sulp';
		}
		if($remedy == 'rt sos' || $remedy == 'rhus-t' || $remedy == 'rhus' || $remedy == 'r t' || $remedy == 'rt' || $remedy == 'rhust-t' || $remedy == 'rhus-tpx' || $remedy == 'rhus-tox-30' || $remedy == 'rhus-ox' || $remedy == 'rhus tox' || $remedy == 'rhist-tox' || $remedy == 'rt-' || $remedy == 'rhus-toax' || $remedy == 'rhis-tox' || $remedy == 'rhust-com' || $remedy == 'rhust' || $remedy == 'rhust-tox' || $remedy == 'rhs-t' || $remedy == 'rhut-tor' || $remedy == 'rahus-tox' || $remedy == 'rhus-toxx' || $remedy == 'r.t' || $remedy == 'rhut-tox')
		{
			$remedy = 'rhus-tox';
		}
		if(strpos($remedy, 'r') !== false && strpos($remedy, 's') !== false && strpos($remedy, 't') !== false && strpos($remedy, 'u') !== false)
		{
			$remedy = 'rhus-tox';
		}
		if($remedy == 'ss' || $remedy == 'sarc')
		{
			$remedy = 'sarsaparila';
		}
		if($remedy == 'sulph' || $remedy == 'supph' || $remedy == 'sulplh' || $remedy == 'suplh' || $remedy == 'suloh' || $remedy == 'sulp' || $remedy == 'slph' || $remedy == 'sulp-i' || $remedy == 'ulphs' || $remedy == 'suph 30 dd' || $remedy == 'suph')
		{
			$remedy = '59';
			return $remedy;
			exit;
		}
		if(strpos($remedy, 'apis') !== false || $remedy == 'aps' || $remedy == 'apiis') //new
		{
			$remedy = 'apis-mel';
		}
		if(strpos($remedy, 'nott') !== false || strpos($remedy, 'no tt') !== false || strpos($remedy, 'no-tt') !== false || strpos($remedy, 'nptt') !== false || $remedy == 'no t.t' || $remedy == 'no.tt' || $remedy == 'note-s tt')
		{
			$remedy = 'antim-tart';
		}
		if($remedy == 'ananc')
		{
			$remedy = 'anac';
		}
		if($remedy == 'acid-mur' || $remedy == 'mur-ac')
		{
			$remedy = '66';
			return $remedy;
			exit;
		}
		if($remedy == 'cad-s' || $remedy == 'card-s' || $remedy == 'cad.s.' || $remedy == 'cadm-s')
		{
			$remedy = '68';
			return $remedy;
			exit;
		}
		if($remedy == 'kali ars' || $remedy == 'kali-qrs' || $remedy == 'kali--ars' || $remedy == 'kali-1rs' || $remedy == 'klai-ars' || $remedy == 'kali=ars' || $remedy == 'kali.ars' || $remedy == 'kaliars' || $remedy == 'kars' || $remedy == 'kal--ars' || $remedy == 'kal-ars' || $remedy == 'kal-ar' || $remedy == 'kali-rs' || $remedy == 'kali phos' || $remedy == 'kali-phos' || $remedy == 'kal-phos' || $remedy == 'kali.p' || $remedy == 'kali+ars' || $remedy == 'kali-c' || $remedy == 'kali-phois' || $remedy == 'kali-p')
		{
			$remedy = 'kali-ars';
		}
		
		if($remedy == 'nat.m' || $remedy == 'inat.m' || $remedy == 'nat-m' || $remedy == 'natm' || $remedy == 'nat-m?' || $remedy == 'nm' || $remedy == 'nat-m d' || $remedy == 'nat m' || $remedy == 'nay=mur' || $remedy == 'natt-m' || $remedy == 'nat-m xx' || $remedy == 'na-mt' || $remedy == 'natpm' || $remedy == 'nat=m' || $remedy == 'nat -m' || $remedy == 'nat-mlb' || $remedy == 'nat .m')
		{
			$remedy = 'nat-mur';
		}
		
		// if($remedy == 'calc sulph' || $remedy == 'calc-sa' || $remedy == 'calc-ssulph' || $remedy == 'cakc-s')
		// {
		// 	$remedy = 'calc-sulph';
		// }
		if($remedy == 'calc' || $remedy == 'c-c' || $remedy == 'xcalc' || $remedy == 'clac-c' || $remedy == 'calc d' || $remedy == 'cald' || $remedy == 'callac' || $remedy == 'calcts' || $remedy == 'cc2c' || $remedy == 'cc c' || $remedy == 'cakc-s' || $remedy == 'calc-ox' || $remedy == 'clalc' || $remedy == 'callc' || $remedy == 'clc')
		{
			$remedy = '26';
			return $remedy;
			exit;
		}
		if($remedy == 'carc')
		{
			$remedy = '70';
			return $remedy;
			exit;
		}
		if(strpos($remedy,'c') !== false && strpos($remedy,'s') !== false && strpos($remedy,'p') !== false)
		{
			$remedy = 'calc-sulph';
		}
		if($remedy == 'carb-v' || $remedy == 'carbo-veg' || $remedy == 'catbo=veg' || $remedy == 'carbo veg' || $remedy == 'catrb-veg' || $remedy == 'c-v' || $remedy == 'carboveg' || $remedy == 'carb-b veg' || $remedy == 'carvb_veg' || $remedy == 'car-veg' || $remedy == 'c.v.' || $remedy == 'c.v')
		{
			$remedy = 'carb-veg';
		}
		if(strpos($remedy,'c') !== false && strpos($remedy,'b') !== false && strpos($remedy,'v') !== false)
		{
			$remedy = 'carb-veg';
		}
		if($remedy == 'ant-t' || $remedy == 'antt-t')
		{
			$remedy = 'antim-tart';
		}
		if($remedy == 'nv' || $remedy == 'nux vom' || $remedy == 'n v ' || $remedy == 'nuxds'  || $remedy == 'nux- vom' || $remedy == 'n-v-' || $remedy == 'nuxds--' || $remedy == 'nux-com' || $remedy == 'nux-x' || $remedy == 'nus-v' || $remedy == 'nux-vomic' || $remedy == 'nuux-v' || $remedy == 'nuxds..')
		{
			$remedy = 'nux-vom';
		}
		if(strpos($remedy,'n') !== false && strpos($remedy,'v') !== false)
		{
			$remedy = 'nux-vom';
		}
		 
		if($remedy == 'ars.iod' || $remedy == 'ars.i' || $remedy == 'ars-iod' || $remedy == 'ars d' || $remedy == 'ars' || $remedy == 'arc' || $remedy == 'arsd' || $remedy == 'ars-i' || $remedy == 'ara' || $remedy == 'ars.' || $remedy == 'ars++' || $remedy == 'ars..' || $remedy == 'arrs-i' || $remedy == 'ars-ac')
		{
			$remedy = 'ars-iod';
		}
		if(strpos($remedy,'a') !== false && strpos($remedy,'s') !== false && strpos($remedy,'i') !== false && strpos($remedy,'d') !== false)
		{
			$remedy = 'ars-iod';
		} 
		if($remedy == 'ms' || $remedy == 'm-sol' || $remedy == 'merc-soll' || $remedy == 'merc sol' || $remedy == 'm.sol' || $remedy == 'merc.sol')
		{
			$remedy = 'merc-sol';
		}
		if($remedy == 'asf' || $remedy == 'sulp' || $remedy == 'ars-s-f' || $remedy == 'ars-s-r')
		{
			$remedy = 'ars-sulph-f';
		}
		if($remedy == 'acid-nit' || $remedy == 'acid nit' || $remedy == 'nit-ac' || $remedy == 'nit-aca' || $remedy == 'acid.nit')
		{
			$remedy = 'nitric-acid';
		}
		
		if($remedy == 'ars 30' || $remedy == 'ars' || $remedy == 'ars alb' || $remedy == 'ars.alb' || $remedy == 'ars-alb')
		{
			$remedy = 'ars-album';
		}

		if($remedy == 'pulls' || $remedy == 'puld' || $remedy == 'puls00' || $remedy == 'pulss' || $remedy == 'puks')
		{
			$remedy = 'puls';
		}
		
		if($remedy == 'thju' || $remedy == 'thuj??' || $remedy == 'thiuj' || $remedy == 'thjua' || $remedy == 'thul')
		{
			$remedy = 'thuja';
		}
		if(strpos($remedy,'t') !== false && strpos($remedy,'j') !== false)
		{
			$remedy = 'thuja';
		}
		if($remedy == 'kali=s' || $remedy == 'kali.s' || $remedy == 'kali-s' || $remedy == 'kalis-s')
		{
			$remedy = 'kali-sulph';
		}
		if($remedy == 'kali-br' || $remedy == 'kali -br' || $remedy == 'kali.br' || $remedy == 'kali-carb' || $remedy == 'rad-brom' || $remedy == 'kali brom') // new add
		{
			$remedy = 'kali-brom';
		}
		if($remedy == 'cist-can' || $remedy == 'cist.can' || $remedy == 'cist-c' || $remedy == 'cict' || $remedy == 'cictt')
		{
			$remedy = 'cistus-can';
		}
		if($remedy == 'cic-v')//new
		{
			$remedy = 'cicuta-vir';
		}
		if($remedy == 'arg.nit' || $remedy == 'arg nit' || $remedy == 'arg.n' || $remedy == 'arg>n' || $remedy == 'ag-nit' || $remedy == 'argn' || $remedy == 'arg-n' || $remedy == 'arg.n d' || $remedy == 'ag.nit')
		{
			$remedy = 'arg-nit';
		}
		if($remedy == 'calc-f' || $remedy == 'calc-fluor' || $remedy == 'calc-fl')
		{
			$remedy = 'clac-flur';
		}
		if($remedy == 'alumina')
		{
			$remedy = 'alum';
		}
		if($remedy == 'pettr' || strpos($remedy,'petr') !== false || $remedy =='pert' || $remedy == 'paetr' || $remedy == 'pter' || $remedy == 'paetr' || $remedy == 'pett' || $remedy == 'pter' || $remedy == 'prtr' || $remedy == 'petrtr' || $remedy == 'pater' || $remedy == 'petyr' || $remedy == 'per')
		{
			$remedy = 'petr';
		}
		if($remedy == 'sul-i' || $remedy == 'sulph.iod' || $remedy == 'sulp-iod' || $remedy == 'suph-iod' || $remedy == 'sulphiod' || $remedy == 'sulph iod' || $remedy == 'sulph_d' || $remedy == 'suplh_d' || $remedy == 'suulph-iod' || $remedy == 'sulph_d' || $remedy == 'sulphur d' || $remedy == 'suph-uod' || $remedy == 'sulph iod' || $remedy == 'sulpj-iod' || $remedy == 'next sulph-i' || $remedy == 'suplh_d' || $remedy == 'sulpj-i' || $remedy == 'sulp.iod')
		{
			$remedy = 'sulph-iod';
		}
		if(strpos($remedy,'s') !== false && strpos($remedy,'u') !== false && strpos($remedy,'d') !== false && strpos($remedy,'i') !== false && strpos($remedy,'h') !== false )
		{
			$remedy = 'sulph-iod';
		}
		if($remedy == 'sillca' || $remedy == 'sillicea' || $remedy == 'silica')
		{
			$remedy = 'sillica';
		}
		if($remedy == 'grapj' || $remedy == 'graphm' || $remedy == 'grph' || $remedy == 'garph' || $remedy == 'sraph') //new
		{
			$remedy = 'graph';
		}
		if($remedy == 'ber-aq' || $remedy == 'berb aq') //new
		{
			$remedy = 'berb-aq';
		}
		if($remedy == 'staptun') //new
		{
			$remedy = 'staph';
		}
		if($remedy == 'chin')
		{
			$remedy = '22';
			return $remedy;
			exit;
		}
		if($remedy == 'charys-ac') //new
		{
			$remedy = '20';
			return $remedy;
			exit;
		}
		if($remedy == 'myriaca' || $remedy == 'myrst' || $remedy == 'myriaca-s' || $remedy == 'myristca' || $remedy == 'myrs') //new
		{
			$remedy = 'myristica';
		}
		
		if(strpos($remedy, 'dul') !== false) //new
		{
			$remedy = 'dulc';
		}
		if(strpos($remedy, 'phytolacca') !== false || $remedy == 'phtum') //new
		{
			$remedy = 'phytolaca';
		}
		if(strpos($remedy, 'psorianum') !== false || $remedy == 'psorias') //new
		{
			$remedy = 'psorinum';
		}
		if($remedy == 'phoa' || $remedy == 'phoq' || $remedy == 'phhos')
		{
			$remedy = 'phos';
		}
		if($remedy == 'mezerum' || $remedy == 'nez' || $remedy == 'nwz' || $remedy == 'mezereum' || $remedy == 'mezre' || $remedy == 'mes' || $remedy == 'mez **' || $remedy == 'mwz')
		{
			$remedy = 'mezerium';
		}
		if($remedy == 'baryta-carb')
		{
			$remedy = 'bar-carb';
		} 
		if($remedy == 'cor-rum' || $remedy == 'cor-r' || $remedy == 'cori-r')
		{
			$remedy = 'cor-rub';
		}
		if($remedy == 'llyc')
		{
			$remedy = 'lyco';
		}
		if($remedy == 'cnath' || $remedy == 'canthris')
		{
			$remedy = 'cantharis';
		}
		if($remedy == 'birax' || $remedy == 'borrax')
		{
			$remedy = 'borax';
		}
		if($remedy == 'telll')
		{
			$remedy = 'tellurium';
		}
		if($remedy == 'clem-t')
		{
			$remedy = 'clematis';
		}
		if($remedy == 'sep-' || $remedy == 'sep.')
		{
			$remedy = 'sepia';
		}
		if($remedy == 'clad-p')
		{
			$remedy = 'caladium';
		}
		if($remedy == 'ign' || $remedy == 'ignatia')
		{
			$remedy = 'ignitia-s';
		}
		if($remedy == 'china')
		{
			$remedy = 'cinchona';
		}
		if($remedy == 'irirs' || $remedy == 'irsiv')
		{
			$remedy = 'iris-t';
		}
		if($remedy == 'chrys-ac')
		{
			return '73';
			exit;
		}

		foreach ($final_remedy_data as $key => $value)
		{
			//$value = str_replace(" ","",$value);

			if(strpos($value,$remedy) !== false || substr_count($value,$remedy) > 0 || strpos($remedy,$value) !== false)
			{
				return $key;
				exit;
			}
		}
		return 0;
		exit;
	}	
}

function get_potency_id($potency)
{
	$potency = preg_replace("/[^A-Za-z0-9' -]/","",$potency);

	if($potency == '')
	{
		return 111;
	}
	else
	{
		global $final_potency_data;

		$potency = strtolower($potency);

		foreach ($final_potency_data as $key => $value)
		{
			//$value = str_replace(" ","",$value);

			if(strpos($value,$potency) !== false || substr_count($value,$potency) > 0 || strpos($potency,$value) !== false)
			{
				return $key;
				exit;
			}
		}
		return 0;
		exit;
	}
}

function get_repetition_id($repetition)
{
	$repetition = preg_replace("/[^A-Za-z0-9' -]/","",$repetition);

	if($repetition == '')
	{
		return 111;
	}
	else
	{
		global $final_repetition_data;

		$repetition = strtolower($repetition);

		if($repetition == 'all')
		{
			$repetition = '1 bd';
		}

		//$repetition = str_replace(" ","",$repitition);

		foreach ($final_repetition_data as $key => $value)
		{
			//$value = str_replace(" ","",$value);

			if(strpos($value,$repetition) !== false || substr_count($value,$repetition) > 0 || strpos($repetition,$value) !== false)
			{
				return $key;
				exit;
			}
		}
		return 0;
		exit;
	}
}

function get_dosage_id($dosage)
{
	$dosage = preg_replace("/[^A-Za-z0-9' -]/","",$dosage);

	if($dosage == '')
	{
		return 111;
	}
	else
	{
		global $final_dosage_data;

		$dosage = strtolower($dosage);

		foreach ($final_dosage_data as $key => $value)
		{
		//	$value = str_replace(" ","",$value);

			if(strpos($value,$dosage) !== false || substr_count($value,$dosage) > 0 || strpos($dosage,$value) !== false)
			{
				return $key;
				exit;
			}
		}
		return 0;
		exit;
	}
}

function get_days_id($days)
{
	$days = preg_replace("/[^A-Za-z0-9' -]/","",$days);

	if($days == '')
	{
		return 111;
	}
	else
	{
		global $final_days_data;

		$days = strtolower($days);

		foreach ($final_days_data as $key => $value)
		{
			//$value = str_replace(" ","",$value);

			if(strpos($value,$days) !== false || substr_count($value,$days) > 0 || strpos($days,$value) !== false)
			{
				return $key;
				exit;
			}
		}
		return 0;
		exit;
	}
}

?>