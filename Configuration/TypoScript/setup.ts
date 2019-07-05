
plugin.tx_kfmobilede_kfmobileview {
    view {
        templateRootPaths.0 = EXT:kf_mobile_de/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_kfmobilede_kfmobileview.view.templateRootPath}
        partialRootPaths.0 = EXT:kf_mobile_de/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_kfmobilede_kfmobileview.view.partialRootPath}
        layoutRootPaths.0 = EXT:kf_mobile_de/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_kfmobilede_kfmobileview.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_kfmobilede_kfmobileview.persistence.storagePid}
        #recursive = 1
    }
    features {
        skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        callDefaultActionIfActionCantBeResolved = 1
    }
    settings {
        list {
            showAll         = 0
            items           = 10

            images {
                maxW        = 300c
                maxH        = 300c
                limit       = 1
            }
            options {
                use = 0

                modelDescription = Titel
                category = Karosserie
                class = Fahrzeugform
                firstRegistration = Erstzulassung
                make = Marke
                model = Model
                price = Preis
                damageAndUnrepaired = Kaputt
                accidentDamaged = Unfall Beschädigt
                roadworthy = Verkehrssicher
                priceType = Preismodel
                fuel = Kraftstoff
                gearbox = Getriebe
                color = Außenfarbe
                mileage = Laufleistung
                seats = Anzahl Sitzplätze
                doors = Anzahl Türen
                power = KW / PS
                description = Beschreibung
                emissionClass = Emissionsklasse
                misc = Sonstiges (JSON)
                consumerPriceAmount = Käuferpreis
                dealerPriceAmount = Verkäuferpreis
                creationDate = Erstellungsdatum
                modificationDate = Änderungsdatum
                detailPage = Detailseite (Mobile.de)
                importKey = Fahrzeugnummer
                importClient = Import-Key (Verkäufer)
                import = Importiert
                cubicCapacity = Hubraum
                #images = Bilder
                #features = FeaturesRepository
                #specifics = SpecificsRepository
                #seller = SellerRepository
            }

            specifics {
                use         = 0
                limit       = 7
                specifics   = specifics
            }

            features {
                use         = 0
                limit       = 7
                features    = features
            }
        }

        slider < .list
        slider {
            images {
                maxW        = 170c
                maxH        = 140
                limit       = 1
            }

            features >
            features {
                use         = 1
                limit       = 7
                features    = features
            }
        }

        detail {
            pid             = {$plugin.tx_kfmobilede_kfmobileview.settings.detailPid}
            backPid         = {$plugin.tx_kfmobilede_kfmobileview.settings.backPid}
            use             = {$plugin.tx_kfmobilede_kfmobileview.settings.detailUse}
            powermail       = {$plugin.tx_kfmobilede_kfmobileview.settings.powermailPid}
            images {
                maxW        = 600c
                maxH        = 600c
                limit       = 10
            }

            options >
            options {
                use         = 1

                model               = Model
                make                = Marke
                category            = Karosserie
                firstRegistration   = Erstzulassung
                power               = Leistung
                cubicCapacity       = Hubraum
                fuel                = Motor
                gearbox             = Getriebe
                mileage             = Laufleistung
                seats               = Anzahl Sitzplätze
                doors               = Anzahl Türen
                color               = Außenfarbe
                custom1             = Fahrzeugnummer
                emissionClass       = Schadstoffklasse
            }
        }

        search {
            data {
                select {
                    class           = Typ
                    make            = Hersteller
                    model           = Modell
                    category        = Fahrzeugform
                    fuel            = Kraftstoffart
                    gearbox         = Getriebe
                    color           = Farbe
                    power           = Leistung
                    seats           = Sitze
                }
            }
            tabs {
                basic {
                    name    = Basisdaten
                    fields  = make,model,category
                }
                engine {
                    name    = Sonstiges
                    fields  = fuel,gearbox
                }
                equipment {
                    name    = Ausstattung
                    fields  = color
                }
                simple {
                    fields = make,color,model,category,fuel
                }
            }
        }

        results < .list
        results {
            options >
            options {
                use         = 1

                mileage     = KM Stand
                power       = PS/KW
                fuel        = Kraftstoff
                importKey   = Fahrzeugnummer
                gearbox     = Getriebe
                category    = Karosserie
                seller      = Standort
            }
        }

        ajax {
            typeNum = {$plugin.tx_kfmobilede_kfmobileview.settings.ajax.typeNum}
            action = ajaxResult
            controller = Vehicle
            limit = {$plugin.tx_kfmobilede_kfmobileview.settings.ajax.limit}
        }

        googleMaps {
            key = {$plugin.tx_kfmobilede_kfmobileview.settings.googleMaps.key}
        }
    }
}

# Module configuration
module.tx_kfmobilede_web_kfmobiledekfmobileimport {
    persistence {
        storagePid = {$module.tx_kfmobilede_kfmobileimport.persistence.storagePid}
    }
    view {
        templateRootPaths.0 = EXT:kf_mobile_de/Resources/Private/Backend/Templates/
        templateRootPaths.1 = {$module.tx_kfmobilede_kfmobileimport.view.templateRootPath}
        partialRootPaths.0 = EXT:kf_mobile_de/Resources/Private/Backend/Partials/
        partialRootPaths.1 = {$module.tx_kfmobilede_kfmobileimport.view.partialRootPath}
        layoutRootPaths.0 = EXT:kf_mobile_de/Resources/Private/Backend/Layouts/
        layoutRootPaths.1 = {$module.tx_kfmobilede_kfmobileimport.view.layoutRootPath}
    }
}

page {
    includeCSS {
        tx_kfmobilede = {$plugin.tx_kfmobilede_kfmobileview.settings.css.plugin}
    }
    includeJS {
        jquery          	= {$plugin.tx_kfmobilede_kfmobileview.settings.javaScript.jQuery}
        jquery {
            if.isTrue 		= {$plugin.tx_kfmobilede_kfmobileview.settings.javaScript.includeJquery}
        }
    }

    includeJSFooter {
        jquery_easing	    = {$plugin.tx_kfmobilede_kfmobileview.settings.javaScript.jquery_easing}
        plugin_sly			= {$plugin.tx_kfmobilede_kfmobileview.settings.javaScript.plugin_sly}
        plugin_events		= {$plugin.tx_kfmobilede_kfmobileview.settings.javaScript.plugin_events}
        plugin_cookie		= {$plugin.tx_kfmobilede_kfmobileview.settings.javaScript.plugin_cookie}
        plugin_searchbox	= {$plugin.tx_kfmobilede_kfmobileview.settings.javaScript.plugin_searchbox}
        googlemaps          = https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&signed_in=true&libraries=places&key={$plugin.tx_kfmobilede_kfmobileview.settings.googleMaps.key}
        googlemaps.external = 1
    }
}




tx_kfmobilede_ajax = USER
tx_kfmobilede_ajax {
    userFunc      = TYPO3\CMS\Extbase\Core\Bootstrap->run
    vendorName = Klickfabrik
    extensionName = KfMobileDe
    pluginName = Kfmobileview
    controller = Vehicle
    action = ajaxResult
    switchableControllerActions {
        Vehicle {
            1 = ajaxResult
        }
    }

    view < plugin.tx_kfmobilede_kfmobileview.view
    persistence < plugin.tx_kfmobilede_kfmobileview.persistence
    settings < plugin.tx_kfmobilede_kfmobileview.settings
}

// PAGE object for Ajax call:
tx_kfmobilede_kfmobileview_page = PAGE
tx_kfmobilede_kfmobileview_page {
    typeNum = 1331399

    config {
        disableAllHeaderCode = 1
        additionalHeaders = Content-type:application/html
        xhtml_cleaning = 0
        debug = 0
        no_cache = 1
        admPanel = 0
        contentObjectExceptionHandler = 0
    }

    page.config.contentObjectExceptionHandler = 0

    #10 < tt_content.list.20.kfmobilede_kfmobileview
    15 < tx_kfmobilede_ajax
}