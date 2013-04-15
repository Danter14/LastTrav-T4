<?php

/*
|--------------------------------------------------------------------------
|   PLEASE DO NOT REMOVE THIS COPYRIGHT NOTICE!
|--------------------------------------------------------------------------  
|
|   Project owner:   Dzoki < dzoki.travian@gmail.com >
|  
|   This script is property of TravianX Project. You are allowed to change
|   its source and release it under own name, not under name `TravianX`. 
|   You have no rights to remove copyright notices.
|
|   TravianX All rights reserved
|
*/

       class Alliance {

       	public $gotInvite = false;
       	public $inviteArray = array();
       	public $allianceArray = array();
       	public $userPermArray = array();

       	public function procAlliance($get) {
       		global $session, $database;

       		if($session->alliance != 0) {
       			$this->allianceArray = $database->getAlliance($session->alliance);
       			// Permissions Array
       			// [id] => id [uid] => uid [alliance] => alliance [opt1] => X [opt2] => X [opt3] => X [opt4] => X [opt5] => X [opt6] => X [opt7] => X [opt8] => X
       			$this->userPermArray = $database->getAlliPermissions($session->uid, $session->alliance);
       		} else {
       			$this->inviteArray = $database->getInvitation($session->uid);
       			$this->gotInvite = count($this->inviteArray) == 0 ? false : true;
       		}
       		if(isset($get['a'])) {
       			switch($get['a']) {
       				case 2:
       					$this->rejectInvite($get);
       					break;
       				case 3:
       					$this->acceptInvite($get);
       					break;
       				default:
       					break;
       			}
       		}
       		if(isset($get['o'])) {
       			switch($get['o']) {
       				case 4:
       					$this->delInvite($get);
       					break;
       				default:
       					break;
       			}
       		}
       	}

       	public function procAlliForm($post) {
       		if(isset($post['ft'])) {
       			switch($post['ft']) {
       				case "ali1":
       					$this->createAlliance($post);
       					break;
       			}

       		}
       		if(isset($_POST['dipl']) and isset($_POST['a_name'])) {
       			$this->changediplomacy($post);
       		}

       		if(isset($post['s'])) {
       			if(isset($post['o'])) {
       				switch($post['o']) {
       					case 1:
       						if(isset($_POST['a'])) {
       							$this->changeUserPermissions($post);
       						}
       						break;
       					case 2:
       						if(isset($_POST['a_user'])) {
       							$this->kickAlliUser($post);
       						}
       						break;
       					case 4:
       						if(isset($_POST['a']) && $_POST['a'] == 4) {
       							$this->sendInvite($post);
       						}
       						break;
       					case 3:
       						$this->updateAlliProfile($post);
       						break;
       					case 11:
       						$this->quitally($post);
       						break;
       					case 100:
       						$this->changeAliName($post);
       						break;
       				}
       			}
       		}
       	}

       	/*****************************************
       	Function to process sending invitations
       	*****************************************/
		public function sendInvite($post) {
			global $form, $database, $session;
			if($session->access != BANNED){
			if($post['a_name'] != "" or $post['a_uid'] == ""){
			$UserData = $database->getUserArray($post['a_name'], 0);
			if($this->userPermArray['opt4'] == 0) {
				$form->addError("perm", NO_PERMISSION);
			}elseif(!isset($post['a_name']) || $post['a_name'] == "") {
				$form->addError("name1", NAME_EMPTY);
			}elseif(!$database->checkExist($post['a_name'], 0)) {
				$form->addError("name2", NAME_NO_EXIST.$post['a_name']);
			}elseif($post['a_name'] == (addslashes($session->username))) {
				$form->addError("name3", SAME_NAME);
			}elseif($database->getInvitation2($UserData['id'],$session->alliance)) {
				$form->addError("name4", $post['a_name'].ALREADY_INVITED);
			}elseif($UserData['alliance'] == $session->alliance) {
				$form->addError("name5", $post['a_name'].ALREADY_IN_ALLY);
			}else{
				// Obtenemos la informacion necesaria
				$aid = $session->alliance;
				// Insert the Invitation
				$database->sendInvitation($UserData['id'], $aid, $session->uid);
				// Log the notice
				$database->insertAlliNotice($session->alliance, '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has invited  <a href="spieler.php?uid=' . $UserData['id'] . '">' . $UserData['username'] . '</a> into the alliance.');
			}
			}elseif(isset($post['a_uid'])){
			$UserData = $database->getUserArray($post['a_uid'], 1);
			if($this->userPermArray['opt4'] == 0) {
				$form->addError("perm", NO_PERMISSION);
			}elseif(!isset($post['a_uid']) || $post['a_uid'] == "") {
				$form->addError("name1", NAME_EMPTY);
			}elseif(!$database->checkExist($UserData['email'], 1)) {
				$form->addError("name2", ID_NO_EXIST.$post['a_uid']);
			}elseif($post['a_uid'] == ($session->uid)) {
				$form->addError("name3", SAME_NAME);
			}elseif($database->getInvitation2($UserData['id'],$session->alliance)) {
				$form->addError("name4", $UserData['username'].ALREADY_INVITED);
			}elseif($UserData['alliance'] == $session->alliance) {
				$form->addError("name5", $UserData['username'].ALREADY_IN_ALLY);
			}else{
				// Get the alliance
				$aid = $session->alliance;
				// Insert the Invitation
				$database->sendInvitation($UserData['id'], $aid, $session->uid);
				// Log the notice
				$database->insertAlliNotice($session->alliance, '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has invited  <a href="spieler.php?uid=' . $UserData['id'] . '">' . $UserData['username'] . '</a> into the alliance.');
			}
			}
			}else{
			header("Location: banned.php");
			}
		}

       	/*****************************************
       	Function to reject an invitation
       	*****************************************/
		private function rejectInvite($get) {
			global $database, $session;
			if($session->access != BANNED){
			foreach($this->inviteArray as $invite) {
				if($invite['id'] == $get['d']) {
					$database->removeInvitation($get['d']);
					$database->insertAlliNotice($invite['alliance'], '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has rejected the invitation.');
				}
			}
			header("Location: build.php?id=".$get['id']);
			}else{
			header("Location: banned.php");
			}
		}

       	/*****************************************
       	Function to del an invitation
       	*****************************************/
		private function delInvite($get) {
			global $database, $session;
			if($session->access != BANNED){
			$inviteArray = $database->getAliInvitations($session->alliance);
			foreach($inviteArray as $invite) {
				if($invite['id'] == $get['d']) {
				$invitename = $database->getUserArray($invite['uid'], 1);
					$database->removeInvitation($get['d']);
					$database->insertAlliNotice($session->alliance, '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has deleted the invitation for <a href="spieler.php?uid=' . $invitename['id'] . '">' . $invitename['username'] . '</a>.');
				}
			}
			header("Location: allianz.php?delinvite");
			}else{
			header("Location: banned.php");
			}
		}

       	/*****************************************
       	Function to accept an invitation
       	*****************************************/
		private function acceptInvite($get) {
			global $form, $database, $session;
			if($session->access != BANNED){
			foreach($this->inviteArray as $invite) {
			if($session->alliance == 0){
				if($invite['id'] == $get['d'] && $invite['uid'] == $session->uid) {
				$memberlist = $database->getAllMember($invite['alliance']);
				$alliance_info = $database->getAlliance($invite['alliance']);
				if(count($memberlist) < $alliance_info['max']){
					$database->removeInvitation($database->RemoveXSS($get['d']));
					$database->updateUserField($database->RemoveXSS($invite['uid']), "alliance", $database->RemoveXSS($invite['alliance']), 1);
					$database->createAlliPermissions($database->RemoveXSS($invite['uid']), $database->RemoveXSS($invite['alliance']), '', '0', '0', '0', '0', '0', '0', '0', '0');
					// Log the notice
					$database->insertAlliNotice($invite['alliance'], '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has joined the alliance.');
				}else{
				$accept_error = 1;
				$max = $alliance_info['max'];
				}
				}
			}
			}
			if($accept_error == 1){
			$form->addError("ally_accept", "The alliance can contain only ".$max." peoples right now.");
			}else{
			header("Location: build.php?id=" . $get['id']);
			}
			}else{
			header("Location: banned.php");
			}
		}

       	/*****************************************
       	Function to create an alliance
       	*****************************************/
       	private function createAlliance($post) {
       		global $form, $database, $session, $bid18, $village;
       		if(!isset($post['ally1']) || $post['ally1'] == "") {
       			$form->addError("ally1", ATAG_EMPTY);
       		}
       		if(!isset($post['ally2']) || $post['ally2'] == "") {
       			$form->addError("ally2", ANAME_EMPTY);
       		}
       		if($database->aExist($post['ally1'], "tag")) {
       			$form->addError("ally1", ATAG_EXIST);
       		}
       		if($database->aExist($post['ally2'], "name")) {
       			$form->addError("ally2", ANAME_EXIST);
       		}
       		if($form->returnErrors() != 0) {
       			$_SESSION['errorarray'] = $form->getErrors();
       			$_SESSION['valuearray'] = $post;

       			header("Location: build.php?id=" . $post['id']);
       		} else {
       			$max = $bid18[$village->resarray['f' . $post['id']]]['attri'];
       			$aid = $database->createAlliance($database->RemoveXSS($post['ally1']), $database->RemoveXSS($post['ally2']), $session->uid, $max);
       			$database->updateUserField($database->RemoveXSS($session->uid), "alliance", $database->RemoveXSS($aid), 1);
       			// Asign Permissions
       			$database->createAlliPermissions($database->RemoveXSS($session->uid), $database->RemoveXSS($aid), 'Alliance Founder', '1', '1', '1', '1', '1', '1', '1', '1');
       			// log the notice
       			$database->insertAlliNotice($session->alliance, 'The alliance has been founded by <a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a>.');
       			header("Location: build.php?id=" . $post['id']);
       		}
       	}

		/*****************************************
		Function to change the alliance name
		*****************************************/
		private function changeAliName($get) {
			global $form, $database, $session;
			if($session->access != BANNED){
			if(!isset($get['ally1']) || $get['ally1'] == "") {
				$form->addError("ally1", ATAG_EMPTY);
			}
			if(!isset($get['ally2']) || $get['ally2'] == "") {
				$form->addError("ally2", ANAME_EMPTY);
			}
			if($database->aExist($get['ally1'], "tag")) {
				$form->addError("tag", ATAG_EXIST);
			}
			if($database->aExist($get['ally2'], "name")) {
				$form->addError("name", ANAME_EXIST);
			}
			if($this->userPermArray['opt3'] == 0) {
				$form->addError("perm", NO_PERMISSION);
			}
			if($form->returnErrors() != 0) {
				$_SESSION['errorarray'] = $form->getErrors();
				$_SESSION['valuearray'] = $post;
				//header("Location: build.php?id=".$post['id']);
			} else {
				$database->setAlliName($database->RemoveXSS($session->alliance), $database->RemoveXSS($get['ally2']), $database->RemoveXSS($get['ally1']));
				// log the notice
				$database->insertAlliNotice($session->alliance, '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has changed the alliance name.');
			}
			}else{
			header("Location: banned.php");
			}
		}

		/*****************************************
		Function to create/change the alliance description
		*****************************************/
		private function updateAlliProfile($post) {
			global $database, $session, $form;
			if($session->access != BANNED){
			if($this->userPermArray['opt3'] == 0) {
				$form->addError("perm", NO_PERMISSION);
			}
			if($form->returnErrors() != 0) {
				$_SESSION['errorarray'] = $form->getErrors();
				$_SESSION['valuearray'] = $post;
				//header("Location: build.php?id=".$post['id']);
			} else {
				$database->submitAlliProfile($database->RemoveXSS($session->alliance), $post['be2'], $post['be1']);
				// log the notice
				$database->insertAlliNotice($session->alliance, '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has changed the alliance description.');
			}
			}else{
			header("Location: banned.php");
			}
		}

		/*****************************************
		Function to change the user permissions
		*****************************************/
		private function changeUserPermissions($post) {
			global $database, $session, $form;
			if($session->access != BANNED){
			if($this->userPermArray['opt1'] == 0) {
				$form->addError("perm", NO_PERMISSION);
			}
			if($form->returnErrors() != 0) {
				$_SESSION['errorarray'] = $form->getErrors();
				$_SESSION['valuearray'] = $post;
				//header("Location: build.php?id=".$post['id']);
			} else {
                /**
                 * @todo I think opt8 is the founder/leader, need to add an option to change that without the leader quitting
                 */
				$database->updateAlliPermissions($post['a_user'], $session->alliance, $post['a_titel'], $post['e1'], $post['e2'], $post['e3'], $post['e4'], $post['e5'], $post['e6'], $post['e7'], 0);
				// log the notice
				$database->insertAlliNotice($session->alliance, '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has changed permissions.');
                // Need to redirect if successful
                header("Location: allianz.php?s=5");
			}
			}else{
			header("Location: banned.php");
			}
		}
		/*****************************************
		Function to kick a user from alliance
		*****************************************/
		private function kickAlliUser($post) 
        {
			global $database, $session, $form;
			if($session->access != BANNED)
            {
                $UserData = $database->getUserArray($post['a_user'], 1);
                if($this->userPermArray['opt2'] == 0) 
                {
                    $form->addError("perm", NO_PERMISSION);
                }
                // Can't kick self
                else if($UserData['id'] != $session->uid)
                {
                    if ($database->isAllianceOwner($UserData['id']))
                    {
                        // Can't kick owner
                        $form->addError("name", "You cannot kick the owner!");
                    }
                    else
                    {
                        $database->updateUserField($post['a_user'], 'alliance', 0, 1);
                        $database->deleteAlliPermissions($post['a_user']);
                        $database->deleteAlliance($session->alliance);
                        $database->insertAlliNotice($session->alliance, '<a href="spieler.php?uid=' . $UserData['id'] . '">' . addslashes($UserData['username']) . '</a> has been kicked from the alliance!');
                    }
				}
                $form->addError("name", "You cannot kick yourself!");
			}
            else
            {
                header("Location: banned.php");
			}
		}
		/*****************************************
		Function to set forum link
		*****************************************/
		public function setForumLink($post) {
			global $database, $session;
			if($session->access != BANNED){
				if(isset($post['f_link'])){
				$database->setAlliForumLink($session->alliance, $post['f_link']);
				header("Location: allianz.php?s=5");
				}
			}else{
			header("Location: banned.php");
			}
		}
		/*****************************************
		Function to quit  alliance
		*****************************************/
		private function quitally($post) 
        {
			global $database, $session, $form;
			if($session->access != BANNED)
            {
                if(!isset($post['pw']) || $post['pw'] == "")
                {
                    $form->addError("pw1", PW_EMPTY);
                }
                elseif(md5($post['pw']) !== $session->userinfo['password'])
                {
                    $form->addError("pw2", PW_ERR);
                }
                else
                {
                    if($database->isAllianceOwner($session->uid))
                    {
                        /**
                         * Owner wants to quit so set new owner to the next highest player
                         * And call him Interim Leader
                         * Not ideal as its pop based but hopefully this scenario will not happen often
                         */
                        $allmembers = $database->getAllMember($session->alliance);
                        $newleader = $allmembers[1]; 
                        $q = "UPDATE " . TB_PREFIX . "alidata set leader = ".$newleader['id']." where id = ".$session->alliance."";
                        $database->query($q);
                        $database->updateAlliPermissions($newleader['id'], $session->alliance, 'Interim Leader', 1,1,1,1,1,1,1,1);
                        
                        $database->updateUserField($session->uid, 'alliance', 0, 1);
                        $database->deleteAlliPermissions($session->uid);
                        // log the notice
                        $database->deleteAlliance($session->alliance);
                        $database->insertAlliNotice($session->alliance, '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has quit the alliance.');
                        header("Location: spieler.php?uid=".$session->uid);
                    }
                    else
                    {
                        $database->updateUserField($session->uid, 'alliance', 0, 1);
                        $database->deleteAlliPermissions($session->uid);
                        // log the notice
                        $database->deleteAlliance($session->alliance);
                        $database->insertAlliNotice($session->alliance, '<a href="spieler.php?uid=' . $session->uid . '">' . addslashes($session->username) . '</a> has quit the alliance.');
                        header("Location: spieler.php?uid=".$session->uid);
                    }
                }
			}
            else
            {
                header("Location: banned.php");
			}
		}

		private function changediplomacy($post) {
			global $database, $session, $form;
			if($session->access != BANNED){
			$aName = $database->RemoveXSS($_POST['a_name']);
			$aType = (int)intval($_POST['dipl']);
			if($database->aExist($aName, "tag")) {
				if($database->getAllianceID($aName) != $session->alliance) {
					if($aType >= 1 and $aType <= 3) {
						if(!$database->diplomacyInviteCheck($database->getAllianceID($aName), $session->alliance)) {
							$database->diplomacyInviteAdd($session->alliance, $database->getAllianceID($aName), $aType);
							if($aType == 1){
							$notice = "offer a confederation to";
							}else if($aType == 2){
							$notice = "offer non-aggression pact to";
							}else if($aType == 3){
							$notice = "declare war on";
							}
							$database->insertAlliNotice($session->alliance, '<a href="allianz.php?aid=' . $session->alliance . '">' . $database->getAllianceName($session->alliance) . '</a> '. $notice .' <a href="allianz.php?aid=' . $database->getAllianceID($aName) . '">' . $aName . '</a>.');
							$form->addError("name", "Invite sent");
						} else {
							$form->addError("name", "You have already sent them an invite");
						}

					} else {
						$form->addError("name", "wrong choice made");
					}
				} else {
					$form->addError("name", "You can not invite your own alliance");
				}
			} else {
				$form->addError("name", "Alliance does not exist");
			}
			}else{
			header("Location: banned.php");
			}
		}
		
		private function updateMax($leader) {
			global $bid18, $database;
			$q = mysql_query("SELECT * FROM " . TB_PREFIX . "alidata where leader = $leader");
			if(mysql_num_rows($q) > 0){
			$villages = $database->getVillagesID2($leader);
			$max = 0;
			foreach($villages as $village){
			$field = $database->getResourceLevel($village['wref']);
			for($i=19;$i<=40;$i++){
			if($field['f'.$i.'t'] == 18){
			$level = $field['f'.$i];
			$attri = $bid18[$level]['attri'];
			}
			}
			if($attri > $max){
			$max = $attri;
			}
			}
			$q = "UPDATE ".TB_PREFIX."alidata set max = $max where leader = $leader";
			$database->query($q);
			}
		}
	   }

       $alliance = new Alliance;

?>