<b>Zadatak i ciljevi</b>
__________________

Potrebno je kreirati aplikaciju Jela svijeta koristeći Laravel framework (Verzija 5.0+). Ova aplikacija se sastoji od baze jela, sastojaka, kategorija i tagova. S obzirom da je aplikacija višejezična, jela, sastojci, kategorije i tagovi imaju tablice prijevoda. Također postoji i tablica jezika u kojoj se nalaze dostupni jezici.
Moguce koristiti Laravel Translatable paket https://github.com/Astrotomic/laravel-translatable
Tablice je potrebno kreirati korištenjem migracija.
Tablice se trebaju popuniti podatcima korištenjem seedera i paketa “Fzaninotto/faker”.
Poželjno je koristiti “Dependency Injection”. 
Cilj ovog zadatka je vidjeti koliko dobro kandidat poznaje laravel api, a pri rješavanju zadatka trebao bi se pridržavati “SOLID design principles”.
Aplikacija treba imati jedan endpoint na kojem se trebaju izlistavati jela. Koji podatci se prikazuju i kako, ovisi o parametrima u query-ju. Pretpostavimo da sva jela imaju unesen isti broj prijevoda koji je identičan broju jezika u tablici languages.
        • Jelo može biti bez kategorije, ili može pripadatati samo jednoj kategoriji
        • Jelo mora imati definiran barem jedan tag
        • Jelo mora imati definiran barem jedan sastojak
Svi sastojci imaju isti broj prijevoda koji je identičan broju jezika u tablici languages.
Potrebno je napraviti validaciju svih parametara requesta po kojima ce se filtrirati rezultati baze.

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:


<b>Request</b>
__________________

Želimo imati kontrolu nad:
        • per_page - (optional) Broj rezultata po stranici
        • page - (optional) broj stranice
        • category - (optional) id kategorije po kojoj želimo filtrirati rezultate; osim id, ovaj parametar može imati vrijednost NULL (gdje ne postoji kategorija) kao i vrijednost !NULL (gdje postoji kategorija)
        • tags - (optional) lista id-jeva po kojima želimo filtrirati rezultate (npr, tags=1,2,3). Vratiti samo jela koja imaju sve navedene tagove.
        • with - (optional) lista ključnih riječi (ingredients, category, tags) s kojima dajemo do znanja koje dodatne podatke očekujemo u responsu
        • lang - (required) parametar kojim definiramo jezik
        • diff_time - (optional) UNIX Timestamp; kad je ovaj parametar proslijeđen tad je potrebno vratiti sve iteme (i one obrisane). Treba vratiti sve ne samo izmjenjene nakon datuma proslijeđenog u ovom parametru *

        * S obzirom na to da nije predviđena kreacija, ažuriranje i brisanje, nije se potrebno posebno fokusirati na razradu ove funkcionalnosti, ono što je bitno je sljedeće: kada je u requestu poslan parametar diff_time i kada je to pozitivan cijeli broj veći od 0, tada je pri selektiranju podataka iz baze potrebno uzeti u obzir sva jela (uključujući i obrisana) koja su kreirana, modificirana ili obrisana nakon datuma definiranog u tom parametru


<b>Response</b>
__________________

Ovdje se nalazi primjer responsa koji odgovara URL queryu:

...?per_page=5&tags=2&lang=hr&with=ingredients,category,tags&diff_time=1493902343&page=2

Pojašnjenje nekih podataka iz responsa:
        • id - id jela iz tablice meals
        • title - naziv jela iz tablice prijevoda za jelo ovisno o parametru lang
        • description - opis jela iz tablice prijevoda za jelo ovisno o parametru lang
        • status - zadana vrijednost je ‘created’ osim ako je u requestu proslijeđen parametar diff_time, tada status može biti jedan od created, modified, deleted ovisno o tome dali je vraćeno jelo bilo kreirano, modificirano ili obrisano nakon vremena definiranog u parametru diff_time. Manipulaciju status potrebno je izvesti putem time stampa created_at, updated_at i deleted_at (prouciti Laravel Eloquent SoftDeletes).

Ovi gore spomenuti property definiraju osnovnu shemu responsa; međutim shemu responsa je moguće promijeniti (proširiti) tako da se pošalje jedan ili više ključnih riječi u parametar with, tada se u responsu na svakom objektu još mogu pojaviti i property tags, category ili/i ingredients.


U nastavku je pojašnjenje strukture ostalih objekata.

<b>Category</b>
        • id - id kategorije
        • title - naziv kategorije ovisno o parametru lang
        • slug - tekstualna unique oznaka kategorije koja ne ovisi o prijevodu
<b>Tags</b>
        • id - id taga
        • title - naziv taga ovisno o parametru lang
        • slug - tekstualna unique oznaka taga koja ne ovisi o prijevodu
<b>Ingredients</b>
        • id - id sastojka
        • title - naziv sastojka ovisno o parametru lang
        • slug - tekstualna unique oznaka sastojka koja ne ovisi o prijevodu