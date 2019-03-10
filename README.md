# Backport

## Getting started

```
composer requre dansan/php-backport --dev
```

Write the `backport.php` file to backport the source dir.

```php
<?php
// bin/backport.php
require __DIR__.'/../vendor/autoload.php';

$client = new \BackPort\Client();
$client
    ->setDirsToPort([
        __DIR__.'/../src',
    ])
    ->execute()
;
echo "DONE\n";
```

Move on a `*_bp` branch, launch the backport.php script, commit and push

```
git branch master_bp
git checkout master_bp
php bin/backport.php
git add .
git commit -m "backport"
git push origin master_bp
```

In composer.json of the project where you need a backported version of your module:

```
    ...
    "require": {
        ...
        "acme/my-module": "dev-master_bp@dev",
        ...
    }
    ...
```

## Develope

Per iniziare clonare e avviare il progetto, poi eseguire i test.

```
git clone git@bitbucket.org:idrolabsrl/dd-dist.git <project_dir>
cd <project_dir>
./dc up -d
./dc enter
test
```

Prima di fare `./dc up -d` è meglio fare `cp .env.dist .env` e modificare il `.env`
opportunamente.

## Introduzione

Questo modulo serve a fare il backporting di alcune funzionalità di PHP 7.0 nel modulo in cui viene usato.

Questa necessità è nata quando dopo aver realizzato un modulo (che chiameremo `Gammma`) in PHP 7.2 ci siamo resi
conto che uno degli applicativi su cui dovevamo utilizzarlo (che chiameremo `Alpha`) dipendeva
al più da PHP 7.0.

Inoltre questa dipendenza passava per un modulo intermedio (che chiameremo `Beta`).

```puml
component Gamma
component Beta
component Alpha

Alpha ..> Beta
Beta ..> Gamma
Alpha ..> Gamma
```

Tra le opzioni che si presentavano c'erano:

- Migrare `Alpha` ad una versione più recente dipendente da PHP >=7.2
- Rinunciare alle funzionalità di PHP 7.2 in `Beta` e `Gamma` 
- Mantenere le funzionalità di PHP 7.2 per tutti gli altri progetti ma scrivere uno script di backport
per `Beta` e `Gamma`


Si è scelta quest'ultima opzione perché meno invasiva e più controllable delle altre e, apparentemente,
anche più conveniente.

E' stata individuata la libreria [nikic/php-parser](https://github.com/nikic/PHP-Parser) che permette
di fare parsing del codice sorgente PHP ed intervenire sul suo AST attraverso la scrittura di visitor.

Così abbiamo potuto fare backporting delle funzionalità di PHP non supportate nella 7.0
(o meglio quelle utilizzate da noi in `Beta` e `Gamma`).


### Come si usa

L'idea è che lo sviluppo di `Beta` e `Gamma` continui come di norma sul branch `master`.

Una volta che i test sono verdi e si intende usare la nuova versione dei branch `master` di `Beta` e `Gamma` su `Alpha`
ci si sposta sul branch `master_bp` e si tenta il merge con `master`.

```
git checkout master_bp
git merge master
```

Se il numero di conflitti è gestibile si possono risolvere e procedere, altrimenti conviene eliminare `master_bp` e
ricrearlo da zero

```
git checkout master
git branch -D master_bp
git push -d origin master_bp
git checkout master_bp
```

Una volta risolti i conflitti o rigenerato il branch bisogna eseguire lo script di backport

```
php bin/backport.php
```

Lo script `bin/backport.php` è molto semplice e facile da modificare e capire perché utilizza il client
messo a disposizione da `Dan/Backport`. Ogni repo però deve definire il proprio `bin/backport.php`

Lo script blocca l'esecuzione se non ci si trova su un branch con il suffisso `_bp` per evitare di effettuare
backporting su `master` o su un feature branch o di sviluppo.

Ecco un esempio di come può essere configurato il `bin/backport.php` di `Beta`

```php
<?php
// bin/backport.php
require __DIR__.'/../vendor/autoload.php';

$client = new \BackPort\Client();
$client
    ->setProjectDir(__DIR__.'/..')
    ->setDirsToPort([
        __DIR__.'/../src',
        __DIR__.'/../tests'
    ])
    ->addComposerJsonReplacement('/"acme\/gamma": "[^@]+@dev"/', '"acme/gamma": "dev-master_bp@dev"')
    ->execute()
;
echo "DONE\n";
```

Questo script di backport fa il backporting della directory `src` e della directory `tests`,
poi aggiorna il composer.json facendo dipendere `Beta` dal branch master_bp di `Gamma` anziché da quello corrente.

Dopo aver effettuato il backport facciamo una `composer update`, lanciamo i test, facciamo commit e push.

```
composer update
test
git add .
git commit -m "backport"
git push origin master_bp
```

> Se abbiamo fatto backport di `Gamma` potrebbe essere necessario a questo punto spostarsi su `Beta`
ed eseguire la stessa procedura.

Ora sarà necessario fare `composer update` su `Alpha`.

Ricapitolando:

`Alpha` dipende da
- "php": "7.0"
- "acme/beta": "dev-master_bp@dev"
- "acme/gamma": "dev-master_bp@dev"

`Beta`
- in `master` dipende da:
    - "php": ">=7.2"
    - "acme/gamma": "dev-master@dev",
- mentre in `master_bp` dipende da:
    - "php": ">=7.0"
    - "acme/gamma": "dev-master_bp@dev",
                          
`Gamma`
- in `master` dipende da:
    - "php": ">=7.2"
- in `master_bp` dipende da:
    - "php": ">=7.0"
                          
e gli script di backport aiutano a tenere allineate queste dipendenze parallele.



### Credits

Thanks to [Matiux](https://github.com/matiux) for the Docker images used from the project


  
