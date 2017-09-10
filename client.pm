use IO::Socket::INET;
use Digest::MD5 qw(md5 md5_hex md5_base64);

our $sock = false;
our %info = (username=>"test",password=>"secret","ip"=>"127.0.0.1",login=>6112,game=>6113);
sub conn {
	$sock = new IO::Socket::INET (PeerHost =>$info{ip},PeerPort =>@_,Proto => 'tcp',);
}
sub sysm { return "<msg t='sys'><body action='".@_[0]."' r='".@_[1]."'>".@_[2]."</body></msg>";}
sub cpen { return substr(md5_hex(@_[0]),16,32).substr(md5_hex(@_[0]),0,16); }
sub fail { @errors = ("Bad packet received!");print @errors[@_[0]];exit(); }
sub slog { if(defined(@_[1])){print "[RECV]: ";}else{print "[SEND]: ";};print(@_[0]."\n"); }
sub recv_ { $sock->recv($recv, 1024);slog($recv,1); return $recv;}
sub send_ { $sock->send($_[0]."\0");slog($_[0]);return stri($r=recv_(),$_[1])}
sub stri { if(index($_[0],$_[1])==-1){fail(0);};return $_[0];}
sub oreo { ($_[1] =~ m/${_[0]}(.*)${_[2]}/m);return $1; }
sub rndk {
	conn($_[0]);
	send_("<policy-file-request/>","cross");
	send_(sysm("verChk",0,"<ver v='153' />"),"apiOK");
	return oreo("<k>",send_(sysm("rndK",-1,""),"rndK"),"</k>");
}
sub logk {
	send_(sysm("login",0,"<login z='w1'><nick><![CDATA[$_[0]]]></nick><pword><![CDATA[$_[1]]]></pword></login>"));
}
sub login {
	$rndk = rndk(6112);
	logk($_[0],cpen(uc(cpen($_[1])).(rndk($info{login})."Y(02.>'H}t\":E1")));
	@logk=split("%",oreo('xt%l%-1%',recv_(),'%0%'));$logk=$logk[1];
	$sock->close();
	logk($_[0],cpen($logk. rndk($info{game})).$logk);
	send_("%xt%s%j#js%-1%96201%$logk%en%");
	send_("%xt%s%j#jr%-1%100%");
	recv_();
}
login($info{username},$info{password});
$sock->close();
