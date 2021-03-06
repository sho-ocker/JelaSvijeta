<b><h2>Zadatak i ciljevi</h2></b>
__________________

Potrebno je kreirati aplikaciju Jela svijeta koristeći Laravel framework (Verzija 5.0+). Ova aplikacija se sastoji od baze jela, sastojaka, kategorija i tagova. 

S obzirom da je aplikacija višejezična, jela, sastojci, kategorije i tagovi imaju tablice prijevoda. Također postoji i tablica jezika u kojoj se nalaze dostupni jezici.

Moguce koristiti Laravel Translatable paket https://github.com/Astrotomic/laravel-translatable

Tablice je potrebno kreirati korištenjem migracija.

Tablice se trebaju popuniti podatcima korištenjem seedera i paketa “Fzaninotto/faker”.

Poželjno je koristiti “Dependency Injection”. 

Cilj ovog zadatka je vidjeti koliko dobro kandidat poznaje laravel api, a pri rješavanju zadatka trebao bi se pridržavati “SOLID design principles”.

Aplikacija treba imati jedan endpoint na kojem se trebaju izlistavati jela. Koji podatci se prikazuju i kako, ovisi o parametrima u query-ju.

Pretpostavimo da sva jela imaju unesen isti broj prijevoda koji je identičan broju jezika u tablici languages.</br>
        • Jelo može biti bez kategorije, ili može pripadatati samo jednoj kategoriji</br>
        • Jelo mora imati definiran barem jedan tag</br>
        • Jelo mora imati definiran barem jedan sastojak</br>

Svi sastojci imaju isti broj prijevoda koji je identičan broju jezika u tablici languages.
Potrebno je napraviti validaciju svih parametara requesta po kojima ce se filtrirati rezultati baze.



<b><h2>Request</h2></b>
__________________

Želimo imati kontrolu nad:</br>
        • <b>per_page</b> - (optional) Broj rezultata po stranici</br>
        • <b>page</b> - (optional) broj stranice</br>
        • <b>category</b> - (optional) id kategorije po kojoj želimo filtrirati rezultate; osim id, ovaj parametar može imati vrijednost NULL (gdje ne postoji kategorija) kao i vrijednost !NULL (gdje postoji kategorija)</br>
        • <b>tags</b> - (optional) lista id-jeva po kojima želimo filtrirati rezultate (npr, tags=1,2,3). Vratiti samo jela koja imaju sve navedene tagove.</br>
        • <b>with</b> - (optional) lista ključnih riječi (ingredients, category, tags) s kojima dajemo do znanja koje dodatne podatke očekujemo u responsu</br>
        • <b>lang</b> - (required) parametar kojim definiramo jezik</br>
        • <b>diff_time</b> - (optional) UNIX Timestamp; kad je ovaj parametar proslijeđen tad je potrebno vratiti sve iteme (i one obrisane). Treba vratiti sve ne samo izmjenjene nakon datuma proslijeđenog u ovom parametru *

        * S obzirom na to da nije predviđena kreacija, ažuriranje i brisanje, nije se potrebno posebno fokusirati na razradu ove funkcionalnosti, ono što je bitno je sljedeće: kada je u requestu poslan parametar diff_time i kada je to pozitivan cijeli broj veći od 0, tada je pri selektiranju podataka iz baze potrebno uzeti u obzir sva jela (uključujući i obrisana) koja su kreirana, modificirana ili obrisana nakon datuma definiranog u tom parametru


<b><h2>Response</h2></b>
__________________

Ovdje se nalazi primjer responsa koji odgovara URL queryu:


...?per_page=5&tags=2&lang=hr&with=ingredients,category,tags&diff_time=1493902343&page=1

<pre>
{
    "meta": {
        "currentPage": 1,
        "totalItems": 10,
        "itemsPerPage": 5,
        "totalPages": 2
    },
    "data": [
        {
            "id": 1,
            "status": "modified",
            "title": "Naslov jela 1 na hr jeziku",
            "description": "Opis jela 1 na hr jeziku",
            "ingredients": [
                {
                    "id": 3,
                    "slug": "ingredient-3",
                    "title": "Naslov sastojka 3 na hr jeziku"
                },
                {
                    "id": 6,
                    "slug": "ingredient-6",
                    "title": "Naslov sastojka 6 na hr jeziku"
                },
                {
                    "id": 10,
                    "slug": "ingredient-10",
                    "title": "Naslov sastojka 10 na hr jeziku"
                }
            ],
            "category": null,
            "tags": [
                {
                    "id": 1,
                    "slug": "tag-1",
                    "title": "Naslov taga 1 na hr jeziku"
                },
                {
                    "id": 3,
                    "slug": "tag-3",
                    "title": "Naslov taga 3 na hr jeziku"
                },
                {
                    "id": 5,
                    "slug": "tag-5",
                    "title": "Naslov taga 5 na hr jeziku"
                }
            ]
        },
        {
            "id": 2,
            "status": "modified",
            "title": "Naslov jela 6 na hr jeziku",
            "description": "Opis jela 6 na hr jeziku",
            "ingredients": [
                {
                    "id": 1,
                    "slug": "ingredient-1",
                    "title": "Naslov sastojka 1 na hr jeziku"
                },
                {
                    "id": 6,
                    "slug": "ingredient-6",
                    "title": "Naslov sastojka 6 na hr jeziku"
                },
                {
                    "id": 7,
                    "slug": "ingredient-7",
                    "title": "Naslov sastojka 7 na hr jeziku"
                }
            ],
            "category": null,
            "tags": [
                {
                    "id": 1,
                    "slug": "tag-1",
                    "title": "Naslov taga 1 na hr jeziku"
                },
                {
                    "id": 2,
                    "slug": "tag-2",
                    "title": "Naslov taga 2 na hr jeziku"
                }
            ]
        },
        {
            "id": 3,
            "status": "created",
            "title": "Naslov jela 11 na hr jeziku",
            "description": "Opis jela 11 na hr jeziku",
            "ingredients": [
                {
                    "id": 5,
                    "slug": "ingredient-5",
                    "title": "Naslov sastojka 5 na hr jeziku"
                }
            ],
            "category": null,
            "tags": [
                {
                    "id": 3,
                    "slug": "tag-3",
                    "title": "Naslov taga 3 na hr jeziku"
                },
                {
                    "id": 4,
                    "slug": "tag-4",
                    "title": "Naslov taga 4 na hr jeziku"
                }
            ]
        },
        {
            "id": 4,
            "status": "created",
            "title": "Naslov jela 16 na hr jeziku",
            "description": "Opis jela 16 na hr jeziku",
            "ingredients": [
                {
                    "id": 10,
                    "slug": "ingredient-10",
                    "title": "Naslov sastojka 10 na hr jeziku"
                }
            ],
            "category": null,
            "tags": [
                {
                    "id": 2,
                    "slug": "tag-2",
                    "title": "Naslov taga 2 na hr jeziku"
                },
                {
                    "id": 5,
                    "slug": "tag-5",
                    "title": "Naslov taga 5 na hr jeziku"
                }
            ]
        },
        {
            "id": 5,
            "status": "deleted",
            "title": "Naslov jela 21 na hr jeziku",
            "description": "Opis jela 21 na hr jeziku",
            "ingredients": [
                {
                    "id": 6,
                    "slug": "ingredient-6",
                    "title": "Naslov sastojka 6 na hr jeziku"
                },
                {
                    "id": 7,
                    "slug": "ingredient-7",
                    "title": "Naslov sastojka 7 na hr jeziku"
                }
            ],
            "category": {
                "id": 4,
                "slug": "category-4",
                "title": "Naslov kategorije 4 na hr jeziku"
            },
            "tags": [
                {
                    "id": 3,
                    "slug": "tag-3",
                    "title": "Naslov taga 3 na hr jeziku"
                },
                {
                    "id": 4,
                    "slug": "tag-4",
                    "title": "Naslov taga 4 na hr jeziku"
                },
                {
                    "id": 5,
                    "slug": "tag-5",
                    "title": "Naslov taga 5 na hr jeziku"
                }
            ]
        }
    ],
    "links": {
        "prev": null,
        "next": "http:\/\/127.0.0.1:8000\/meals?diff_time=1493902343&lang=hr&page=2&per_page=5&tags=2&with=ingredients%2Ccategory%2Ctags",
        "self": "http:\/\/127.0.0.1:8000\/meals?diff_time=1493902343&lang=hr&page=1&per_page=5&tags=2&with=ingredients%2Ccategory%2Ctags"
    }
}

</pre>
__________________________________________________________________________________________________________________________

Pojašnjenje nekih podataka iz responsa:</br>
        • <b>id</b> - id jela iz tablice meals</br>
        • <b>title</b> - naziv jela iz tablice prijevoda za jelo ovisno o parametru lang</br>
        • <b>description</b> - opis jela iz tablice prijevoda za jelo ovisno o parametru lang</br>
        • <b>status</b> - zadana vrijednost je ‘created’ osim ako je u requestu proslijeđen parametar diff_time, tada status može biti jedan od created, modified, deleted ovisno o tome dali je vraćeno jelo bilo kreirano, modificirano ili obrisano nakon vremena definiranog u parametru diff_time. Manipulaciju status potrebno je izvesti putem time stampa created_at, updated_at i deleted_at (prouciti Laravel Eloquent SoftDeletes).</br>

Ovi gore spomenuti property definiraju osnovnu shemu responsa; međutim shemu responsa je moguće promijeniti (proširiti) tako da se pošalje jedan ili više ključnih riječi u parametar with, tada se u responsu na svakom objektu još mogu pojaviti i property tags, category ili/i ingredients.


U nastavku je pojašnjenje strukture ostalih objekata.

<b><h3>Category</h3></b></br>
        • <b>id</b> - id kategorije</br>
        • <b>title</b> - naziv kategorije ovisno o parametru lang</br>
        • <b>slug</b> - tekstualna unique oznaka kategorije koja ne ovisi o prijevodu</br>
<b><h3>Tags</h3></b></br>
        • <b>id</b> - id taga</br>
        • <b>title</b> - naziv taga ovisno o parametru lang</br>
        • <b>slug</b> - tekstualna unique oznaka taga koja ne ovisi o prijevodu</br>
<b><h3>Ingredients</h3></b></br>
        • <b>id</b> - id sastojka</br>
        • <b>title</b> - naziv sastojka ovisno o parametru lang</br>
        • <b>slug</b> - tekstualna unique oznaka sastojka koja ne ovisi o prijevodu</br>