import socket
import hashlib
import re

sock = False
info = {'username': 'test','password': 'secret','ip': '127.0.0.1','login': 6112,'game':6113};
def conn(p):
	global sock
	global info
	sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
	sock.connect((info['ip'],p))
def sysm(a,r,p): return "<msg t='sys'><body action='"+a+"' r='"+str(r)+"'>"+p+"</body></msg>"
def cpen(s): return hashlib.md5(s).hexdigest()[16:32]+hashlib.md5(s).hexdigest()[0:16]
def fail(id): print "[FAIL]: "+{0:"Bad packet received!"}[id]; exit();
def slog(p,s=False): print("[RECV]: " if (s) else "[SEND]: ")+p
def recv():recv = sock.recv(1024);slog(recv,1);return recv;
def send(b,e="%"): sock.send(b+chr(0));slog(b);r=recv();return stri(r,e);
def stri(s,e): r = fail(0) if (e not in s) else 0;return s;
def oreo(b0,m,b1): return re.search(b0+'(.*)'+b1,m).group(1)
def rndk(port):
	conn(port)
	send("<policy-file-request/>","cross")
	send(sysm("verChk",0,"<ver v='153' />"),"apiOK")
	return oreo('\<k\>',send(sysm("rndK",-1,""),"rndK"),'\<\/k\>')
def logk(username,password):
	send(sysm("login",0,"<login z='w1'><nick><![CDATA["+username+"]]></nick><pword><![CDATA["+password+"]]></pword></login>"))
def login(username,password):
	global sock
	global info
	logk(username,cpen(cpen(password).upper()+(rndk(info["login"])+"Y(02.>'H}t\":E1")));
	loky=oreo('xt%l%-1%',recv(),'%0%').split("%")[1];
	sock.close()
	logk(username,cpen(loky+ rndk(info["game"]))+loky);
	send("%xt%s%j#js%-1%96201%"+loky+"%en%");
	recv()
login(info["username"],info["password"]);
