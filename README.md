<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Sobre APITABLERO

Està fet sobre laravel 8. Només es troba la intel·ligència del programa. Principalment, el programa consta de 3 peticions, totes 
3 via post. De moment, no se l'hi ha posat cap mena de seguretat (que requereixi login). 

## Routes API

+ La primera, es per crear al tauler de joc. He pensat que seria molt interessant que l'usuari pugui triar la X i la Y. I un altre
paràmetre que seria la sessió de l'usuari. 
```
http://127.0.0.1:8000/api/partida
```
Variables post
```
x,y,sessid
```
D'aquesta manera tenim un registre constant a la base de dades de, el tauler creat amb les mides que ha l'usuari ha volgut (amb
els seus obsacles ja creats, totalment aleatòris). I una referència (sessid) de la partida.
+ El principal, que són els moviments:
```
http://127.0.0.1:8000/api/partida/moviments
```
Variables post (x i y) posicions que volguem donar-li, ens retornarà sempre els últims o últim moviment que s'hagi fet, juntament 
amb la posició actual. La 'd' és la direcció i pot contenir diferents caràcters, sempre N,S,E,W. SI n'hi ha una altre el programa no
fa res.
```
x,y,d,sessid
```
Aquí el programa està pensat de la següent manera, si es troba un obstacle o fora del mapa, retorna a la posició que està, si en té 
més per moures i pot, ho fa.
+Veure el recorregut fet.
```
http://127.0.0.1:8000/api/partida/registre
```
Només sessid
```
sessid
```
Totes retornen un json, que el front-end interpreta.
## Base de dades
S'han creat només dues taules
 + Partidas Configració del tauler i sess_id
 + Logs_partides. Tota la info de cada moviment.
 
Així d'aquesta manera podem visualitzar tot el que els usuaris han anat fent i si han recorregut tot al mapa
