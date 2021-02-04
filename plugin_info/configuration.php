<?php
	/* This file is part of Jeedom.
		*
		* Jeedom is free software: you can redistribute it and/or modify
		* it under the terms of the GNU General Public License as published by
		* the Free Software Foundation, either version 3 of the License, or
		* (at your option) any later version.
		*
		* Jeedom is distributed in the hope that it will be useful,
		* but WITHOUT ANY WARRANTY; without even the implied warranty of
		* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
		* GNU General Public License for more details.
		*
		* You should have received a copy of the GNU General Public License
		* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
	*/
	
	require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
	include_file('core', 'authentification', 'php');
	if (!isConnect()) {
		include_file('desktop', '404', 'php');
		die();
	}
	
	function getDoodsVersion() {
		$doodsUrl = config::byKey('url', 'doods', '');
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $doodsUrl.'/version');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		
		$body = curl_exec($ch);
		$response = curl_getinfo($ch);
		
		curl_close($ch);
		
		return ($response['http_code'] == 200 ? json_decode($body)->version : 'Doods non détecté, saisir/vérifier l\'URL, sauvegarder et rafraîchir');
	}
?>
<form class="form-horizontal">
	<fieldset>
		<div class="form-group">
			<label class="col-sm-3 control-label">{{Url du serveur Doods}}</label>
			<div class="col-sm-7">
				<input class="configKey form-control" data-l1key="url" placeholder="http://<IP/Host Doods>:<Port>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">{{Version détectée (sauvegarder d'abord)}}</label>
			<div class="col-sm-4">
				<input class="configKey form-control" disabled value="<?php echo getDoodsVersion(); ?>"/>
			</div>
			<div class="col-sm-3">
				<a class="btn btn-warning" id="bt_checkDoodsVersion" onClick="window.location.reload();"><i class="fas fa-sync-alt"></i> {{Rafraîchir}}</a>
			</div>
		</div>
	</fieldset>
</form>
