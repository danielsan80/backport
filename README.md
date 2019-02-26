# Data Dictionary (Core and Dist)


## Getting started

Per iniziare clonare e avviare il progetto, poi eseguire i test.

```
git clone git@bitbucket.org:idrolabsrl/dd-dist.git <project_dir>
cd <project_dir>
./dc up -d
./dc enter
test-all
```

Prima di fare `./dc up -d` è meglio fare `cp .env.dist .env` e modificare il `.env`
opportunamente.


Se non ci sono test `@ignored` (e ad ora non ci sono) è sufficiente eseguire `test`
anziché `test-all`.


Se si usa PhpStorm (>=2018.03), per visualizzare l'uml in PlantUML presente dei .md installare Graphviz (sulla macchina host)

```
sudo apt-get install graphviz
```





## Scaletta

Gli argomenti per da sviluppare per descrivere il DataDictionary e come funziona sono i seguenti.

- Contesti
  - DD\Core
  - DD\Dist
  - DD\Main
  - DD\Transformer
    - {\<Src>From|\<Dst>To} (es. DD\Transformer\PimFrom, DD\Transformer\AngaisaTo )
- Sottocontesti
    - Property
    - Product
    - Locale
    - Choice
    - Etim
    - IdrolabClassification
- Applicazioni e Moduli
    - Main -> Core and Dist (app)
    - Dist -> Core (module)
    - Transformer\{\<Src>From|\<Dst>To} -> Dist (module)
    - DataPool/DataSilos -> Core (and Dist?) (app)
    - Brachetti -> Dist (app)
    - ... 
- Property e PropertyType (Pim::Attribute e Pim::AttributeType)
  - Collection
  - Group
  - ...
- Product e PropertyValue (Pim::Product e Pim::ProductValue)
- ProductFacade
- ProductFacade services
  - Checker
  - Getter
  - Setter
  - Normalizer
  - PathResolver
- PropertyValue e Context
- Differenze con Akeneo
- JobMan
- Backport
- Idrolabj2.0
- Pim integration
- Etim
- LocalizableLocale
- Sf DIC per creare un Client
- I registry: perché la signature di supports() è uguale a quella di \<execute>()?
- I repository: collezioni in memoria, ma gli oggetti si referenziano tra loro, no cascade persist e remove.
- Gli EntityData
- Assert
 

## Risorse

[Uml](./doc/uml.md)
  
