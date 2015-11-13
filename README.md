# Backend [![SensioLabsInsight](https://insight.sensiolabs.com/projects/ad3dbb57-f080-4b64-af84-ced2fc955587/small.png)](https://insight.sensiolabs.com/projects/ad3dbb57-f080-4b64-af84-ced2fc955587)

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)
[![Build Status](https://travis-ci.org/psk-pz/Backend.svg?branch=master)](https://travis-ci.org/psk-pz/Backend)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/psk-pz/Backend/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/psk-pz/Backend/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/psk-pz/Backend/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/psk-pz/Backend/?branch=master)

Część projektu z przedmiotu *projekt zespołowy*.

**RESTful web service** enkapsulujący logikę biznesową projektu zespołowego.

Zaimplementowany za pomocą technologii *PHP* oraz framework'a *Symfony2*.

## Instalacja

Do uruchomienia projektu wymagany jest [**Vagrant**](https://www.vagrantup.com/downloads.html).

```
$ cd /sciezka/do/projektu
$ vagrant up
```

Następnie w pliku *hosts* należy dodać:

```
192.168.60.167 backend.psk-pz.dev
```

Przykładowy zasób dostępny po instalacji: *backend.psk-pz.dev/api/v1/ticket/1.json*.

## Autorzy

- [Politechnika Świętokrzyska - projekt zespołowy](https://github.com/psk-pz)
 - Daniel Iwaniec
 - Artur Kałuża
 - Karol Gos
 - Karol Gołuch

## Licencja

Projekt udostępniony na licencji **MIT**. [Zobacz pełen plik licencji](LICENSE).
