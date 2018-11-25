# **
# * Title: pages
# ***********************************************
config.noPageTitle = 2

# **
# * Title: tx_kfmobilede_kfmobileview
# ***********************************************
[globalVar = GP:tx_kfmobilede_kfmobileview|vehicle > 0]
    temp.headertitle = COA
    temp.headertitle {
        10 = RECORDS
        10 {
            source = {GP:tx_kfmobilede_kfmobileview|vehicle}
            source{
                insertData = 1
                insertData {
                    intval = 1
                }
            }

            tables = tx_kfmobilede_domain_model_vehicle
            conf.tx_kfmobilede_domain_model_vehicle >
            conf.tx_kfmobilede_domain_model_vehicle = TEXT
            conf.tx_kfmobilede_domain_model_vehicle.field = model_description

            noTrimWrap= || - |
            htmlSpecialChars = 1
        }
        30 = TEXT
        30 {
            data = TSFE : tmpl | setup | sitetitle
            noTrimWrap= | - ||
            ifEmpty =
        }

        stdWrap.noTrimWrap = |    <title>|</title>||
    }
[global]






page.headerData.10 < temp.headertitle