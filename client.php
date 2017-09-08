<?php
	$GLOBALS["conn"]=false;
	$GLOBALS["info"]=["username"=>"test","password"=>"secret","ip"=>'127.0.0.1',"login"=>6112,"game"=>6113];
	function conn($p){
		$GLOBALS["conn"] = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		socket_connect($GLOBALS["conn"],$GLOBALS["info"]["ip"],$p);
	}
	function sysm($a,$r,$p){return "<msg t='sys'><body action='".$a."' r='".$r."'>".$p."</body></msg>";}
	function cpen($s){return substr(md5($s),16,32).substr(md5($s),0,16);};
	function fail($id){die("[FAIL]: ".[0=>"Bad packet received!"][$id]."\n");}
	function slog($p,$s=false){($s)?print "[RECV]: ":print "[SEND]: ";print("$p\n");};
	function recv(){$recv="";socket_recv($GLOBALS["conn"],$recv,1024,0);slog($recv,1);return $recv;}
	function send($b,$e='%'){socket_write($GLOBALS["conn"],$b."\0");slog($b);return stri($r=recv(),$e);}
	function stri($s,$e){if(strpos($s,$e)===false){fail(0);};return $s;};
	function oreo($b0,$m,$b1){preg_match('/'.$b0.'(.*)'.$b1.'/',$m,$n);return $n[1];}
	function rndk($port){
		conn($port);
		send("<policy-file-request/>","cross");
		send(sysm("verChk",0,"<ver v='153' />"),"apiOK");
		return oreo('\<k\>',send(sysm("rndK",-1,""),"rndK"),'\<\/k\>');
	}
	function logk($username,$pass){
		send(sysm("login",0,"<login z='w1'><nick><![CDATA[$username]]></nick><pword><![CDATA[$pass]]></pword></login>"));
	}
	function login($username,$password){
		logk($username,cpen(strtoupper(cpen($password)).(rndk($GLOBALS["info"]["login"])."Y(02.>'H}t\":E1")));
		$logk=explode("%",oreo('xt%l%-1%',recv(),'%0%'))[1];
		socket_close($GLOBALS["conn"]);
		logk($username,cpen($logk. rndk($GLOBALS["info"]["game"])).$logk);
		send("%xt%s%j#js%-1%96201%$logk%en%");
		recv();
	}
	login($GLOBALS["info"]["username"],$GLOBALS["info"]["password"]);
	socket_close($GLOBALS["conn"]);
