## Define custom categories
# customsubcategory=kf_ajax=Ajax options
# customsubcategory=kf_google=Google Maps

plugin.tx_kfmobilede_kfmobileview {
    view {
        # cat=plugin.tx_kfmobilede_kfmobileview/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:kf_mobile_de/Resources/Private/Templates/
        # cat=plugin.tx_kfmobilede_kfmobileview/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:kf_mobile_de/Resources/Private/Partials/
        # cat=plugin.tx_kfmobilede_kfmobileview/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:kf_mobile_de/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_kfmobilede_kfmobileview//a; type=string; label=Default storage PID
        storagePid =
    }

    settings {
        # cat=plugin.tx_kfmobilede_kfmobileview/links; type=int+; label=Detail-Page-ID
        detailPid = 0

        # cat=plugin.tx_kfmobilede_kfmobileview/links; type=boolean; label=Use Detail-Page
        detailUse = 0

        # cat=plugin.tx_kfmobilede_kfmobileview/links; type=int+; label=Powermail Formular-Page
        powermailPid = 0

        # cat=plugin.tx_kfmobilede_kfmobileview/file; type=boolean; label= Include JQuery?: You can enable or disable JQuery in your project
        includeJquery = 0

        ajax {
            # cat=plugin.tx_kfmobilede_kfmobileview/kf_ajax/0001; type=int+; label=typeNum for AJAX call 
            typeNum = 1331399 

            # cat=plugin.tx_kfmobilede_kfmobileview/kf_ajax/0002; type=int+; label=Limit for AJAX Response
            limit = 20 
        }


        googleMaps {
            # cat=plugin.tx_kfmobilede_kfmobileview/kf_google/0001; type=string+; label=Google Maps API-Key
            key =
        }

        javaScript {
            # cat=plugin.tx_kfmobilede_kfmobileview/file; type=string; label=jQuery Script (1.11.2)
            jQuery 	        = EXT:kf_mobile_de/Resources/Public/Vendor/jQuery/jquery-1.11.2.min.js
            # cat=plugin.tx_kfmobilede_kfmobileview/file; type=string; label=sly 1.6.1
            sly	            = EXT:kf_mobile_de/Resources/Public/Vendor/Sly/sly.min.js
            # cat=plugin.tx_kfmobilede_kfmobileview/file; type=string; label=jQuery Easing
            jquery_easing   = EXT:kf_mobile_de/Resources/Public/Vendor/Sly/jquery.easing.min.js
            # cat=plugin.tx_kfmobilede_kfmobileview/file; type=string; label=Plugin Script
            plugin	        = EXT:kf_mobile_de/Resources/Public/JavaScript/tx_kfmobilede.js
        }
        css {
            # cat=plugin.tx_kfmobilede_kfmobileview/file; type=string; label=Plugin Stylesheet
            plugin	= EXT:kf_mobile_de/Resources/Public/Css/tx_kfmobilede.css
        }
    }
}

module.tx_kfmobilede_kfmobileimport {
    view {
        # cat=module.tx_kfmobilede_kfmobileimport/file; type=string; label=Path to template root (BE)
        templateRootPath = EXT:kf_mobile_de/Resources/Private/Backend/Templates/
        # cat=module.tx_kfmobilede_kfmobileimport/file; type=string; label=Path to template partials (BE)
        partialRootPath = EXT:kf_mobile_de/Resources/Private/Backend/Partials/
        # cat=module.tx_kfmobilede_kfmobileimport/file; type=string; label=Path to template layouts (BE)
        layoutRootPath = EXT:kf_mobile_de/Resources/Private/Backend/Layouts/
    }
    persistence {
        # cat=module.tx_kfmobilede_kfmobileimport//a; type=string; label=Default storage PID
        storagePid =
    }
}
