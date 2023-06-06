<?php
require('lib/config.php');
$cookieData		= explode('|', file_get_contents('./data/'.$cookieFile));
$cookie 		= $cookieData[0]; // Cookie Instagram
$useragent 		= $cookieData[1]; // Useragent Instagram
$loop			= true;
//feed/user/{$userId}/story/
echo "
 _____ _                   _                       
/  ___| |                 | |                      
\ `--.| |_ ___  _ __ _   _| |     ___   ___  _ __  
 `--. \ __/ _ \| '__| | | | |    / _ \ / _ \| '_ \ 
/\__/ / || (_) | |  | |_| | |___| (_) | (_) | |_) |
\____/ \__\___/|_|   \__, \_____/\___/ \___/| .__/ 
                      __/ |                 | |    
                     |___/                  |_|    \n";
echo "[-] ============ Auto Views Story ============ [-]\n";
echo "[-] =========== Made by nthanfp =========== [-]\n";
echo "[-] ======== Updated by @theaxe.id, @deoffuscated ======== [-]\n\n";
echo "[-] =========== Modified by gvoze32, mohsanjid =========== [-]\n";

if($cookie){
	$getaccount	= proccess(1, $useragent, 'accounts/current_user/', $cookie);
	$getaccount	= json_decode($getaccount[1], true);
	if($getaccount['status'] == 'ok'){
		//LOSS
		$getaccountV2	= proccess(1, $useragent, 'users/'.$getaccount['user']['pk'].'/info', $cookie);
		$getaccountV2	= json_decode($getaccountV2[1], true);
		echo "[~] Login as @".$getaccount['user']['username']." \n";
		echo "[~] [Media : ".$getaccountV2['user']['media_count']."] [Follower : ".$getaccountV2['user']['follower_count']."] [Following : ".$getaccountV2['user']['following_count']."]\n";
		echo "[~] Please wait 5 second for loading script\n";
		echo "[~] "; for($x = 0; $x <= 4; $x++){ echo "========"; sleep(5); } echo "\n\n";
		do {
			$targets	= file_get_contents('./data/'.$targetFile);
			$targets 	= explode("\n", str_replace("\r", "", $targets));
			$targets 	= array($targets)[0];
			foreach($targets as $target){
				$commens		= file_get_contents('./data/'.$answerFile);
				$commen		= explode("\n", str_replace("\r", "", $commens));
				$commen		= array($commen)[0];
				//
				$todays		= file_get_contents('./data/daily/'.date('d-m-Y').'.txt');
				$today		= explode("\n", str_replace("\r", "", $todays));
				$today		= array($today)[0];
				//
				//$proxy		= file_get_contents('https://proxies-provider.com');
				//$proxy		= json_decode($proxy, true);
				//$prox['ip']			= $proxy['data']['proxy'];
				$prox['ip']			= 0;
				$prox['user']		= 0;
				$prox['is_socks5']	= 0;
				//
				echo "[~] Get followers of ".$target."\n";
				//echo "[~] Proxy ".$prox['ip']."\n";
				$targetid	= json_decode(request(1, $useragent, 'users/'.$target.'/usernameinfo/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5'])[1], 1)['user']['pk'];
				$gettarget	= proccess(1, $useragent, 'users/'.$targetid.'/info', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
				$gettarget	= json_decode($gettarget[1], true);
				echo "[~] [Media : ".$gettarget['user']['media_count']."] [Follower : ".$gettarget['user']['follower_count']."] [Following : ".$gettarget['user']['following_count']."]\n";
				$jumlah		= $countTarget;
				if(!is_numeric($jumlah)){
					$limit = 1;
				} elseif ($jumlah > ($gettarget['user']['follower_count'] - 1)){
					$limit = $gettarget['user']['follower_count'] - 1;
				} else {
					$limit = $jumlah - 1;
				}
				$next      	= false;
				$next_id    = 0;
				$listids	= array();
				do {
					if($next == true){ $parameters = '?max_id='.$next_id.''; } else { $parameters = ''; }
					$req        = proccess(1, $useragent, 'friendships/'.$targetid.'/followers/'.$parameters, $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
					$req        = json_decode($req[1], true);
					if($req['status'] !== 'ok'){
						var_dump($req);
						exit();
					}
					for($i = 0; $i < count($req['users']); $i++):
						if($req['users'][$i]['is_private'] == false):
							if($req['users'][$i]['latest_reel_media']):
								if(count($listids) <= $limit):
									$listids[count($listids)] = $req['users'][$i]['pk'];
								endif;
							endif;
						endif;
					endfor;
					if($req['next_max_id']){ $next = true; $next_id	= $req['next_max_id']; } else { $next = false; $next_id = '0'; }
				} while(count($listids) <= $limit);
				echo "[~] ".count($listids)." followers of ".$target." collected\n";
				$reels		= array();
				$reels_suc	= array();
				for($i = 0; $i < count($listids); $i++):
					$getstory   = proccess(1, $useragent, 'feed/user/'.$listids[$i].'/story/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
					$getstory   = json_decode($getstory[1], true);
					foreach($getstory['reel']['items'] as $storyitem):
						$reels[count($reels)]	= $storyitem['id']."_".$getstory['reel']['user']['pk'];
						$stories['id']			= $storyitem['id'];
						$stories['reels']		= $storyitem['id']."_".$getstory['reel']['user']['pk'];
						$stories['reel']		= $storyitem['taken_at'].'_'.time();
						if(strpos(file_get_contents('./data/storyData.txt'), $stories['reels']) == false){
							$hook       = '{"live_vods_skipped": {}, "nuxes_skipped": {}, "nuxes": {}, "reels": {"'.$stories['reels'].'": ["'.$stories['reel'].'"]}, "live_vods": {}, "reel_media_skipped": {}}';
							$viewstory  = proccess_v2(1, $useragent, 'media/seen/?reel=1&live_vod=0', $cookie, hook(''.$hook.''), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
							$viewstory  = json_decode($viewstory[1], true);
							if($viewstory['status'] == 'ok'){
								$reels_suc[count($reels_suc)] = $storyitem['id']."_".$getstory['reel']['user']['pk'];
								echo "[~] ".date('d-m-Y H:i:s')." - Seen stories ".$stories['id']." \n";
								saveData('./data/storyData.txt', $stories['reels']);
								saveData('./data/daily/'.date('d-m-Y').'.txt', $stories['reels']);
							}
							sleep($sleep_1);
						}
					endforeach;
					echo "[~] ".date('d-m-Y H:i:s')." - Sleep for ".$sleep_2." second to bypass instagram limit\n"; sleep($sleep_2);
				endfor;
				echo "[~] ".count($reels)." story from ".$target." collected\n";
				echo "[~] ".count($reels_suc)." story from ".$target." marked as seen\n";
				echo "[~] ".count($today)." story reacted today\n";
				echo "[~] ".date('d-m-Y H:i:s')." - Sleep for 30 second to bypass instagram limit\n";
				echo "[~] "; for($x = 0; $x <= 4; $x++){ echo "========"; sleep(6); } echo "\n\n";
			}
			if(count($today) > '250000') {
				echo "[~] ".count($today)." story reacted today\n";
				echo "[~] Limit instagram api 2000 seen/day\n";
				echo "[~] Sleep for 20 hours to bypass instagram limit\n";
				sleep(72);
				echo "[~] End sleep...\n\n";
			}
		} while($loop == true);
	} else {
		echo "[!] Error : ".json_encode($getaccount)."\n";
	}
} else {
	echo "[!] Please login\n";
}
?>
