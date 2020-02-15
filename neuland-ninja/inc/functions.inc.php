<?php
function boolStringMatch($boolString) {
    $rVal = false;

    switch ($boolString) {
        case '1':
            $rVal = true;
            break;
        case 'true':
            $rVal = true;
            break;

        case 'True':
            $rVal = true;
            break;

        case 'TRUE':
            $rVal = true;
            break;

        default:
            $rVal = false;
            break;
    }

    return $rVal;
}

function var2str($var) {
    if (is_bool($var)) return strtoupper(var_export($var, true));
    else return var_export($var, true);
}

function get_date_diff($start_time,$end_time=''){
    $end_time = ($end_time=='')?date("Y-m-d H:i:s"):$end_time;
    $datetime1 = new \DateTime($start_time);
    $datetime2 = new \DateTime($end_time);
    $interval = $datetime1->diff($datetime2);
    $time['y'] = $interval->format('%y');
    $time['m'] = $interval->format('%m');
    $time['d'] = $interval->format('%d');
    $time['h'] = $interval->format('%H');
    $time['i'] = $interval->format('%i');
    $time['s'] = $interval->format('%s');
    $time['a'] = $interval->format('%a');

    foreach ( $time as $key => $val ) {
        if (intval($val) === 0) unset($time[$key]);
        else {
            switch ($key) {
                case 'y':
                    $time[$key] .= (intval($val) > 1) ? ' Jahre' : ' Jahr';
                    break;
                
                case 'm':
                    $time[$key] .= (intval($val) > 1) ? ' Monate' : ' Monat';
                    break;
                
                case 'd':
                    $time[$key] .= (intval($val) > 1) ? ' Tage' : ' Tag';
                    break;

                case 'h':
                    $time[$key] .= (intval($val) > 1) ? ' Stunden' : ' Stunde';
                    break;

                case 'i':
                    $time[$key] .= (intval($val) > 1) ? ' Minuten' : ' Minute';
                    break;

                case 's':
                    $time[$key] .= (intval($val) > 1) ? ' Sekunden' : ' Sekunde';
                    break;

                case 'a':
                    $time[$key] .= (intval($val) > 1) ? ' Millisekunden' : ' Millisekunde';
                    break;
            }
        }
    }

    $i = 0;
    $rStr = '';
    foreach ( $time as $val ) {
        $i++;

        if ($i < count($time)) $rStr .= $val.' und ';
        else $rStr .= $val;
    }
    
    return $rStr;
}

function checkNinjaForm() {
    if (!empty($_POST) && !empty($_POST['submitBtn'])) {
        $formData = $_POST;

        unset($formData['submitBtn']);
        if (isset($formData['passwordT'])) unset($formData['passwordT']);
        if (isset($formData['passwordCheckT'])) unset($formData['passwordCheckT']);

        return $formData;
    } else return false;
}

function createNinjaMessage($mysqliConn, $ninjaData) {
    if (!empty($mysqliConn) && !empty($ninjaData)) {
        $dbVars = array(
            'isEncrypted'   => false,
            'hasErrors'     => false,
            'showTimeLeft'  => true,
            'sdMode'        => 0,
            'sdTimestamp'   => null,
            'payload'       => null
        );
        
        if (!empty($ninjaData['messageTA']) && !empty($ninjaData['selfDestructModeSel'])) {
            if (!empty($ninjaData['isEncrypted']) && boolStringMatch($ninjaData['isEncrypted'])) {
                if (!empty($ninjaData['fullEncryptedMessage'])) {
                    $dbVars['isEncrypted'] = true;
                    $dbVars['payload'] = $ninjaData['fullEncryptedMessage'];
                } else {
                    $dbVars['isEncrypted'] = false;
                    $dbVars['hasErrors'] = true;
                    $dbVars['payload'] = $ninjaData['messageTA'];
                }
            } else {
                $dbVars['isEncrypted'] = false;
                $dbVars['payload'] = $ninjaData['messageTA'];
            }

            $dbVars['payload'] = htmlentities($dbVars['payload']);

            if (isset($ninjaData['showTimeLeftCB'])) $dbVars['showTimeLeft'] = true;
            else $dbVars['showTimeLeft'] = false;

            if (!empty($ninjaData['selfDestructModeSel'])) $dbVars['sdMode'] = $ninjaData['selfDestructModeSel'];
            else $dbVars['sdMode'] = 'afterRead';

            $sql = "SELECT `timeOffset`,`addOffsetAfterReading` FROM `sdModes` WHERE `name`='".$dbVars['sdMode']."'";
            $result = $mysqliConn->query($sql);

            if ($result && $result->num_rows === 1) {
                $sdMode = $result->fetch_assoc();

                if ($sdMode['addOffsetAfterReading'] != 1) $dbVars['sdTimestamp'] = time() + $sdMode['timeOffset'];
                
                if ($dbVars['sdTimestamp'] === null) $dbVars['sdTimestamp'] = 'NULL';
                else $dbVars['sdTimestamp'] = "'".$dbVars['sdTimestamp']."'";

                $sql = "INSERT INTO `ninjaMessageTbl` (`isEncrypted`,`hasErrors`,`showTimeLeft`,`sdMode`,`sdTimestamp`,`payload`)
                        VALUES (".var2str($dbVars['isEncrypted']).",".var2str($dbVars['hasErrors']).",".var2str($dbVars['showTimeLeft']).",'".$dbVars['sdMode']."',".$dbVars['sdTimestamp'].",'".base64_encode($dbVars['payload'])."')";
                $result = $mysqliConn->query($sql);

                if ($result === true) {
                    $newMsgLink  = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
                    $newMsgLink .= $_SERVER['HTTP_HOST'].'/index.php?read='.urlencode(base64_encode($mysqliConn->insert_id));

                    return $newMsgLink;
                } else return false;
            } else return false;
        } else return false;
    } else return false;
}

function getNinjaMessage($mysqliConn, $cryptoLink) {
    if (!empty($mysqliConn) && !empty($cryptoLink)) {
        $msgID = base64_decode($cryptoLink);

        if ($msgID && is_numeric($msgID)) {
            $msgID = intval($msgID);

            $sql = "SELECT * FROM `ninjaMessageTbl` WHERE `ID`='$msgID'";
            $result = $mysqliConn->query($sql);

            if ($result && $result->num_rows === 1) {
                $ninjaData = $result->fetch_assoc();

                if ($ninjaData['sdTimestamp'] === null || $ninjaData['sdTimestamp'] > time()) {
                    $sql = "SELECT `timeOffset`,`addOffsetAfterReading` FROM `sdModes` WHERE `name`='".$ninjaData['sdMode']."'";
                    $result = $mysqliConn->query($sql);

                    if ($result && $result->num_rows === 1) {
                        $sdData = $result->fetch_assoc();

                        if ($sdData['addOffsetAfterReading'] == 1 && empty($ninjaData['sdTimestamp'])) {
                            $ninjaData['sdTimestamp'] = time() + $sdData['timeOffset'];
                            
                            if ($ninjaData['sdTimestamp'] <= time() || $ninjaData['sdMode'] == 'afterRead' || $sdData['timeOffset'] == 0) {
                                deleteNinjaMessage($mysqliConn, $msgID);
                                return $ninjaData;
                            } else {
                                $sql = "UPDATE `ninjaMessageTbl` SET `sdTimestamp`='".$ninjaData['sdTimestamp']."' WHERE `ID`='$msgID'";
                                $result = $mysqliConn->query($sql);

                                if ($result === true) return $ninjaData;
                                else return false;
                            }
                        } else return $ninjaData;
                    } else return false;
                } else if ($ninjaData['sdTimestamp'] <= time()) {
                    deleteNinjaMessage($mysqliConn, $msgID);
                    return false;
                } else return false;
            } else return false;
        } else return false;
    } else return false;
}

function deleteNinjaMessage($mysqliConn, $msgID) {
    $sql = "DELETE FROM `ninjaMessageTbl` WHERE `ID`='".$msgID."'";
    $result = $mysqliConn->query($sql);

    return $result;
}


function getClientCert() {
	$certInfo = array(
		'verify'	=> $_SERVER['SSL_CLIENT_VERIFY'],
		'serial'	=> $_SERVER['SSL_CLIENT_M_SERIAL'],
		'name'		=> $_SERVER['SSL_CLIENT_S_DN_O'],
		'CN'		=> $_SERVER['SSL_CLIENT_S_DN_CN'],
		'remain'	=> $_SERVER['SSL_CLIENT_V_REMAIN']
	);
	
	if ($certInfo['verify'] == 'NONE') return false;
	return $certInfo;
}


function getACLInfo($mysqliConn, $cn) {
	$sql = "SELECT * FROM `acl` WHERE `CN`='".$cn."'";
	$result = $mysqliConn->query($sql);
		
	if ($result && $result->num_rows === 1) {
		$cliInfo = $result->fetch_assoc();
		$clientInfo = array(
			'ID'		=> $cliInfo['ID'],
			'CN'		=> $cliInfo['CN'],
			'serial'	=> $cliInfo['serial'],
			'aclGroups'	=> explode(',', $cliInfo['aclGroupList'])
		);
		
		foreach (explode(',', $cliInfo['aclGroupList']) as $gI => $gID) {
			$sql = "SELECT * FROM `aclGroups` WHERE `ID`='$gID'";
			$result = $mysqliConn->query($sql);
			
			if ($result && $result->num_rows === 1) {
				$groupInfo = $result->fetch_assoc();
				$groups[$gI] = array(
					'name'				=> $groupInfo['name'],
					'aclPermissions'	=> $groupInfo['permissionsList']
				);
				
				foreach (explode(',', $groupInfo['permissionsList']) as $pI => $pID) {
					$sql = "SELECT * FROM `aclPermissions` WHERE `ID`='$pID'";
					$result = $mysqliConn->query($sql);
					
					if ($result && $result->num_rows === 1) {
						$permissionsInfo = $result->fetch_assoc();
						$permissions[$pI] = $permissionsInfo['name'];
					} else return false;
				}
			} else return false;
		}
	} else return false;
	
	return array(
		'client' 		=> $clientInfo,
		'groups' 		=> $groups,
		'permissions'	=> $permissions
	);
}

function checkPermission($mysqliConn, $cn, $permissionName) {
	$aclInfo = getACLInfo($mysqliConn, $cn);

	if (in_array($permissionName, $aclInfo['permissions'])) return true;
	else return false;
}
?>
