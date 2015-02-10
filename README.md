WebAPL 1.0
===============

INFORMAȚII GENERALE
-------------------

CMS platforma WebAPL 1.0 a fost elaborată la inițiativa și în baza conceptului Proiectului USAID de Susținere a Autorităților Locale din Moldova în parteneriat cu compania EBSIntegrator SRL. 

Opiniile exprimate pe sait aparțin autorilor acestor opinii și nu reflectă neapărat poziția Agenţiei Statelor Unite pentru Dezvoltare Internaţională (USAID) sau a Guvernului SUA.

CMS platforma WebAPL a fost concepută pentru crearea și administrarea saiturilor instituțiilor Administrației Publice Locale (APL). 

Platforma WebAPL este un produs software cu codul sursă deschis (open source). 

Acest produs se distribuie gratuit cu licența liberă GPL3 (http://opensource.org/licenses/GPL-3.0) ceea ce înseamnă că platforma WebAPL  poate fi descărcată, adaptată și utilizată în mod gratuit, cu condiția respectării licenței GPL3. 

În același timp se permite crearea de versiuni noi și/sau derivate prin modificarea și îmbunătățirea codului platformei WebAPL precum și distribuirea acestora, cu condiția că vor avea aceeași licență GPL3 (http://opensource.org/licenses/GPL-3.0), fiind astfel păstrat caracterul deschis (open source) al acestui produs.


CERINȚE MINIME DE SISTEM SOLICITATE
-------------------

1. PHP >= 5.4
2. MCrypt PHP Extension
3. MySQL Database
4. PDO MySQL PHP Extension
5. SpatȚiu de stocare pe server de minim 200Mb


INFORMAȚIILE DE MAI JOS REFLECTĂ UN MIC GHID DE INSTALARE A PLATFORMEI DESTINAT INCLUSIV PERSOANELOR CU CUNOȘTINȚE MINME ÎN UTILIZAREA UNOR ASEMENEA INSTRUMENTE
--------------

**Pasul 1. Se verifică disponibilitatea datelor de acces**

Pentru a instala platforma WebApl 1.0 pe un hosting si a demara actiunea de instalare a site-ului lansat în baza platformei e necesar sa dispuneți de câteva date:
	
1. sa aveti un nume de domen ex. www.domenulmeu.md
2. sa aveti un server pe care se plaseaza site-ul, de obice un hosting al unei companii ce presteaza servicii de hosting
3. compania care va ofera servicii de hosting va trebui sa va dea dreptul de acces la panoul de adminisrare al hostingului dat.
4. In cazul in care numele de domen nu e conextat de hosting, e necesar sa il conectati, adica sa modificati DNS-urile la site conform setarilor comunicate de compania de hosting.
5. E necesar sa creati un FTP account cu nume si parola pe hostingul de care dispuneti, conectat la numele de domen
6. E necesar sa creati un nume de utilizator cu parola pentru baza de date
7. E necesar sa aveti o baza de date MySQL creata pe hosting si sa o atribuiti la utilizatorul bazei de date creat.

**Pasul 2. Încarcarea fisierelor platformei WebAPL 1.0. pe hosting**

1. Lansati programul FileZilla sau un alt program similar de transfer a datelor de pe calculator pe server
2. Completati datele de acces in Quickconnect bar, inclusiv 
--- Host(de obicei numele de domen sau IP-ul indicat de compania furnizoare de hosting). 
--- Username (numele utilizatorului FTP), 
--- Password (parola la contul FTP) 
3. Se vor incarca fisierele din Mapa WebAPL 1.0. pe hosting.
4. Pentru lasarea aplicatiei instal se vor cauta urmatoarele dosare incarcate pe hosting
--- /apps/frontend/storage/
--- /apps/backend/storage/
--- /upload/
--- /install/
--- /apps/frontend/config/
--- /apps/backend/config/
si li se va da permisiunea de Citire, scriere si exectie (numeric value 777)
5. se va lansa o pagina noua si se va initia instalarea platformei pe domenul creat (ex. www.domenulmeu.md)
6. Pasii de instalare a platformei se vor urma urma conform indicațiilor ce apar și recomandărilor din Manualul de Utilizare al WebAPL 1.0.
